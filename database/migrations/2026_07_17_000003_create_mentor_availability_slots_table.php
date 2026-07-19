<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mentor_availability_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_id');
            $table->foreign('mentor_id', 'mentor_slot_mentor_fk')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('mentor_availability_template_id')->nullable();
            $table->foreign(
                'mentor_availability_template_id',
                'mentor_slot_tpl_fk'
            )->references('id')->on('mentor_availability_templates')->nullOnDelete();
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->string('status')->default('available');
            $table->string('meeting_platform')->nullable();
            $table->string('meeting_url')->nullable();
            $table->timestamps();

            $table->unique(['mentor_id', 'starts_at', 'ends_at'], 'mentor_slot_unique');
            $table->index(['mentor_id', 'status', 'starts_at'], 'mentor_slot_status_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mentor_availability_slots');
    }
};