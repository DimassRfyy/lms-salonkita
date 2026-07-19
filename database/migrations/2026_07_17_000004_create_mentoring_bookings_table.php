<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mentoring_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentoring_entitlement_id');
            $table->foreign('mentoring_entitlement_id', 'ment_booking_ent_fk')->references('id')->on('mentoring_entitlements')->cascadeOnDelete();
            $table->foreignId('mentor_id');
            $table->foreign('mentor_id', 'ment_booking_mentor_fk')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('student_id');
            $table->foreign('student_id', 'ment_booking_student_fk')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('course_id');
            $table->foreign('course_id', 'ment_booking_course_fk')->references('id')->on('courses')->cascadeOnDelete();
            $table->foreignId('mentor_availability_slot_id');
            $table->foreign('mentor_availability_slot_id', 'ment_booking_slot_fk')->references('id')->on('mentor_availability_slots')->cascadeOnDelete();
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->string('status')->default('confirmed');
            $table->string('meeting_platform')->nullable();
            $table->string('meeting_url')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('booked_at')->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique('mentoring_entitlement_id', 'ment_booking_ent_unique');
            $table->unique('mentor_availability_slot_id', 'ment_booking_slot_unique');
            $table->index(['mentor_id', 'student_id', 'status'], 'ment_booking_user_status_idx');
            $table->index(['course_id', 'starts_at'], 'ment_booking_course_start_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mentoring_bookings');
    }
};