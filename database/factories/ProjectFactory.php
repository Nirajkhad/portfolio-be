<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * ProjectFactory
 *
 * Generates realistic fake data for Project model testing.
 * Creates portfolio projects with realistic URLs and metadata.
 * 30% chance for each project to be featured.
 *
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $title = fake()->sentence(3);

        return [
            'title' => $title,
            'description' => fake()->paragraphs(3, true),
            'github_url' => 'https://github.com/user/' . Str::slug($title),
            'live_url' => fake()->url(),
            'thumbnail_url' => fake()->imageUrl(400, 300),
            'is_featured' => fake()->boolean(30),
            'sort_order' => 0,
        ];
    }
}
