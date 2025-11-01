<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectByRole
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            switch ($user->role) {
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
            }
        }

        return $next($request);
    }
}
