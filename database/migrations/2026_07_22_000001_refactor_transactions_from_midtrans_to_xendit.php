<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table): void {
            $table->string('xendit_id')->nullable()->after('payment_method');
            $table->text('invoice_url')->nullable()->after('xendit_id');
            $table->json('xendit_raw_response')->nullable()->after('status');
        });

        Schema::table('transactions', function (Blueprint $table): void {
            $columnsToDrop = [];
            foreach (['snap_token', 'snap_redirect_url', 'midtrans_transaction_id', 'midtrans_fraud_status', 'midtrans_raw_response'] as $column) {
                if (Schema::hasColumn('transactions', $column)) {
                    $columnsToDrop[] = $column;
                }
            }

            if ($columnsToDrop !== []) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table): void {
            $table->string('snap_token')->nullable();
            $table->text('snap_redirect_url')->nullable();
            $table->string('midtrans_transaction_id')->nullable();
            $table->string('midtrans_fraud_status')->nullable();
            $table->json('midtrans_raw_response')->nullable();

            $table->dropColumn(['xendit_id', 'invoice_url', 'xendit_raw_response']);
        });
    }
};
