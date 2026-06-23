<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Issue;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class AssignmentController extends Controller
{
    public function index(): View
    {
        abort_unless(Auth::user()->hasRole(UserRole::Member->value), Response::HTTP_FORBIDDEN);

        $issues = Issue::query()
            ->whereHas('members', fn ($query) => $query->where('users.id', Auth::id()))
            ->with(['project', 'tags'])
            ->latest()
            ->get();

        return view('assignments.index', compact('issues'));
    }
}
