<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberGateController;

// ===================================
// PUBLIC ROUTES
// ===================================
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/member/check', [MemberController::class, 'check']);
Route::post('/tiket', [TiketController::class, 'create']);
Route::get('/tiket/{kode}', [TiketController::class, 'showByKode']);
Route::get('/qrcode/{kode}', [TiketController::class, 'qrcode']);


// ===================================
// PROTECTED ROUTES
// ===================================
Route::middleware(['auth:sanctum'])->group(function () {
    
    // Auth Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Route Gate Masuk & Keluar
    Route::post('/gate/masuk-member', [MemberGateController::class, 'masukMember']);
    Route::post('/gate/scan', [MemberGateController::class, 'scanGate']);
    
    // Route Member
    Route::post('/member/bayar/{id}', [MemberController::class, 'bayarMember']);
    Route::put('/member/{id}/pembayaran', [MemberController::class, 'updatePembayaran']);
    Route::apiResource('/member', MemberController::class);

    // Route Admin 
    Route::get('/admin/petugas', [UserController::class, 'index']);
    Route::post('/admin/petugas', [UserController::class, 'store']);
    Route::put('/admin/petugas/{id}/reset-password', [UserController::class, 'updatePassword']);
    Route::delete('/admin/petugas/{id}', [UserController::class, 'destroy']);

    // Route Transaksi & Payment
    Route::get('/transaksi', [TransaksiController::class, 'index']);
    Route::post('/scan', [PaymentController::class, 'scan']);
    Route::post('/payment', [PaymentController::class, 'bayar']);
    Route::post('/transaksi/bayar', [TransaksiController::class, 'store']);

    // Route Laporan
    Route::get('/laporan/member', [LaporanController::class, 'member']);
    Route::get('/laporan/non-member', [LaporanController::class, 'nonMember']);
    Route::get('/admin/laporan', [LaporanController::class, 'rekapGlobal']); 

    // Route Dashboard Admin
    Route::get('/dashboard/stats', [DashboardController::class, 'index']);
    Route::get('/parkir/aktif', [TiketController::class, 'kendaraanAktif']);

});