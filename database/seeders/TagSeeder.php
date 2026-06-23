<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name' => 'bug', 'color' => '#ef4444'],
            ['name' => 'feature', 'color' => '#3b82f6'],
            ['name' => 'urgent', 'color' => '#f97316'],
            ['name' => 'documentation', 'color' => '#8b5cf6'],
            ['name' => 'enhancement', 'color' => '#22c55e'],
            ['name' => 'backend', 'color' => '#0ea5e9'],
            ['name' => 'frontend', 'color' => '#ec4899'],
        ];

        foreach ($tags as $tag) {
            Tag::query()->firstOrCreate(
                ['name' => $tag['name']],
                ['color' => $tag['color']]
            );
        }
    }
}
