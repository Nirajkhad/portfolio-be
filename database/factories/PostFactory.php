<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * PostFactory
 *
 * Generates realistic blog post data for testing.
 * Creates posts with realistic content, metadata, and publication status.
 * 70% chance for posts to be published, 30% to remain as drafts.
 *
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $title = fake()->sentence(5);
        // Randomly select 2 tags from predefined list
        $tags = fake()->randomElements(['Laravel', 'PHP', 'JavaScript', 'API', 'Database', 'Security'], 2);

        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::random(8),
            'excerpt' => fake()->text(150),
            'body' => fake()->paragraphs(10, true),
            'cover_image' => fake()->imageUrl(800, 400),
            'tags' => $tags,
            'status' => fake()->randomElement(['draft', 'published']),
            // 70% chance of having a published_at date
            'published_at' => fake()->optional(0.7)->dateTimeBetween('-1 year', 'now'),
            'read_time' => fake()->numberBetween(3, 15),
        ];
    }
}
