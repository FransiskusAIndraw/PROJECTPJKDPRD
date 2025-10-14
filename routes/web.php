<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PimpinanController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TUSekreController;
use App\Http\Controllers\TUSekwanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ✅ Role-based routes
    Route::middleware('role:admin')->get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::middleware('role:tusekre')->get('/tusekre/dashboard', [TUSekreController::class, 'dashboard'])->name('tusekre.dashboard');
    Route::middleware('role:tusekwan')->get('/tusekwan/dashboard', [TUSekwanController::class, 'dashboard'])->name('tusekwan.dashboard');
    Route::middleware('role:pimpinan')->get('/pimpinan/dashboard', [PimpinanController::class, 'dashboard'])->name('pimpinan.dashboard');
    Route::middleware('role:staff')->get('/staff/dashboard', [StaffController::class, 'dashboard'])->name('staff.dashboard');
});

require __DIR__.'/auth.php';
