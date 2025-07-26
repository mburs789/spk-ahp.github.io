<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\SubkriteriaController;
use App\Http\Controllers\PerbandinganKriteriaController;
use App\Http\Controllers\PerbandinganSubkriteriaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PerangkinganController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\NotificationController;


// Halaman utama (redirect ke login jika belum login)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Middleware auth untuk semua user yang sudah login
Route::middleware(['auth'])->group(function () {

    // Rute untuk Dashboard (dapat diakses oleh semua peran)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute yang dapat diakses oleh Admin, Supervisor, dan Manager
    Route::middleware('role:admin|supervisor')->group(function () {
        // Admin & Supervisor memiliki akses yang sama untuk beberapa rute berikut
        Route::resource('/karyawan', KaryawanController::class);
        Route::resource('/kriteria', KriteriaController::class);
        Route::resource('/subkriteria', SubkriteriaController::class);
        Route::resource('/perbandingankriteria', PerbandinganKriteriaController::class);
        Route::resource('/perbandingansubkriteria', PerbandinganSubkriteriaController::class);
        Route::resource('/penilaian', PenilaianController::class);
    });

    // Rute khusus untuk Admin
    Route::middleware('role:admin')->group(function () {
        Route::resource('/user', UserController::class);
    });

    // Rute khusus untuk Admin dan Manager
    Route::middleware('role:admin|manager')->group(function () {
        Route::get('/perangkingan/export-pdf', [PerangkinganController::class, 'exportPdf'])->name('perangkingan.export-pdf');
        Route::resource('/perangkingan', PerangkinganController::class)->except(['show']);
        Route::put('/perangkingan/{id}/status', [PerangkinganController::class, 'updateStatus'])->name('perangkingan.updateStatus');
    });

    // Rute untuk mengelola notifikasi hanya untuk Supervisor
    Route::middleware('role:supervisor')->group(function () {
        Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');  // Tandai notifikasi sebagai dibaca
        Route::delete('/notifications/{id}', [NotificationController::class, 'delete'])->name('notifications.delete');  // Hapus notifikasi
    });

    // Rute yang dapat diakses oleh semua peran
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Auth routes
require __DIR__.'/auth.php';
