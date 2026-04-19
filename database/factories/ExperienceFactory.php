<?php

namespace Database\Factories;

use App\Models\Experience;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * ExperienceFactory
 *
 * Generates realistic fake data for Experience model testing.
 * Creates employment records with random dates and realistic company/role information.
 * 60% chance for past employment (has end_date), 40% for current employment.
 *
 * @extends Factory<Experience>
 */
class ExperienceFactory extends Factory
{
    protected $model = Experience::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        // Generate random start date within last 5 years
        $startDate = fake()->dateTimeBetween('-5 years', 'now');
        // 60% chance of having an end date (past employment)
        $endDate = fake()->boolean(60) ? fake()->dateTimeBetween($startDate, 'now') : null;

        return [
            'company' => fake()->company(),
            'role' => fake()->jobTitle(),
            'location' => fake()->city(),
            'employment_type' => fake()->randomElement(['Full-time', 'Contract', 'Freelance', 'Part-time']),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_current' => $endDate === null,
            'sort_order' => 0,
        ];
    }
}
