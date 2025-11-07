<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $role = $user->roles ?? $user->role ?? null;

            switch ($role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'tusekre':
                    return redirect()->route('tusekre.dashboard');
                case 'tusekwan':
                    return redirect()->route('tusekwan.dashboard');
                case 'pimpinan':
                    return redirect()->route('pimpinan.dashboard');
                case 'staff':
                    return redirect()->route('staff.dashboard');
                default:
                    Auth::logout();
                    return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
