<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

/**
 * SkillSeeder
 *
 * Dedicated seeder for populating professional skills data.
 * Creates 15 skills randomly distributed across all skill categories.
 *
 * Categories: Languages, Frameworks, Databases, Tools, Cloud
 *
 * Run: php artisan db:seed --class=SkillSeeder
 */
class SkillSeeder extends Seeder
{
    /**
     * Populate the skills table with sample data.
     */
    public function run(): void
    {
        // Create 15 skills across different categories
        Skill::factory(15)->create();
    }
}
