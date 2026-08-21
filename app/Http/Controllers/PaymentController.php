<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\PromoCode;
use App\Models\PromoCodeRedemption;
use App\Models\Transaction;
use App\Models\User;
use App\Services\PointService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

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

        // Sementara: Payment Gateway sedang maintenance, hanya izinkan transaksi diskon 100%
        if ($finalPrice > 0) {
            return redirect()
                ->route('transaction', ['course' => $course->slug])
                ->withErrors(['payment' => 'Saat ini pembayaran kelas belum bisa dilakukan karena sistem payment gateway sedang dalam pemeliharaan (maintenance). Pembelian hanya dapat dilakukan jika memasukkan kode promo diskon 100%.'])
                ->withInput();
        }

        $transaction = Transaction::query()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'promo_code_id' => $promoCode?->id,
            'payment_method' => 'free',
            'discount_amount' => $discountAmount,
            'price' => 0,
            'status' => Transaction::STATUS_PENDING,
        ]);

        $this->markTransactionAsPaid($transaction);

        return redirect()
            ->route('course', ['slug' => $course->slug])
            ->with('success', 'Yey, pembayaranmu berhasil! Kelasnya sudah bisa diakses, ya.');

        /*
        // Kode Xendit dinonaktifkan sementara selama masa maintenance
        $secretKey = (string) config('services.xendit.secret_key');

        if ($secretKey === '') {
            return redirect()
                ->route('transaction', ['course' => $course->slug])
                ->withErrors(['payment' => 'Konfigurasi Xendit belum diatur di server (XENDIT_SECRET_KEY).'])
                ->withInput();
        }

        $invoicePayload = [
            'external_id' => $transaction->trx_id,
            'amount' => $finalPrice,
            'payer_email' => $user->email,
            'description' => 'Pembelian kelas: ' . mb_substr($course->name, 0, 100),
            'success_redirect_url' => route('payments.xendit.finish', ['order_id' => $transaction->trx_id]),
            'failure_redirect_url' => route('payments.xendit.error', ['order_id' => $transaction->trx_id]),
            'currency' => 'IDR',
        ];

        try {
            $response = Http::withBasicAuth($secretKey, '')
                ->post('https://api.xendit.co/v2/invoices', $invoicePayload);

            if (! $response->successful()) {
                logger()->error('Xendit Invoice Creation Failed', ['response' => $response->json()]);

                return redirect()
                    ->route('transaction', ['course' => $course->slug])
                    ->withErrors(['payment' => 'Gagal membuat tagihan pembayaran Xendit. Silakan coba beberapa saat lagi.'])
                    ->withInput();
            }

            $invoiceData = $response->json();
        } catch (\Throwable $exception) {
            report($exception);

            return redirect()
                ->route('transaction', ['course' => $course->slug])
                ->withErrors(['payment' => 'Terjadi kesalahan sistem saat menghubungkan ke Xendit.'])
                ->withInput();
        }

        $transaction->update([
            'xendit_id' => (string) ($invoiceData['id'] ?? ''),
            'invoice_url' => (string) ($invoiceData['invoice_url'] ?? ''),
            'xendit_raw_response' => $invoiceData,
        ]);

        if (! empty($invoiceData['invoice_url'])) {
            return redirect()->away($invoiceData['invoice_url']);
        }

        return redirect()
            ->route('transaction', ['course' => $course->slug])
            ->with('success', 'Tagihan pembayaran berhasil dibuat.');
        */
    }

    public function notification(Request $request): JsonResponse
    {
        $webhookToken = (string) config('services.xendit.webhook_token');
        $callbackToken = (string) $request->header('x-callback-token', '');

        if ($webhookToken !== '' && ! hash_equals($webhookToken, $callbackToken)) {
            return response()->json(['message' => 'Invalid callback token'], 403);
        }

        $payload = $request->json()->all();

        if (! is_array($payload) || ! isset($payload['external_id'])) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        /** @var Transaction|null $transaction */
        $transaction = Transaction::query()
            ->where('trx_id', (string) $payload['external_id'])
            ->first();

        if (! $transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $rawStatus = (string) ($payload['status'] ?? 'PENDING');
        $statusUpper = mb_strtoupper($rawStatus);

        $transaction->update([
            'payment_method' => (string) ($payload['payment_method'] ?? $payload['payment_channel'] ?? $transaction->payment_method ?? 'xendit'),
            'xendit_id' => (string) ($payload['id'] ?? $transaction->xendit_id ?? ''),
            'status' => $statusUpper,
            'xendit_raw_response' => $payload,
        ]);

        if (in_array($statusUpper, ['PAID', 'SETTLED'], true)) {
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
            $updates['status'] = Transaction::STATUS_SETTLED;
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

        if ($transaction->student) {
            $courseName = $transaction->course->name ?? 'Kelas';
            app(PointService::class)->awardPoints(
                user: $transaction->student,
                amount: 50,
                source: $transaction,
                description: "Bonus +50 Poin dari pembelian {$courseName}"
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
