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
use App\Http\Controllers\TUSekwanDisposisiController;
use App\Http\Controllers\StaffSuratController;
use App\Http\Controllers\TUSekwanScreeningController;
use App\Http\Controllers\ArsipController;

/*
|--------------------------------------------------------------------------
| Public / general routes
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('login'));
Route::get('/dashboard', fn () => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authenticated routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | ADMIN (role: admin)
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->middleware('role:admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Kelola pengguna
        Route::get('/kelola-pengguna', [AdminController::class, 'kelolaPengguna'])->name('kelola_pengguna');
        Route::get('/hapus-akun/{id}', [AdminController::class, 'hapusAkun'])->name('hapus_akun');
        Route::post('/store-akun', [AdminController::class, 'storeAkun'])->name('store_akun');
        Route::get('/edit-role/{id}', [AdminController::class, 'editRole'])->name('edit_role');
        Route::patch('/update-role/{id}', [AdminController::class, 'updateRole'])->name('update_role');
        Route::get('/penambahan-akun', [AdminController::class, 'penambahanAkun'])->name('penambahan_akun');
        Route::get('/pengaturan-sistem', [AdminController::class, 'pengaturanSistem'])->name('pengaturan_sistem');
    });

    /*
    |--------------------------------------------------------------------------
    | TU SEKRETARIAT (role: tusekre)
    |--------------------------------------------------------------------------
    */
    Route::prefix('tusekre')->middleware('role:tusekre')->name('tusekre.')->group(function () {
        Route::get('/dashboard', [TUSekreController::class, 'dashboard'])->name('dashboard');

        // Resource for surat masuk (index, create, store, show, edit, update, destroy)
        Route::resource('surat_masuk', TUSekreSuratController::class);

        // Revisi Surat
        Route::get('/surat-perlu-revisi', [TUSekreSuratController::class, 'suratPerluRevisi'])->name('surat_perlu_revisi');
        Route::get('/surat-masuk/{id}/revisi', [TUSekreSuratController::class, 'editRevisi'])->name('surat_masuk.edit_revisi');
        Route::put('/surat-masuk/{id}/revisi', [TUSekreSuratController::class, 'updateRevisi'])->name('surat_masuk.update_revisi');
            
        // Pencarian Surat
        Route::get('/surat-masuk/search', [TUSekreSuratController::class, 'search'])->name('surat_masuk.search');
        
        // Arsip Surat
        Route::post('/arsip_surat/{id}/arsipkan', [TUSekreSuratController::class, 'arsipkan'])->name('arsip_surat.arsipkan');
        Route::get('/arsip_surat', [TUSekreSuratController::class, 'arsipIndex'])->name('arsip_surat.index');
        Route::get('/arsip_surat/export', [TUSekreSuratController::class, 'exportExcel'])->name('arsip_surat.export');

    });

    /*
    |--------------------------------------------------------------------------
    | TU SEKWAN (role: tusekwan)
    |--------------------------------------------------------------------------
    */
    Route::prefix('tusekwan')->middleware('role:tusekwan')->name('tusekwan.')->group(function () {
        Route::get('/dashboard', [TUSekwanController::class, 'dashboard'])->name('dashboard');

        // Verifikasi Surat MAsuk
        Route::get('/surat-masuk', [TUSekwanSuratController::class, 'index'])->name('surat_masuk.index');
        Route::get('/surat-masuk/{id}/verify', [TUSekwanSuratController::class, 'edit'])->name('surat_masuk.edit');
        Route::put('/surat-masuk/{id}', [TUSekwanSuratController::class, 'update'])->name('surat_masuk.update');
        
        // Cari Surat
        Route::get('/surat-masuk/search', [TUSekwanSuratController::class, 'search'])->name('surat_masuk.search');

        // Disposisi ke Pimpinan
        Route::get('/disposisi', [TUSekwanDisposisiController::class, 'index'])->name('disposisi.index');
        Route::get('/disposisi/{id}/create', [TUSekwanDisposisiController::class, 'create'])->name('disposisi.create');
        Route::post('/disposisi/{id}/store', [TUSekwanDisposisiController::class, 'store'])->name('disposisi.store');

        // Finalisasi Disposisi setelah dikembalikan Pimpinan
        Route::get('/disposisi/{id}/final', [TUSekwanDisposisiController::class, 'finalForm'])->name('disposisi.finalForm');
        Route::post('/disposisi/{id}/final', [TUSekwanDisposisiController::class, 'finalSubmit'])->name('disposisi.finalSubmit');
        });

    /*
    |--------------------------------------------------------------------------
    | PIMPINAN (role: pimpinan)
    |--------------------------------------------------------------------------
    */
    Route::prefix('pimpinan')->middleware('role:pimpinan')->name('pimpinan.')->group(function () {
        Route::get('/dashboard', [PimpinanController::class, 'dashboard'])->name('dashboard');
        Route::resource('disposisi', PimpinanDisposisiController::class);

        // Surat yang perlu diperiksa pimpinan
        Route::get('/disposisi', [PimpinanDisposisiController::class, 'index'])->name('disposisi.index');
        Route::get('/disposisi/{id}/review', [PimpinanDisposisiController::class, 'review'])->name('disposisi.review');
        Route::put('/disposisi/{id}', [PimpinanDisposisiController::class, 'update'])->name('disposisi.update');

        
    });

    /*
    |--------------------------------------------------------------------------
    | STAFF (role: staff)
    |--------------------------------------------------------------------------
    */
    Route::prefix('staff')->middleware('role:staff')->name('staff.')->group(function () {
        Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');
        Route::resource('surat', StaffSuratController::class);
        Route::get('/disposisi', [\App\Http\Controllers\StaffDisposisiController::class, 'index'])->name('disposisi.index');
        Route::get('/disposisi/{id}', [\App\Http\Controllers\StaffDisposisiController::class, 'show'])->name('disposisi.show');
        Route::patch('/disposisi/{id}/status', [\App\Http\Controllers\StaffDisposisiController::class, 'updateStatus'])->name('disposisi.updateStatus');
    });

    /*
    |--------------------------------------------------------------------------
    | DISPOSISI SHARED (tusekwan & pimpinan)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:tusekwan,pimpinan')->group(function () {
        Route::get('/disposisi', [DisposisiController::class, 'index'])->name('disposisi.index');
        Route::get('/disposisi/create/{surat}', [DisposisiController::class, 'create'])->name('disposisi.create');
        Route::post('/disposisi/store', [DisposisiController::class, 'store'])->name('disposisi.store');
        Route::get('/disposisi/{id}', [DisposisiController::class, 'show'])->name('disposisi.show');
        Route::patch('/disposisi/{id}/status', [DisposisiController::class, 'updateStatus'])->name('disposisi.updateStatus');
    });

    // Arsip (public to authenticated)
    Route::resource('arsip', ArsipController::class)->only(['index', 'create', 'store']);
});

require __DIR__ . '/auth.php';
