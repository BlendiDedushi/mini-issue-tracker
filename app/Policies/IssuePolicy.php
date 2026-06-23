<?php

namespace App\Policies;

use App\Models\Issue;
use App\Models\User;

class IssuePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Issue $issue): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->ownedProjects()->exists();
    }

    public function update(User $user, Issue $issue): bool
    {
        if ($issue->project->owner_id === $user->id) {
            return true;
        }

        return $issue->members()->whereKey($user->id)->exists();
    }

    public function delete(User $user, Issue $issue): bool
    {
        return $issue->project->owner_id === $user->id;
    }

    public function manageMembers(User $user, Issue $issue): bool
    {
        return $issue->project->owner_id === $user->id;
    }

    public function manageTags(User $user, Issue $issue): bool
    {
        return $issue->project->owner_id === $user->id;
    }
}
