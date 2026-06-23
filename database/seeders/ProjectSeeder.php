<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'owner_email' => 'owner@test.com',
                'name' => 'Mini Issue Tracker',
                'description' => 'Internal tool for tracking projects, issues, tags, and team comments.',
                'start_date' => '2026-05-01',
                'deadline' => '2026-07-15',
            ],
            [
                'owner_email' => 'owner@test.com',
                'name' => 'Customer Portal Redesign',
                'description' => 'Refresh the customer-facing portal with improved navigation and account settings.',
                'start_date' => '2026-04-10',
                'deadline' => '2026-08-30',
            ],
            [
                'owner_email' => 'jane@test.com',
                'name' => 'Mobile App MVP',
                'description' => 'First release of the iOS and Android app with authentication and core workflows.',
                'start_date' => '2026-03-15',
                'deadline' => '2026-09-01',
            ],
            [
                'owner_email' => 'jane@test.com',
                'name' => 'Payments Service Upgrade',
                'description' => 'Migrate billing flows to the new payment provider and improve webhook reliability.',
                'start_date' => '2026-05-20',
                'deadline' => '2026-10-01',
            ],
            [
                'owner_email' => 'mark@test.com',
                'name' => 'Internal HR Dashboard',
                'description' => 'Dashboard for managers to review leave requests, onboarding tasks, and team availability.',
                'start_date' => '2026-06-01',
                'deadline' => '2026-11-15',
            ],
        ];

        foreach ($projects as $projectData) {
            $owner = User::query()->where('email', $projectData['owner_email'])->firstOrFail();

            Project::query()->firstOrCreate(
                [
                    'name' => $projectData['name'],
                    'owner_id' => $owner->id,
                ],
                [
                    'description' => $projectData['description'],
                    'start_date' => $projectData['start_date'],
                    'deadline' => $projectData['deadline'],
                ]
            );
        }
    }
}
