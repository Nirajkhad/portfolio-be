<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Create the experience_bullets table for achievement details.
 *
 * Stores individual bullet points/achievements for each experience.
 * Linked to experiences via foreign key with cascade delete.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experience_bullets', static function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->foreignUuid('experience_id')
                ->references('id')
                ->on('experiences')
                ->cascadeOnDelete();
            $table->text('content');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experience_bullets');
    }
};
