<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Ensure the authenticated user has one of the allowed roles.
     * Usage: ->middleware('role:editor,administrator,super_admin')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // In case roles were passed as a single comma-separated string
        if (count($roles) === 1 && str_contains($roles[0], ',')) {
            $roles = array_map('trim', explode(',', $roles[0]));
        }

        $user = $request->user();
        if (!$user) {
            abort(403);
        }

        if (!in_array($user->role, $roles, true)) {
            abort(403, 'You are not authorized to access this resource.');
        }

        return $next($request);
    }
}
