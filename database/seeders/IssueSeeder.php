<?php

namespace Database\Seeders;

use App\Models\Issue;
use App\Models\Project;
use Illuminate\Database\Seeder;

class IssueSeeder extends Seeder
{
    public function run(): void
    {
        Project::query()->each(function (Project $project): void {
            if ($project->issues()->exists()) {
                return;
            }

            Issue::factory()
                ->count(fake()->numberBetween(1, 3))
                ->for($project)
                ->create();
        });
    }
}
