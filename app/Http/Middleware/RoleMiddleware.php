<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class RoleMiddleware
{
//     public function handle(Request $request, Closure $next, $role): Response
//     {
//         if (!$request->user() || $request->user()->role !== $role) {
//             abort(403, 'Unauthorized');
//         }

//         return $next($request);
//     }

public function handle(Request $request, Closure $next, $role): Response
{
    if (!$request->user()) {
        abort(401, 'Not logged in');
    }

    if ($request->user()->roles !== $role) {
        abort(403, 'Your role is: '.$request->user()->role.' | Expected: '.$role);
    }

    return $next($request);
}

}
