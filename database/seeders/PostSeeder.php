<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

/**
 * PostSeeder
 *
 * Dedicated seeder for populating blog posts data.
 * Creates 10 sample blog posts with realistic content.
 * Posts have 70% chance of being published, 30% remaining as drafts.
 *
 * Run: php artisan db:seed --class=PostSeeder
 */
class PostSeeder extends Seeder
{
    /**
     * Populate the posts table with sample blog data.
     */
    public function run(): void
    {
        // Create 10 blog posts
        Post::factory(10)->create();
    }
}
