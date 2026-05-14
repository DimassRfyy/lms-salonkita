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
        Schema::create('course_video_quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_video_quiz_id')->constrained('course_video_quizzes')->cascadeOnDelete();
            $table->text('question');
            $table->timestamps();

            $table->index(['course_video_quiz_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_video_quiz_questions');
    }
};