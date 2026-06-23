<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-2 months', 'now');

        return [
            'name' => collect([
                'Customer Portal Redesign',
                'Mobile App MVP',
                'Payments Service Upgrade',
                'Internal HR Dashboard',
                'Inventory Management System',
            ])->random(),
            'description' => fake()->randomElement([
                'Improve the core workflow for internal teams and reduce manual follow-up.',
                'Deliver the next release milestone with authentication, reporting, and admin tooling.',
                'Replace legacy integrations and improve reliability for production traffic.',
            ]),
            'start_date' => $startDate,
            'deadline' => fake()->dateTimeBetween($startDate, '+4 months'),
        ];
    }
}
