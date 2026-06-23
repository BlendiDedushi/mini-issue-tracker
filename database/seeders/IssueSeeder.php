<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class IssueSeeder extends Seeder
{
    public function run(): void
    {
        $tags = Tag::all();
        $members = User::role(UserRole::Member->value)->get();

        Project::query()->each(function (Project $project) use ($tags, $members): void {
            if ($project->issues()->exists()) {
                return;
            }

            $issues = Issue::factory()
                ->count(fake()->numberBetween(1, 3))
                ->for($project)
                ->create();

            foreach ($issues as $issue) {
                if ($tags->isNotEmpty()) {
                    $issue->tags()->attach(
                        $tags->random(fake()->numberBetween(1, min(2, $tags->count())))->pluck('id')
                    );
                }

                if ($members->isNotEmpty()) {
                    $issue->members()->attach(
                        $members->random(fake()->numberBetween(1, min(2, $members->count())))->pluck('id')
                    );
                }
            }
        });
    }
}
