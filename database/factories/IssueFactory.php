<?php

namespace Database\Factories;

use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Models\Issue;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class IssueFactory extends Factory
{
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(IssueStatus::cases())->value,
            'priority' => fake()->randomElement(IssuePriority::cases())->value,
            'due_date' => fake()->optional(0.7)->dateTimeBetween('now', '+2 months'),
        ];
    }
}
