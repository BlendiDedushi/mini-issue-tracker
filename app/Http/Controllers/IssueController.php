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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class IssueController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Issue::class);

        $issues = Issue::query()
            ->with(['project.owner', 'tags'])
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->when($request->filled('priority'), fn ($query) => $query->where('priority', $request->string('priority')))
            ->when($request->filled('tag'), fn ($query) => $query->whereHas(
                'tags',
                fn ($tagQuery) => $tagQuery->where('tags.id', $request->string('tag'))
            ))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('issues.index', [
            'issues' => $issues,
            'tags' => Tag::query()->orderBy('name')->get(),
            'statuses' => IssueStatus::cases(),
            'priorities' => IssuePriority::cases(),
            'filters' => $request->only(['status', 'priority', 'tag']),
        ]);
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

        $issue->load(['project.owner', 'tags']);

        return view('issues.show', [
            'issue' => $issue,
            'allTags' => Tag::query()->orderBy('name')->get(),
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
}
