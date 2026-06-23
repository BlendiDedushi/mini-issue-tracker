<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Issue;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $commentsByIssue = [
            'Debounce AJAX search on issues index' => [
                ['author_name' => 'Alex Nguyen', 'body' => 'Implemented a 300ms debounce on the search input. Results update without reloading the page.'],
                ['author_name' => 'Project Owner', 'body' => 'Looks good in testing. Closing this once pagination after search is confirmed separately.'],
            ],
            'Restrict member assignment to project owners' => [
                ['author_name' => 'Alex Nguyen', 'body' => 'Added manageMembers policy and hid the assign/remove controls for members in the UI.'],
            ],
            'Broken breadcrumb on invoice history page' => [
                ['author_name' => 'Sam Patel', 'body' => 'I can reproduce this in staging when opening an invoice from the account page.'],
                ['author_name' => 'Alex Nguyen', 'body' => 'The breadcrumb component is using the wrong parent route. I will patch it today.'],
            ],
            'Implement biometric login on iOS' => [
                ['author_name' => 'Alex Nguyen', 'body' => 'Face ID prompt works on the simulator. Need a physical device test before release.'],
            ],
            'Retry failed webhook deliveries' => [
                ['author_name' => 'Team Member', 'body' => 'Queued retries are in place with backoff. Monitoring logs for duplicate delivery edge cases.'],
                ['author_name' => 'Sam Patel', 'body' => 'Please add a note in the README about the retry window for support staff.'],
            ],
            'Managers cannot filter leave requests by team' => [
                ['author_name' => 'Team Member', 'body' => 'Started on the team filter. Date range picker should follow in the next commit.'],
            ],
        ];

        foreach ($commentsByIssue as $issueTitle => $comments) {
            $issue = Issue::query()->where('title', $issueTitle)->first();

            if ($issue === null || $issue->comments()->exists()) {
                continue;
            }

            foreach ($comments as $comment) {
                Comment::query()->create([
                    'issue_id' => $issue->id,
                    'author_name' => $comment['author_name'],
                    'body' => $comment['body'],
                ]);
            }
        }
    }
}
