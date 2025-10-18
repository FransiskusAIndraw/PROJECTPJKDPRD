<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PimpinanController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TUSekreController;
use App\Http\Controllers\TUSekwanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\PimpinanDisposisiController;
use App\Http\Controllers\TUSekreSuratController;
use App\Http\Controllers\TUSekwanSuratController;
use App\Http\Controllers\StaffSuratController;
use App\Http\Controllers\TUSekwanScreeningController;
use App\Http\Controllers\ArsipController;

//
// ─── GENERAL ROUTES ────────────────────────────────────────────────
//
Route::get('/', fn() => view('welcome'));

Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

//
// ─── AUTHENTICATED USER ROUTES ─────────────────────────────────────
//
Route::middleware('auth')->group(function () {

    // 🔹 Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //
    // ─── ADMIN ──────────────────────────────────────────────
    //
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::resource('/surat-masuk', SuratMasukController::class);
    });

    //
    // ─── TU SEKRETARIAT ─────────────────────────────────────
    //
    Route::middleware('role:tusekre')->prefix('tusekre')->group(function () {
        Route::get('/dashboard', [TUSekreController::class, 'dashboard'])->name('tusekre.dashboard');
        Route::resource('/surat_masuk', TUSekreSuratController::class);
    });

    //
    // ─── TU SEKWAN ───────────────────────────────────────────
    //
    Route::middleware('role:tusekwan')->prefix('tusekwan')->group(function () {
        Route::get('/dashboard', [TUSekwanController::class, 'dashboard'])->name('tusekwan.dashboard');

        // Screening routes
        Route::get('/screening', [TUSekwanScreeningController::class, 'index'])->name('tusekwan.screening.index');
        Route::get('/screening/{id}', [TUSekwanScreeningController::class, 'show'])->name('tusekwan.screening.show');
        Route::patch('/screening/{id}', [TUSekwanScreeningController::class, 'update'])->name('tusekwan.screening.update');

        // Surat TU Sekwan (if used)
        Route::resource('/surat_masuk', TUSekwanSuratController::class);
    });

    //
    // ─── PIMPINAN ────────────────────────────────────────────
    //
    Route::middleware('role:pimpinan')->prefix('pimpinan')->group(function () {
        Route::get('/dashboard', [PimpinanController::class, 'dashboard'])->name('pimpinan.dashboard');
        Route::resource('/disposisi', PimpinanDisposisiController::class);
    });

    //
    // ─── STAFF ───────────────────────────────────────────────
    //
    Route::middleware('role:staff')->prefix('staff')->group(function () {
        Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('staff.dashboard');
        Route::resource('/surat', StaffSuratController::class);
        Route::get('/disposisi', [\App\Http\Controllers\StaffDisposisiController::class, 'index'])->name('staff.disposisi.index');
        Route::get('/disposisi/{id}', [\App\Http\Controllers\StaffDisposisiController::class, 'show'])->name('staff.disposisi.show');
        Route::patch('/disposisi/{id}/status', [\App\Http\Controllers\StaffDisposisiController::class, 'updateStatus'])->name('staff.disposisi.updateStatus');
    });

    //
    // ─── DISPOSISI SHARED (TUSEKWAN & PIMPINAN) ─────────────
    //
    Route::middleware('role:tusekwan,pimpinan')->group(function () {
        Route::get('/disposisi', [DisposisiController::class, 'index'])->name('disposisi.index');
        Route::get('/disposisi/create/{surat}', [DisposisiController::class, 'create'])->name('disposisi.create');
        Route::post('/disposisi/store', [DisposisiController::class, 'store'])->name('disposisi.store');
        Route::get('/disposisi/{id}', [DisposisiController::class, 'show'])->name('disposisi.show');
        Route::patch('/disposisi/{id}/status', [DisposisiController::class, 'updateStatus'])->name('disposisi.updateStatus');
    });

    //
    //ARSIP------------------------
    //
    Route::resource('arsip', ArsipController::class)->only(['index', 'create', 'store']);

});

require __DIR__.'/auth.php';
