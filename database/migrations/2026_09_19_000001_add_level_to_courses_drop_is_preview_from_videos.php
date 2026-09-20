<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menambahkan kolom 'level' (basic/intermediate/advanced) pada tabel courses
     * dengan default 'intermediate' agar semua course existing tetap berbayar.
     *
     * Menghapus kolom 'is_preview' dari course_videos karena fitur video preview
     * gratis digantikan oleh sistem level kelas (basic = akses gratis semua video).
     */
    public function up(): void
    {
        if (! Schema::hasColumn('courses', 'level')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->enum('level', ['basic', 'intermediate', 'advanced'])
                    ->default('intermediate')
                    ->after('is_published');
            });
        }

        if (Schema::hasColumn('course_videos', 'is_preview')) {
            Schema::table('course_videos', function (Blueprint $table) {
                $table->dropColumn('is_preview');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('courses', 'level')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->dropColumn('level');
            });
        }

        if (! Schema::hasColumn('course_videos', 'is_preview')) {
            Schema::table('course_videos', function (Blueprint $table) {
                $table->boolean('is_preview')->default(false)->after('video_url');
            });
        }
    }
};
