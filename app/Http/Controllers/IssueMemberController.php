<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Issue;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class IssueMemberController extends Controller
{
    public function store(Issue $issue, User $user): JsonResponse
    {
        $this->authorize('view', $issue);

        if (! $user->hasRole(UserRole::Member->value)) {
            return response()->json(['message' => __('Only members can be assigned to an issue.')], 422);
        }

        if ($issue->members()->whereKey($user->id)->exists()) {
            return response()->json(['message' => __('Member is already assigned.')], 422);
        }

        $issue->members()->attach($user);

        return response()->json([
            'members' => $this->formatMembers($issue->members()->orderBy('name')->get()),
        ]);
    }

    public function destroy(Issue $issue, User $user): JsonResponse
    {
        $this->authorize('view', $issue);

        $issue->members()->detach($user);

        return response()->json([
            'members' => $this->formatMembers($issue->members()->orderBy('name')->get()),
        ]);
    }

    private function formatMembers($members): array
    {
        return $members->map(fn (User $member) => [
            'id' => $member->id,
            'name' => $member->name,
            'email' => $member->email,
        ])->values()->all();
    }
}
