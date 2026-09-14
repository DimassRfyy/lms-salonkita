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
        Schema::table('achievements', function (Blueprint $table) {
            $table->enum('level', ['beginner', 'intermediate', 'expert'])
                ->default('beginner')
                ->after('slug');

            $table->enum('category', ['course_completion', 'learning_activity', 'assignment_completion'])
                ->default('course_completion')
                ->after('level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achievements', function (Blueprint $table) {
            $table->dropColumn(['level', 'category']);
        });
    }
};
