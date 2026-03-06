<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;

// ===================
// Landing Page
// ===================
Route::get('/', function () {
    // Jika sudah login, langsung ke dashboard
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return view('welcome');
})->name('landing');

// ===================
// Auth Routes (Breeze)
// ===================
require __DIR__.'/auth.php';

// ===================
// Authenticated Routes
// ===================
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Surat
    Route::resource('surat', SuratController::class);
    Route::post('/surat/{id}/proses', [SuratController::class, 'proses'])->name('surat.proses');
    Route::post('/surat/{id}/kirim-ke-unit', [SuratController::class, 'kirimKeUnit'])->name('surat.kirim-ke-unit');
    // Di dalam group middleware auth, tambahkan route berikut:
Route::get('/surat/lampiran/all', [SuratController::class, 'lampiran'])->name('surat.lampiran');// Di dalam group middleware auth, tambahkan route berikut:
Route::get('/surat/lampiran/all', [SuratController::class, 'lampiran'])->name('surat.lampiran');

    // Role & Permission Management (Hanya Admin)
    Route::group(['middleware' => ['role:Admin']], function () {
        Route::resource('roles', RoleController::class);
    });

    // User & Unit
    Route::resource('user', UserController::class);
    Route::resource('unit', UnitController::class);

    // Approval
    Route::post('/approval/{id}/approve', [ApprovalController::class, 'approve'])->name('approval.approve');
    Route::post('/approval/{id}/reject', [ApprovalController::class, 'reject'])->name('approval.reject');

    // Notifikasi
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::get('/notifikasi/{id}', [NotifikasiController::class, 'show'])->name('notifikasi.show');
    Route::post('/notifikasi/{id}/mark-read', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.mark-read');
    Route::post('/notifikasi/mark-all-read', [NotifikasiController::class, 'markAllAsRead'])->name('notifikasi.mark-all-read');
});
