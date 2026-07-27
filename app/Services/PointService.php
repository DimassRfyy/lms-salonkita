<?php

namespace App\Services;

use App\Models\PointTransaction;
use App\Models\RewardItem;
use App\Models\RewardRedemption;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PointService
{
    /**
     * Award points to a user from a given source model.
     */
    public function awardPoints(User $user, int $amount, Model $source, string $description): PointTransaction
    {
        return DB::transaction(function () use ($user, $amount, $source, $description) {
            // Check for duplicate award from same source
            $existing = PointTransaction::query()
                ->where('user_id', $user->id)
                ->where('source_type', get_class($source))
                ->where('source_id', $source->getKey())
                ->where('type', PointTransaction::TYPE_EARN)
                ->first();

            if ($existing) {
                return $existing;
            }

            /** @var User $lockedUser */
            $lockedUser = User::query()->where('id', $user->id)->lockForUpdate()->first();
            $currentBalance = (int) ($lockedUser->points_balance ?? 0);
            $newBalance = $currentBalance + $amount;

            $pointTransaction = PointTransaction::create([
                'user_id' => $lockedUser->id,
                'type' => PointTransaction::TYPE_EARN,
                'amount' => $amount,
                'balance_after' => $newBalance,
                'source_type' => get_class($source),
                'source_id' => $source->getKey(),
                'description' => $description,
            ]);

            $lockedUser->update(['points_balance' => $newBalance]);

            return $pointTransaction;
        });
    }

    /**
     * Process point redemption for an item.
     */
    public function redeemItem(User $user, RewardItem $item): RewardRedemption
    {
        return DB::transaction(function () use ($user, $item) {
            /** @var User $lockedUser */
            $lockedUser = User::query()->where('id', $user->id)->lockForUpdate()->first();
            /** @var RewardItem $lockedItem */
            $lockedItem = RewardItem::query()->where('id', $item->id)->lockForUpdate()->first();

            if (! $lockedItem || ! $lockedItem->is_active) {
                throw new Exception("Item hadiah ini sedang tidak aktif atau tidak ditemukan.");
            }

            if ($lockedItem->stock !== null && $lockedItem->stock <= 0) {
                throw new Exception("Stok item hadiah ini telah habis.");
            }

            if ((int) $lockedUser->points_balance < (int) $lockedItem->points_required) {
                throw new Exception("Poin Anda tidak mencukupi untuk menukarkan item ini.");
            }

            $pointsSpent = (int) $lockedItem->points_required;
            $newBalance = (int) $lockedUser->points_balance - $pointsSpent;

            if ($lockedItem->stock !== null) {
                $lockedItem->decrement('stock');
            }

            $redemptionCode = 'RDM-' . Str::upper(Str::random(8));

            $redemption = RewardRedemption::create([
                'user_id' => $lockedUser->id,
                'reward_item_id' => $lockedItem->id,
                'points_spent' => $pointsSpent,
                'status' => 'COMPLETED',
                'redemption_code' => $redemptionCode,
                'used_at' => now(),
            ]);

            PointTransaction::create([
                'user_id' => $lockedUser->id,
                'type' => PointTransaction::TYPE_REDEEM,
                'amount' => -$pointsSpent,
                'balance_after' => $newBalance,
                'source_type' => RewardRedemption::class,
                'source_id' => $redemption->id,
                'description' => "Penukaran Poin: {$lockedItem->name}",
            ]);

            $lockedUser->update(['points_balance' => $newBalance]);

            return $redemption;
        });
    }
}
