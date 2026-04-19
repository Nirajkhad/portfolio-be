<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Create the project_tech_stacks table for project technologies.
 *
 * Stores the technologies and tools used in each project.
 * Linked to projects via foreign key with cascade delete.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_tech_stacks', static function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->foreignUuid('project_id')
                ->references('id')
                ->on('projects')
                ->cascadeOnDelete();
            $table->string('name');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_tech_stacks');
    }
};
