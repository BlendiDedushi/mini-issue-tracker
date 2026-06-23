<?php

namespace Database\Seeders;

use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class IssueSeeder extends Seeder
{
    public function run(): void
    {
        $issueSets = [
            [
                'project' => 'Mini Issue Tracker',
                'owner_email' => 'owner@test.com',
                'issues' => [
                    [
                        'title' => 'Debounce AJAX search on issues index',
                        'description' => 'Search should wait for the user to stop typing before requesting filtered results.',
                        'status' => IssueStatus::Closed,
                        'priority' => IssuePriority::Medium,
                        'due_date' => '2026-06-10',
                        'tags' => ['feature', 'frontend'],
                        'members' => ['member@test.com', 'alex@test.com'],
                    ],
                    [
                        'title' => 'Restrict member assignment to project owners',
                        'description' => 'Only the project owner should be able to assign or remove issue members.',
                        'status' => IssueStatus::Closed,
                        'priority' => IssuePriority::High,
                        'due_date' => '2026-06-18',
                        'tags' => ['enhancement', 'backend'],
                        'members' => ['alex@test.com'],
                    ],
                    [
                        'title' => 'Admin users page missing pagination styling on mobile',
                        'description' => 'Pagination controls overflow on smaller screens in the admin users table.',
                        'status' => IssueStatus::Open,
                        'priority' => IssuePriority::Low,
                        'due_date' => '2026-07-01',
                        'tags' => ['bug', 'frontend'],
                        'members' => ['sam@test.com'],
                    ],
                ],
            ],
            [
                'project' => 'Customer Portal Redesign',
                'owner_email' => 'owner@test.com',
                'issues' => [
                    [
                        'title' => 'Update account settings layout',
                        'description' => 'Group profile, password, and notification settings into clearer sections.',
                        'status' => IssueStatus::InProgress,
                        'priority' => IssuePriority::Medium,
                        'due_date' => '2026-07-20',
                        'tags' => ['feature', 'frontend'],
                        'members' => ['member@test.com'],
                    ],
                    [
                        'title' => 'Broken breadcrumb on invoice history page',
                        'description' => 'The breadcrumb trail resets to Home instead of Account when viewing invoice details.',
                        'status' => IssueStatus::Open,
                        'priority' => IssuePriority::High,
                        'due_date' => '2026-06-25',
                        'tags' => ['bug', 'urgent'],
                        'members' => ['alex@test.com', 'sam@test.com'],
                    ],
                ],
            ],
            [
                'project' => 'Mobile App MVP',
                'owner_email' => 'jane@test.com',
                'issues' => [
                    [
                        'title' => 'Implement biometric login on iOS',
                        'description' => 'Allow users with Face ID or Touch ID enabled devices to unlock the app quickly.',
                        'status' => IssueStatus::InProgress,
                        'priority' => IssuePriority::High,
                        'due_date' => '2026-08-01',
                        'tags' => ['feature', 'frontend'],
                        'members' => ['alex@test.com'],
                    ],
                    [
                        'title' => 'Push notification token not refreshed after logout',
                        'description' => 'Logging out and back in leaves the previous device token attached to the account.',
                        'status' => IssueStatus::Open,
                        'priority' => IssuePriority::Medium,
                        'due_date' => '2026-07-12',
                        'tags' => ['bug', 'backend'],
                        'members' => ['sam@test.com'],
                    ],
                    [
                        'title' => 'Document mobile release checklist',
                        'description' => 'Add internal docs for QA sign-off, store submission, and rollback steps.',
                        'status' => IssueStatus::Open,
                        'priority' => IssuePriority::Low,
                        'due_date' => '2026-08-15',
                        'tags' => ['documentation'],
                        'members' => ['member@test.com'],
                    ],
                ],
            ],
            [
                'project' => 'Payments Service Upgrade',
                'owner_email' => 'jane@test.com',
                'issues' => [
                    [
                        'title' => 'Retry failed webhook deliveries',
                        'description' => 'Queue retries with exponential backoff when the payment provider webhook endpoint times out.',
                        'status' => IssueStatus::InProgress,
                        'priority' => IssuePriority::High,
                        'due_date' => '2026-07-30',
                        'tags' => ['backend', 'urgent'],
                        'members' => ['member@test.com', 'sam@test.com'],
                    ],
                    [
                        'title' => 'Add audit log for subscription plan changes',
                        'description' => 'Store who changed a customer plan, the previous value, and the timestamp.',
                        'status' => IssueStatus::Open,
                        'priority' => IssuePriority::Medium,
                        'due_date' => '2026-08-20',
                        'tags' => ['enhancement', 'backend'],
                        'members' => ['alex@test.com'],
                    ],
                ],
            ],
            [
                'project' => 'Internal HR Dashboard',
                'owner_email' => 'mark@test.com',
                'issues' => [
                    [
                        'title' => 'Managers cannot filter leave requests by team',
                        'description' => 'The leave requests table needs a team filter and date range picker.',
                        'status' => IssueStatus::Open,
                        'priority' => IssuePriority::High,
                        'due_date' => '2026-07-05',
                        'tags' => ['feature', 'frontend'],
                        'members' => ['member@test.com'],
                    ],
                    [
                        'title' => 'Export onboarding checklist to PDF',
                        'description' => 'HR admins need a downloadable checklist for each new hire.',
                        'status' => IssueStatus::Open,
                        'priority' => IssuePriority::Low,
                        'due_date' => '2026-09-10',
                        'tags' => ['enhancement', 'documentation'],
                        'members' => ['sam@test.com'],
                    ],
                ],
            ],
        ];

        foreach ($issueSets as $issueSet) {
            $project = Project::query()
                ->where('name', $issueSet['project'])
                ->whereHas('owner', fn ($query) => $query->where('email', $issueSet['owner_email']))
                ->firstOrFail();

            foreach ($issueSet['issues'] as $issueData) {
                $issue = Issue::query()->firstOrCreate(
                    [
                        'project_id' => $project->id,
                        'title' => $issueData['title'],
                    ],
                    [
                        'description' => $issueData['description'],
                        'status' => $issueData['status'],
                        'priority' => $issueData['priority'],
                        'due_date' => $issueData['due_date'],
                    ]
                );

                $tagIds = Tag::query()
                    ->whereIn('name', $issueData['tags'])
                    ->pluck('id');

                $issue->tags()->syncWithoutDetaching($tagIds);

                $memberIds = User::query()
                    ->whereIn('email', $issueData['members'])
                    ->pluck('id');

                $issue->members()->syncWithoutDetaching($memberIds);
            }
        }
    }
}
