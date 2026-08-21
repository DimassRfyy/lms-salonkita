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
        Schema::table('courses', function (Blueprint $table) {
            $table->text('task_description')->nullable()->after('presentation_url');
        });

        Schema::table('course_task_submissions', function (Blueprint $table) {
            $table->text('feedback')->nullable()->after('score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('task_description');
        });

        Schema::table('course_task_submissions', function (Blueprint $table) {
            $table->dropColumn('feedback');
        });
    }
};
