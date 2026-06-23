<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Issue;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'issue_id' => Issue::factory(),
            'author_name' => fake()->name(),
            'body' => fake()->randomElement([
                'I reproduced this in staging and will push a fix shortly.',
                'Can we confirm the expected behavior before closing this issue?',
                'Added a policy check and updated the Blade partial to hide the action for unauthorized users.',
                'This works after clearing the cache. Please retest on your side.',
                'Looks good to me. Ready for review once CI passes.',
            ]),
        ];
    }
}
