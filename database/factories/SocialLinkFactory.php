<?php

namespace Database\Factories;

use App\Models\SocialLink;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * SocialLinkFactory
 *
 * Generates fake social media profile links.
 * Creates realistic URLs for common platforms with icon names.
 *
 * @extends Factory<SocialLink>
 */
class SocialLinkFactory extends Factory
{
    protected $model = SocialLink::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        // Predefined social platforms with icon classes and URL patterns
        $platforms = [
            'GitHub' => [
                'url_template' => 'https://github.com/{username}',
                'icon' => 'fab fa-github',
            ],
            'LinkedIn' => [
                'url_template' => 'https://linkedin.com/in/{username}',
                'icon' => 'fab fa-linkedin',
            ],
            'LeetCode' => [
                'url_template' => 'https://leetcode.com/{username}',
                'icon' => 'fab fa-leetcode',
            ],
            'Twitter' => [
                'url_template' => 'https://twitter.com/{username}',
                'icon' => 'fab fa-twitter',
            ],
            'Portfolio' => [
                'url_template' => '{url}',
                'icon' => 'fas fa-globe',
            ],
        ];

        $platform = fake()->randomElement(array_keys($platforms));
        $config = $platforms[$platform];
        $username = fake()->userName();

        $url = str_contains($config['url_template'], '{username}')
            ? str_replace('{username}', $username, $config['url_template'])
            : fake()->url();

        return [
            'platform' => $platform,
            'url' => $url,
            'icon' => $config['icon'],
            'sort_order' => 0,
        ];
    }
}
