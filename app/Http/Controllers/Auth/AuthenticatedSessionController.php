<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login form.
     */
    public function create()
    {
        // Pastikan kamu punya view 'auth.login' (default scaffold)
        // Jika view kamu punya nama lain, ganti 'auth.login' sesuai file blade.
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        // HAPUS url.intended supaya tidak override redirect role-based
        // (jika kamu ingin tetap hormati intended, lihat opsi B di bawah)
        session()->forget('url.intended');

        $user = auth()->user();
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
                auth()->logout();
                return redirect()->route('login')->withErrors(['email' => 'Role akun tidak dikenali.']);
        }
    }

    /**
     * Destroy an authenticated session (logout).
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
