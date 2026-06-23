<?php

namespace Database\Factories;

use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Models\Issue;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class IssueFactory extends Factory
{
    protected $model = Issue::class;

    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'title' => fake()->randomElement([
                'Fix validation error on issue create form',
                'Add pagination to admin users table',
                'Search results should preserve active filters',
                'Unable to detach tag after page refresh',
                'Improve empty state on assignments page',
            ]),
            'description' => fake()->randomElement([
                'Users report inconsistent behavior when submitting the form with missing required fields.',
                'The current list view loads all records at once and becomes slow with larger datasets.',
                'After applying filters, navigating away and back should keep the same query parameters.',
                'The UI updates correctly, but the change is not persisted after a full page reload.',
            ]),
            'status' => fake()->randomElement(IssueStatus::cases())->value,
            'priority' => fake()->randomElement(IssuePriority::cases())->value,
            'due_date' => fake()->optional(0.8)->dateTimeBetween('now', '+2 months'),
        ];
    }
}
