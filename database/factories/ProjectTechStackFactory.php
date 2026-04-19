<?php

namespace Database\Factories;

use App\Models\ProjectTechStack;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * ProjectTechStackFactory
 *
 * Generates fake technology stack entries for Project records.
 * Randomly selects from a predefined list of common technologies.
 * Used in conjunction with ProjectFactory to create complete projects.
 *
 * @extends Factory<ProjectTechStack>
 */
class ProjectTechStackFactory extends Factory
{
    protected $model = ProjectTechStack::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        // Predefined list of common technologies for realistic data
        $techStack = [
            'PHP', 'JavaScript', 'TypeScript', 'Python', 'Go',
            'Laravel', 'NestJS', 'React', 'Vue', 'Django',
            'PostgreSQL', 'MySQL', 'MongoDB', 'Redis',
            'Docker', 'Kubernetes', 'AWS', 'GitHub',
        ];

        return [
            'name' => fake()->randomElement($techStack),
            'sort_order' => 0,
        ];
    }
}
