<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table): void {
            $table->string('snap_token')->nullable()->after('proof_of_payment');
            $table->text('snap_redirect_url')->nullable()->after('snap_token');
            $table->string('midtrans_transaction_id')->nullable()->after('is_paid');
            $table->string('midtrans_transaction_status')->nullable()->after('midtrans_transaction_id');
            $table->string('midtrans_fraud_status')->nullable()->after('midtrans_transaction_status');
            $table->json('midtrans_raw_response')->nullable()->after('midtrans_fraud_status');
            $table->timestamp('paid_at')->nullable()->after('discount_amount');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table): void {
            $table->dropColumn([
                'snap_token',
                'snap_redirect_url',
                'midtrans_transaction_id',
                'midtrans_transaction_status',
                'midtrans_fraud_status',
                'midtrans_raw_response',
                'paid_at',
            ]);
        });
    }
};
