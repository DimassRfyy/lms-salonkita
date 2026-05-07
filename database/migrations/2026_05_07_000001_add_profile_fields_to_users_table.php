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
        Schema::table('users', function (Blueprint $table) {
            $table->string('whatsapp_number')->nullable()->after('password');
            $table->date('birth_date')->nullable()->after('whatsapp_number');
            $table->string('city')->nullable()->after('birth_date');
            $table->string('country')->nullable()->after('city');
            $table->string('job_title')->nullable()->after('country');
            $table->text('bio')->nullable()->after('job_title');
            $table->string('instagram_url')->nullable()->after('bio');
            $table->string('tiktok_url')->nullable()->after('instagram_url');
            $table->string('youtube_url')->nullable()->after('tiktok_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'whatsapp_number',
                'birth_date',
                'city',
                'country',
                'job_title',
                'bio',
                'instagram_url',
                'tiktok_url',
                'youtube_url',
            ]);
        });
    }
};