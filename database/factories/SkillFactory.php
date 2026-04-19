<?php

namespace Database\Factories;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * SkillFactory
 *
 * Generates realistic skill entries organized by category.
 * Randomly selects from predefined skill lists in each category.
 *
 * Categories:
 * - Languages: PHP, JavaScript, TypeScript, Python, Go, SQL, Java, Rust
 * - Frameworks: Laravel, NestJS, React, Vue, Django, FastAPI, Spring Boot
 * - Databases: PostgreSQL, MySQL, MongoDB, Redis, Elasticsearch
 * - Tools: Git, Docker, Kubernetes, AWS, GitHub, GitLab, Linux
 * - Cloud: AWS, Google Cloud, Azure, DigitalOcean, Heroku
 *
 * @extends Factory<Skill>
 */
class SkillFactory extends Factory
{
    protected $model = Skill::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        // Predefined skills organized by category
        $skills = [
            'Languages' => ['PHP', 'JavaScript', 'TypeScript', 'Python', 'Go', 'SQL', 'Java', 'Rust'],
            'Frameworks' => ['Laravel', 'NestJS', 'React', 'Vue', 'Django', 'FastAPI', 'Spring Boot'],
            'Databases' => ['PostgreSQL', 'MySQL', 'MongoDB', 'Redis', 'Elasticsearch'],
            'Tools' => ['Git', 'Docker', 'Kubernetes', 'AWS', 'GitHub', 'GitLab', 'Linux'],
            'Cloud' => ['AWS', 'Google Cloud', 'Azure', 'DigitalOcean', 'Heroku'],
        ];

        // Randomly select a category, then randomly select a skill from that category
        $categories = array_keys($skills);
        $category = fake()->randomElement($categories);
        $name = fake()->randomElement($skills[$category]);

        return [
            'category' => $category,
            'name' => $name,
            'sort_order' => 0,
        ];
    }
}
