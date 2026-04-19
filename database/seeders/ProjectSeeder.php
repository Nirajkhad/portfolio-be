<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectTechStack;
use Illuminate\Database\Seeder;

/**
 * ProjectSeeder
 *
 * Dedicated seeder for populating portfolio projects data.
 * Creates 8 projects, each with 2-5 technologies in their tech stack.
 *
 * Run: php artisan db:seed --class=ProjectSeeder
 */
class ProjectSeeder extends Seeder
{
    /**
     * Populate the projects table with sample data.
     */
    public function run(): void
    {
        // Create 8 projects with associated technology stacks
        Project::factory(8)->create()->each(function (Project $project) {
            // Each project gets 2-5 technologies
            ProjectTechStack::factory(random_int(2, 5))->create([
                'project_id' => $project->id,
            ]);
        });
    }
}
