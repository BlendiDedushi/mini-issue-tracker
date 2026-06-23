<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Issue;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        Issue::query()->each(function (Issue $issue): void {
            if ($issue->comments()->exists()) {
                return;
            }

            Comment::factory()
                ->count(fake()->numberBetween(0, 5))
                ->for($issue)
                ->create();
        });
    }
}
