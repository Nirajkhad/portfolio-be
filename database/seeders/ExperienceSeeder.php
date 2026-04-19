<?php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\ExperienceBullet;
use Illuminate\Database\Seeder;

/**
 * ExperienceSeeder
 *
 * Dedicated seeder for populating work experience data.
 * Creates 5 experiences, each with 3 achievement bullet points.
 *
 * Run: php artisan db:seed --class=ExperienceSeeder
 */
class ExperienceSeeder extends Seeder
{
    /**
     * Populate the experiences table with sample data.
     */
    public function run(): void
    {
        // Create 5 experiences with associated bullets
        Experience::factory(5)->create()->each(function (Experience $experience) {
            // Each experience gets 3 bullet points describing achievements/responsibilities
            ExperienceBullet::factory(3)->create([
                'experience_id' => $experience->id,
            ]);
        });
    }
}
