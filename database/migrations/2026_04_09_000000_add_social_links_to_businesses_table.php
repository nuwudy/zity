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
        Schema::table('businesses', function (Blueprint $table) {
            $table->string('facebook_url')->nullable()->after('availability');
            $table->string('instagram_url')->nullable()->after('facebook_url');
            $table->string('youtube_url')->nullable()->after('instagram_url');
            $table->string('twitter_url')->nullable()->after('youtube_url');
            $table->string('google_url')->nullable()->after('twitter_url');
            $table->string('website_url')->nullable()->after('google_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropColumn([
                'facebook_url',
                'instagram_url',
                'youtube_url',
                'twitter_url',
                'google_url',
                'website_url',
            ]);
        });
    }
};
