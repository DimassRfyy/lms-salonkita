<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('course_sections', 'sort_order')) {
            Schema::table('course_sections', function (Blueprint $table) {
                $table->unsignedInteger('sort_order')->default(0)->after('title');
                $table->index(['course_id', 'sort_order']);
            });

            // Backfill existing sections
            $sections = DB::table('course_sections')->orderBy('course_id')->orderBy('id')->get();
            $courseSectionCounter = [];
            foreach ($sections as $section) {
                $cId = $section->course_id;
                $courseSectionCounter[$cId] = ($courseSectionCounter[$cId] ?? 0) + 1;
                DB::table('course_sections')->where('id', $section->id)->update([
                    'sort_order' => $courseSectionCounter[$cId],
                ]);
            }
        }

        if (! Schema::hasColumn('course_videos', 'sort_order')) {
            Schema::table('course_videos', function (Blueprint $table) {
                $table->unsignedInteger('sort_order')->default(0)->after('duration_seconds');
                $table->index(['course_section_id', 'sort_order']);
            });

            // Backfill existing videos
            $videos = DB::table('course_videos')->orderBy('course_section_id')->orderBy('id')->get();
            $sectionVideoCounter = [];
            foreach ($videos as $video) {
                $sId = $video->course_section_id;
                $sectionVideoCounter[$sId] = ($sectionVideoCounter[$sId] ?? 0) + 1;
                DB::table('course_videos')->where('id', $video->id)->update([
                    'sort_order' => $sectionVideoCounter[$sId],
                ]);
            }
        }

        if (! Schema::hasColumn('course_keypoints', 'sort_order')) {
            Schema::table('course_keypoints', function (Blueprint $table) {
                $table->unsignedInteger('sort_order')->default(0)->after('point');
                $table->index(['course_id', 'sort_order']);
            });

            // Backfill existing keypoints
            $keypoints = DB::table('course_keypoints')->orderBy('course_id')->orderBy('id')->get();
            $courseKeypointCounter = [];
            foreach ($keypoints as $kp) {
                $cId = $kp->course_id;
                $courseKeypointCounter[$cId] = ($courseKeypointCounter[$cId] ?? 0) + 1;
                DB::table('course_keypoints')->where('id', $kp->id)->update([
                    'sort_order' => $courseKeypointCounter[$cId],
                ]);
            }
        }

        if (! Schema::hasColumn('mentoring_bookings', 'feedback')) {
            Schema::table('mentoring_bookings', function (Blueprint $table) {
                $table->text('feedback')->nullable()->after('notes');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('mentoring_bookings', 'feedback')) {
            Schema::table('mentoring_bookings', function (Blueprint $table) {
                $table->dropColumn('feedback');
            });
        }

        if (Schema::hasColumn('course_sections', 'sort_order')) {
            Schema::table('course_sections', function (Blueprint $table) {
                $table->dropIndex(['course_id', 'sort_order']);
                $table->dropColumn('sort_order');
            });
        }

        if (Schema::hasColumn('course_videos', 'sort_order')) {
            Schema::table('course_videos', function (Blueprint $table) {
                $table->dropIndex(['course_section_id', 'sort_order']);
                $table->dropColumn('sort_order');
            });
        }

        if (Schema::hasColumn('course_keypoints', 'sort_order')) {
            Schema::table('course_keypoints', function (Blueprint $table) {
                $table->dropIndex(['course_id', 'sort_order']);
                $table->dropColumn('sort_order');
            });
        }
    }
};
