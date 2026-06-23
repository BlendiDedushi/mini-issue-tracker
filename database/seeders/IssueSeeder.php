<?php

namespace Database\Seeders;

use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class IssueSeeder extends Seeder
{
    public function run(): void
    {
        $tags = Tag::all();

        Project::query()->each(function (Project $project) use ($tags): void {
            if ($project->issues()->exists()) {
                return;
            }

            $issues = Issue::factory()
                ->count(fake()->numberBetween(1, 3))
                ->for($project)
                ->create();

            if ($tags->isNotEmpty()) {
                foreach ($issues as $issue) {
                    $issue->tags()->attach(
                        $tags->random(fake()->numberBetween(1, min(2, $tags->count())))->pluck('id')
                    );
                }
            }
        });
    }
}
