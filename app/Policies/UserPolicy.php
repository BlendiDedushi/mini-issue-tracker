<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(UserRole::Admin->value);
    }

    public function updateRole(User $user, User $model): bool
    {
        return $user->hasRole(UserRole::Admin->value)
            && $user->id !== $model->id;
    }
}
