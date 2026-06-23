<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Issue;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IssueCommentController extends Controller
{
    public function index(Request $request, Issue $issue): JsonResponse
    {
        $this->authorize('view', $issue);

        $comments = $issue->comments()
            ->latest()
            ->paginate(10);

        return response()->json([
            'comments' => $comments->map(fn (Comment $comment) => $this->formatComment($comment)),
            'meta' => [
                'current_page' => $comments->currentPage(),
                'last_page' => $comments->lastPage(),
                'has_more' => $comments->hasMorePages(),
            ],
        ]);
    }

    public function store(StoreCommentRequest $request, Issue $issue): JsonResponse
    {
        $comment = $issue->comments()->create([
            'body' => $request->validated('body'),
            'author_name' => $request->user()->name,
        ]);

        return response()->json([
            'comment' => $this->formatComment($comment),
        ], 201);
    }

    private function formatComment(Comment $comment): array
    {
        return [
            'id' => $comment->id,
            'author_name' => $comment->author_name,
            'body' => $comment->body,
            'created_at' => $comment->created_at->diffForHumans(),
        ];
    }
}
