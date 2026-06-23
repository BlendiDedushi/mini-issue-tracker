<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Tag;
use App\Models\User;

class TagPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasRole(UserRole::ProjectOwner->value);
    }
}
