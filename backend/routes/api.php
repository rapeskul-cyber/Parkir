<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Admin Routes
    Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'getDashboardStats']);
        Route::get('/petugas', [AdminController::class, 'getPetugas']);
        Route::post('/petugas', [AdminController::class, 'createPetugas']);
        Route::put('/petugas/{id}', [AdminController::class, 'updatePetugas']);
        Route::delete('/petugas/{id}', [AdminController::class, 'deletePetugas']);
        Route::get('/laporan/member', [AdminController::class, 'getLaporanMember']);
        Route::get('/laporan/non-member', [AdminController::class, 'getLaporanNonMember']);
    });

    // Petugas Routes
    Route::middleware(\App\Http\Middleware\PetugasMiddleware::class)->prefix('petugas')->group(function () {
        Route::post('/gate/masuk', [PetugasController::class, 'scanTiketMasuk']);
        Route::post('/gate/keluar', [PetugasController::class, 'scanTiketKeluar']);
        Route::post('/gate/payment', [PetugasController::class, 'processPayment']);
        
        Route::post('/member/register', [PetugasController::class, 'registerMember']);
        Route::post('/member/check', [PetugasController::class, 'checkMemberStatus']);
        Route::post('/member/{id}/extend', [PetugasController::class, 'extendMembership']);
    });
});
