<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tag>
 */
class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'bug',
                'feature',
                'urgent',
                'documentation',
                'enhancement',
                'backend',
                'frontend',
            ]),
            'color' => fake()->randomElement([
                '#ef4444',
                '#3b82f6',
                '#f97316',
                '#8b5cf6',
                '#22c55e',
                '#0ea5e9',
                '#ec4899',
            ]),
        ];
    }
}
