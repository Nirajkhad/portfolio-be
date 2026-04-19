<?php

namespace Database\Factories;

use App\Models\ExperienceBullet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * ExperienceBulletFactory
 *
 * Generates fake achievement/responsibility bullet points for Experience records.
 * Used in conjunction with ExperienceFactory to create complete experience entries.
 *
 * @extends Factory<ExperienceBullet>
 */
class ExperienceBulletFactory extends Factory
{
    protected $model = ExperienceBullet::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'content' => fake()->text(150),
            'sort_order' => 0,
        ];
    }
}
