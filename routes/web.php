<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\IssueCommentController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\IssueMemberController;
use App\Http\Controllers\IssueTagController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn () => redirect()->route('projects.index'))->name('dashboard');

    Route::resource('projects', ProjectController::class);
    Route::resource('issues', IssueController::class);
    Route::resource('tags', TagController::class)->only(['index', 'create', 'store']);

    Route::post('issues/{issue}/tags/{tag}', [IssueTagController::class, 'store'])->name('issues.tags.attach');
    Route::delete('issues/{issue}/tags/{tag}', [IssueTagController::class, 'destroy'])->name('issues.tags.detach');

    Route::get('issues/{issue}/comments', [IssueCommentController::class, 'index'])->name('issues.comments.index');
    Route::post('issues/{issue}/comments', [IssueCommentController::class, 'store'])->name('issues.comments.store');

    Route::post('issues/{issue}/members/{user}', [IssueMemberController::class, 'store'])->name('issues.members.attach');
    Route::delete('issues/{issue}/members/{user}', [IssueMemberController::class, 'destroy'])->name('issues.members.detach');

    Route::get('my-assignments', [AssignmentController::class, 'index'])->name('assignments.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
