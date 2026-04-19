<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Create the social_links table for dynamic social media/profile URLs.
 *
 * Stores social media profiles and external links dynamically.
 * Allows adding/removing platforms without database migrations.
 * Supported platforms: GitHub, LinkedIn, LeetCode, Portfolio, Resume, etc.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_links', static function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->foreignUuid('general_info_id')
                ->references('id')
                ->on('general_infos')
                ->cascadeOnDelete();
            $table->string('platform'); // GitHub, LinkedIn, LeetCode, Portfolio, Resume, Twitter, etc.
            $table->string('url');
            $table->string('icon')->nullable(); // Icon name/class for UI rendering
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['general_info_id', 'platform']);
            $table->index('platform');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_links');
    }
};
