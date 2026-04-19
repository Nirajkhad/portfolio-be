<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Create the skills table for professional competencies.
 *
 * Stores skills organized by category (Languages, Frameworks, Databases, Tools, Cloud).
 * Supports sorting and prioritization.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skills', static function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->string('category');
            $table->string('name');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
