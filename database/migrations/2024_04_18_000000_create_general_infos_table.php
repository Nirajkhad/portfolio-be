<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Create the general_infos table for portfolio owner information.
 *
 * Stores personal and professional information about the portfolio owner,
 * including contact details and links to social profiles and resume.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('general_infos', static function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->string('full_name');
            $table->string('title');
            $table->text('bio');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('general_infos');
    }
};
