<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-1 month', 'now');

        return [
            'name' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'start_date' => $startDate,
            'deadline' => fake()->dateTimeBetween($startDate, '+3 months'),
        ];
    }
}
