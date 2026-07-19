<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mentoring_entitlements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('total_quota')->default(1);
            $table->unsignedSmallInteger('used_quota')->default(0);
            $table->string('status')->default('active');
            $table->timestamp('granted_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->unique('transaction_id');
            $table->index(['student_id', 'course_id'], 'ment_ent_student_course_idx');
            $table->index(['status', 'expires_at'], 'ment_ent_status_expires_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mentoring_entitlements');
    }
};