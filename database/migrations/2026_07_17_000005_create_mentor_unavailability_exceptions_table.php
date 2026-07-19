<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mentor_unavailability_exceptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_id')->constrained('users')->cascadeOnDelete();
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->string('reason')->nullable();
            $table->string('type')->default('blocked');
            $table->timestamps();

            $table->index(['mentor_id', 'starts_at', 'ends_at'], 'mentor_unavail_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mentor_unavailability_exceptions');
    }
};