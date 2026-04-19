<?php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\ExperienceBullet;
use App\Models\GeneralInfo;
use App\Models\Post;
use App\Models\Project;
use App\Models\ProjectTechStack;
use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * DatabaseSeeder
 *
 * Main seeder that populates the database with complete sample data.
 * Creates realistic portfolio data including:
 * - 1 general info record with 3-5 social links
 * - 5 experiences with 3 bullets each
 * - 8 projects with 2-5 technologies each
 * - 15 skills across all categories
 * - 10 blog posts
 *
 * Run: php artisan db:seed
 */
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database with sample portfolio data.
     */
    public function run(): void
    {
        // Create one general info record (portfolio owner info)
        GeneralInfo::factory()->create();

        // Create experiences with associated achievement bullets
        Experience::factory(5)->create()->each(function (Experience $experience) {
            // Each experience gets 3 bullet points
            ExperienceBullet::factory(3)->create([
                'experience_id' => $experience->id,
            ]);
        });

        // Create projects with associated technology stacks
        Project::factory(8)->create()->each(function (Project $project) {
            // Each project gets 2-5 technologies
            ProjectTechStack::factory(random_int(2, 5))->create([
                'project_id' => $project->id,
            ]);
        });

        // Create skills (randomly distributed across categories)
        Skill::factory(15)->create();

        // Create blog posts
        Post::factory(10)->create();
    }
}
