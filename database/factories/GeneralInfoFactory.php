<?php

namespace Database\Factories;

use App\Models\GeneralInfo;
use App\Models\SocialLink;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * GeneralInfoFactory
 *
 * Generates realistic fake data for GeneralInfo model testing.
 * Creates a general info record and automatically generates associated social links.
 *
 * @extends Factory<GeneralInfo>
 */
class GeneralInfoFactory extends Factory
{
    protected $model = GeneralInfo::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'full_name' => fake()->name(),
            'title' => fake()->jobTitle(),
            'bio' => fake()->text(200),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'location' => fake()->city() . ', ' . fake()->countryCode(),
            'is_active' => true,
        ];
    }

    /**
     * Configure the factory to create associated social links after creation.
     */
    public function configure()
    {
        return $this->afterCreating(function (GeneralInfo $generalInfo) {
            // Create 3-5 social links for the general info
            SocialLink::factory(random_int(3, 5))->create([
                'general_info_id' => $generalInfo->id,
            ]);
        });
    }
}
