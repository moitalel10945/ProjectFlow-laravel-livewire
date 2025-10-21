<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>fake()->name(),
            'description'=>fake()->paragraph(),
            'status'=>fake()->randomElement(['complete','pending', 'active']),
            'user_id'=>User::inRandomOrder()->value('id') ?? User::factory(),
            'deadline'=>fake()->time()

        ];
    }
}
