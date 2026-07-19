<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\PromoCode;
use App\Models\PromoCodeRedemption;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function transaction(Request $request)
    {
        $courseSlug = (string) $request->query('course');

        abort_if($courseSlug === '', 404);

        $course = Course::query()
            ->with('category')
            ->withCount('videos')
            ->withSum('videos as total_duration_seconds', 'duration_seconds')
            ->where('is_published', true)
            ->where('slug', $courseSlug)
            ->firstOrFail();

        return view('pages.transaction', compact('course'));
    }

    public function storeTransaction(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        $validated = $request->validate([
            'course_id' => ['required', 'integer', 'exists:courses,id'],
            'promo_code' => ['nullable', 'string', 'max:50'],
        ]);

        $course = Course::query()
            ->where('is_published', true)
            ->findOrFail((int) $validated['course_id']);

        if ($user->ownedCourses()->where('courses.id', $course->id)->exists()) {
            return redirect()
                ->route('course', ['slug' => $course->slug])
                ->with('success', 'Kelas sudah kamu miliki.');
        }

        [$promoCode, $discountAmount] = $this->resolvePromoCode((string) ($validated['promo_code'] ?? ''), (int) $course->price);

        if ((string) ($validated['promo_code'] ?? '') !== '' && ! $promoCode) {
            return back()
                ->withErrors(['promo_code' => 'Kode promo tidak valid atau sudah tidak aktif.'])
                ->withInput();
        }

        $finalPrice = max((int) $course->price - $discountAmount, 0);

        $transaction = Transaction::query()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'promo_code_id' => $promoCode?->id,
            'payment_method' => $finalPrice <= 0 ? 'free' : 'midtrans',
            'discount_amount' => $discountAmount,
            'price' => $finalPrice,
            'status' => Transaction::STATUS_PENDING,
        ]);

        if ($finalPrice <= 0) {
            $this->markTransactionAsPaid($transaction);

            return redirect()
                ->route('course', ['slug' => $course->slug])
                ->with('success', 'Pembelian berhasil diproses. Kelas langsung aktif.');
        }

        $this->configureMidtrans();

        $snapPayload = [
            'transaction_details' => [
                'order_id' => $transaction->trx_id,
                'gross_amount' => $finalPrice,
            ],
            'item_details' => [[
                'id' => (string) $course->id,
                'price' => $finalPrice,
                'quantity' => 1,
                'name' => mb_substr($course->name, 0, 50),
            ]],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->whatsapp_number,
            ],
            'callbacks' => [
                'finish' => route('payments.midtrans.finish', ['order_id' => $transaction->trx_id]),
                'unfinish' => route('payments.midtrans.unfinish', ['order_id' => $transaction->trx_id]),
                'error' => route('payments.midtrans.error', ['order_id' => $transaction->trx_id]),
            ],
            'custom_field1' => (string) $transaction->id,
        ];

        try {
            $snapResponse = Snap::createTransaction($snapPayload);
        } catch (\Throwable $exception) {
            report($exception);

            return redirect()
                ->route('transaction', ['course' => $course->slug])
                ->withErrors(['payment' => 'Gagal membuat sesi pembayaran Midtrans. Pastikan konfigurasi Midtrans sudah benar.'])
                ->withInput();
        }

        $transaction->update([
            'snap_token' => (string) ($snapResponse->token ?? ''),
            'snap_redirect_url' => (string) ($snapResponse->redirect_url ?? ''),
        ]);

        return redirect()
            ->route('transaction', ['course' => $course->slug])
            ->with('snap_token', $transaction->snap_token)
            ->with('trx_id', $transaction->trx_id)
            ->with('success', 'Lanjutkan pembayaran di Midtrans.');
    }

    public function notification(Request $request): JsonResponse
    {
        $payload = $request->json()->all();

        if (! is_array($payload) || ! isset($payload['order_id'], $payload['status_code'], $payload['gross_amount'], $payload['signature_key'])) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        $serverKey = (string) config('services.midtrans.server_key');

        $expectedSignature = hash(
            'sha512',
            (string) $payload['order_id'] . (string) $payload['status_code'] . (string) $payload['gross_amount'] . $serverKey
        );

        if (! hash_equals($expectedSignature, (string) $payload['signature_key'])) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        /** @var Transaction|null $transaction */
        $transaction = Transaction::query()
            ->where('trx_id', (string) $payload['order_id'])
            ->first();

        if (! $transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $transactionStatus = (string) ($payload['transaction_status'] ?? 'pending');
        $fraudStatus = (string) ($payload['fraud_status'] ?? '');

        $transaction->update([
            'payment_method' => (string) ($payload['payment_type'] ?? $transaction->payment_method ?? 'midtrans'),
            'midtrans_transaction_id' => (string) ($payload['transaction_id'] ?? ''),
            'status' => $transactionStatus,
            'midtrans_fraud_status' => $fraudStatus,
            'midtrans_raw_response' => $payload,
        ]);

        if ($transactionStatus === Transaction::STATUS_SETTLEMENT || ($transactionStatus === Transaction::STATUS_CAPTURE && $fraudStatus === 'accept')) {
            $this->markTransactionAsPaid($transaction->fresh());
        }

        return response()->json(['message' => 'OK']);
    }

    public function finish(Request $request): RedirectResponse
    {
        return $this->redirectByOrderId((string) $request->query('order_id'), 'Pembayaran selesai. Kami sedang sinkronisasi status pembayaran.');
    }

    public function unfinish(Request $request): RedirectResponse
    {
        return $this->redirectByOrderId((string) $request->query('order_id'), 'Pembayaran belum selesai. Kamu bisa lanjutkan kapan saja.');
    }

    public function error(Request $request): RedirectResponse
    {
        return $this->redirectByOrderId((string) $request->query('order_id'), 'Terjadi kendala saat pembayaran. Silakan coba lagi.');
    }

    private function configureMidtrans(): void
    {
        Config::$serverKey = (string) config('services.midtrans.server_key');
        Config::$clientKey = (string) config('services.midtrans.client_key');
        Config::$isProduction = (bool) config('services.midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    private function resolvePromoCode(string $promoCodeInput, int $coursePrice): array
    {
        $normalizedCode = mb_strtoupper(trim($promoCodeInput));
        if ($normalizedCode === '') {
            return [null, 0];
        }

        $promoCode = PromoCode::query()
            ->whereRaw('UPPER(code) = ?', [$normalizedCode], 'and')
            ->where('is_active', true)
            ->first();

        if (! $promoCode) {
            return [null, 0];
        }

        $discountAmount = $promoCode->type === 'percentage'
            ? (int) round($coursePrice * ((int) $promoCode->value / 100))
            : (int) $promoCode->value;

        return [$promoCode, min(max($discountAmount, 0), $coursePrice)];
    }

    private function markTransactionAsPaid(Transaction $transaction): void
    {
        $updates = [];

        if (! $transaction->paid_at) {
            $updates['paid_at'] = now();
        }

        if ($transaction->status === Transaction::STATUS_PENDING) {
            $updates['status'] = Transaction::STATUS_SETTLEMENT;
        }

        if ($updates !== []) {
            $transaction->update($updates);
        }

        $transaction->student?->ownedCourses()->syncWithoutDetaching([$transaction->course_id]);
        $this->grantMentoringEntitlement($transaction);

        if ($transaction->promo_code_id && $transaction->discount_amount > 0) {
            PromoCodeRedemption::query()->updateOrCreate(
                ['transaction_id' => $transaction->id],
                [
                    'promo_code_id' => $transaction->promo_code_id,
                    'user_id' => $transaction->user_id,
                    'discount_amount' => (int) $transaction->discount_amount,
                ]
            );
        }
    }

    private function grantMentoringEntitlement(Transaction $transaction): void
    {
        if (! $transaction->student || ! $transaction->course_id) {
            return;
        }

        $transaction->mentoringEntitlement()->updateOrCreate(
            ['transaction_id' => $transaction->id],
            [
                'student_id' => $transaction->user_id,
                'course_id' => $transaction->course_id,
                'total_quota' => 1,
                'used_quota' => 0,
                'status' => 'active',
                'granted_at' => now(),
                'expires_at' => null,
            ]
        );
    }

    private function redirectByOrderId(string $orderId, string $message): RedirectResponse
    {
        $fallbackUrl = route('dashboard');
        if ($orderId === '') {
            return redirect()->to($fallbackUrl)->with('success', $message);
        }

        /** @var Transaction|null $transaction */
        $transaction = Transaction::query()->where('trx_id', $orderId)->first();

        if (! $transaction || ! $transaction->course) {
            return redirect()->to($fallbackUrl)->with('success', $message);
        }

        if ($transaction->isPaid()) {
            return redirect()
                ->route('course', ['slug' => $transaction->course->slug])
                ->with('success', 'Pembayaran berhasil. Kelas sudah aktif.');
        }

        return redirect()
            ->route('transaction', ['course' => $transaction->course->slug])
            ->with('success', $message);
    }
}
