<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class IssueTagController extends Controller
{
    public function store(Issue $issue, Tag $tag): JsonResponse
    {
        $this->authorize('view', $issue);

        if ($issue->tags()->whereKey($tag->id)->exists()) {
            return response()->json(['message' => __('Tag is already attached.')], 422);
        }

        $issue->tags()->attach($tag);

        return response()->json([
            'tags' => $this->formatTags($issue->tags()->orderBy('name')->get()),
        ]);
    }

    public function destroy(Issue $issue, Tag $tag): JsonResponse
    {
        $this->authorize('view', $issue);

        $issue->tags()->detach($tag);

        return response()->json([
            'tags' => $this->formatTags($issue->tags()->orderBy('name')->get()),
        ]);
    }

    private function formatTags($tags): array
    {
        return $tags->map(fn (Tag $tag) => [
            'id' => $tag->id,
            'name' => $tag->name,
            'color' => $tag->color ?? '#6b7280',
        ])->values()->all();
    }
}
