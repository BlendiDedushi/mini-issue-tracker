<?php

namespace App\Http\Controllers;

use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Enums\UserRole;
use App\Http\Requests\StoreIssueRequest;
use App\Http\Requests\UpdateIssueRequest;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class IssueController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $this->authorize('viewAny', Issue::class);

        $issues = $this->filteredIssues($request);

        $data = [
            'issues' => $issues,
            'tags' => Tag::query()->orderBy('name')->get(),
            'statuses' => IssueStatus::cases(),
            'priorities' => IssuePriority::cases(),
            'filters' => $request->only(['status', 'priority', 'tag', 'search']),
        ];

        if ($request->wantsJson()) {
            return response()->json([
                'html' => view('issues.partials.results', ['issues' => $issues])->render(),
            ]);
        }

        return view('issues.index', $data);
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Issue::class);

        return view('issues.create', [
            'projects' => $this->availableProjects(),
            'selectedProjectId' => $request->string('project')->toString() ?: null,
            'statuses' => IssueStatus::cases(),
            'priorities' => IssuePriority::cases(),
        ]);
    }

    public function store(StoreIssueRequest $request): RedirectResponse
    {
        $issue = Issue::query()->create($request->validated());

        return redirect()->route('issues.show', $issue);
    }

    public function show(Issue $issue): View
    {
        $this->authorize('view', $issue);

        $issue->load(['project.owner', 'tags', 'members']);

        return view('issues.show', [
            'issue' => $issue,
            'allTags' => Tag::query()->orderBy('name')->get(),
            'assignableMembers' => User::role(UserRole::Member->value)->orderBy('name')->get(),
        ]);
    }

    public function edit(Issue $issue): View
    {
        $this->authorize('update', $issue);

        return view('issues.edit', [
            'issue' => $issue,
            'projects' => $this->availableProjects(),
            'statuses' => IssueStatus::cases(),
            'priorities' => IssuePriority::cases(),
        ]);
    }

    public function update(UpdateIssueRequest $request, Issue $issue): RedirectResponse
    {
        $issue->update($request->validated());

        return redirect()->route('issues.show', $issue);
    }

    public function destroy(Issue $issue): RedirectResponse
    {
        $this->authorize('delete', $issue);

        $issue->delete();

        return redirect()->route('issues.index');
    }

    private function availableProjects()
    {
        $user = Auth::user();

        $query = match (true) {
            $user->hasRole(UserRole::ProjectOwner->value) => $user->ownedProjects()->getQuery(),
            default => Project::query(),
        };

        return $query->orderBy('name')->get();
    }

    private function filteredIssues(Request $request): LengthAwarePaginator
    {
        return Issue::query()
            ->with(['project.owner', 'tags'])
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->when($request->filled('priority'), fn ($query) => $query->where('priority', $request->string('priority')))
            ->when($request->filled('tag'), fn ($query) => $query->whereHas(
                'tags',
                fn ($tagQuery) => $tagQuery->where('tags.id', $request->string('tag'))
            ))
            ->when($request->filled('search'), function ($query) use ($request): void {
                $term = '%'.$request->string('search').'%';

                $query->where(function ($searchQuery) use ($term): void {
                    $searchQuery->where('title', 'like', $term)
                        ->orWhere('description', 'like', $term);
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();
    }
}
