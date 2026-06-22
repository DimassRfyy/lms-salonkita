<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table): void {
            $table->string('status')->default('pending')->after('midtrans_transaction_id');
        });

        Schema::table('transactions', function (Blueprint $table): void {
            if (Schema::hasColumn('transactions', 'proof_of_payment')) {
                $table->dropColumn('proof_of_payment');
            }

            if (Schema::hasColumn('transactions', 'is_paid')) {
                $table->dropColumn('is_paid');
            }

            if (Schema::hasColumn('transactions', 'midtrans_transaction_status')) {
                $table->dropColumn('midtrans_transaction_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table): void {
            $table->dropColumn('status');
        });

        Schema::table('transactions', function (Blueprint $table): void {
            $table->string('proof_of_payment')->nullable()->after('payment_method');
            $table->boolean('is_paid')->default(false)->after('proof_of_payment');
            $table->string('midtrans_transaction_status')->nullable()->after('midtrans_transaction_id');
        });
    }
};
