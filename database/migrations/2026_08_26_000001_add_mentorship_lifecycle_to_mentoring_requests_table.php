<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mentoring_requests', function (Blueprint $table) {
            $table->text('termination_reason')->nullable()->after('rejection_reason');
            $table->timestamp('terminated_at')->nullable()->after('reviewed_at');
            $table->string('terminated_by', 30)->nullable()->after('terminated_at'); // student, admin, mentor
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mentoring_requests', function (Blueprint $table) {
            $table->dropColumn(['termination_reason', 'terminated_at', 'terminated_by']);
        });
    }
};
