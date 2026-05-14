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
        Schema::create('course_video_quiz_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_video_id')->constrained('course_videos')->cascadeOnDelete();
            $table->foreignId('course_video_quiz_id')->constrained('course_video_quizzes')->cascadeOnDelete();
            $table->unsignedTinyInteger('score')->default(0);
            $table->boolean('is_passed')->default(false);
            $table->timestamp('completed_at');
            $table->timestamps();

            $table->unique(['user_id', 'course_video_quiz_id'], 'quiz_comp_user_quiz_unique');
            $table->index(['user_id', 'course_id']);
            $table->index(['course_id', 'course_video_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_video_quiz_completions');
    }
};