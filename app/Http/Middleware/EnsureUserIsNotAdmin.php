<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsNotAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->hasRole(UserRole::Admin->value)) {
            return redirect()->route('admin.users.index');
        }

        return $next($request);
    }
}
