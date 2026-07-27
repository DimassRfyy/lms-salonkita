<?php

namespace App\Http\Controllers;

use App\Models\RewardItem;
use App\Services\PointService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PointController extends Controller
{
    /**
     * Display student point balance, available reward items, and point transaction history.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $user->load([
            'pointTransactions' => fn ($q) => $q->latest(),
            'rewardRedemptions' => fn ($q) => $q->with('rewardItem')->latest(),
        ]);

        $rewardItems = RewardItem::query()
            ->where('is_active', true)
            ->orderBy('points_required', 'asc')
            ->get();

        return view('pages.points', [
            'user' => $user,
            'pointsBalance' => (int) ($user->points_balance ?? 0),
            'rewardItems' => $rewardItems,
            'pointTransactions' => $user->pointTransactions,
            'rewardRedemptions' => $user->rewardRedemptions,
        ]);
    }

    /**
     * Process point redemption.
     */
    public function redeem(Request $request, RewardItem $rewardItem): RedirectResponse
    {
        $user = $request->user();

        try {
            $redemption = app(PointService::class)->redeemItem($user, $rewardItem);

            return redirect()
                ->route('points.index')
                ->with('success', "Selamat! Kamu berhasil menukarkan {$rewardItem->points_required} Poin untuk '{$rewardItem->name}'. Kode Klaim: {$redemption->redemption_code}");
        } catch (Exception $e) {
            return redirect()
                ->route('points.index')
                ->with('error', $e->getMessage());
        }
    }
}
