<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TagController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Tag::class);

        $tags = Tag::query()->withCount('issues')->orderBy('name')->get();

        return view('tags.index', compact('tags'));
    }

    public function create(): View
    {
        $this->authorize('create', Tag::class);

        return view('tags.create');
    }

    public function store(StoreTagRequest $request): RedirectResponse
    {
        Tag::query()->create($request->validated());

        return redirect()->route('tags.index');
    }
}
