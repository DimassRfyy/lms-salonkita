<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mentor_availability_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('day_of_week');
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedSmallInteger('slot_duration_minutes')->default(60);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['mentor_id', 'day_of_week', 'start_time', 'end_time'], 'mentor_avail_tpl_unique');
            $table->index(['mentor_id', 'day_of_week', 'is_active'], 'mentor_avail_tpl_active_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mentor_availability_templates');
    }
};