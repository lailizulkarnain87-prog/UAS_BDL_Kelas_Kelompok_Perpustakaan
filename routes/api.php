<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\PenerbitController;
use App\Http\Controllers\Api\RakController;
use App\Http\Controllers\Api\AnggotaController;
use App\Http\Controllers\Api\PetugasController;
use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\PeminjamanController;
use App\Http\Controllers\Api\PengembalianController;
use App\Http\Controllers\Api\ReservasiController;
use App\Http\Controllers\Api\DendaController;
use App\Http\Controllers\Api\PembayaranDendaController;
use App\Http\Controllers\Api\RiwayatStatusDendaController;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
    Route::get('/user', function (Request $request) { return $request->user(); });

    // Semua user yang login bisa akses (anggota, petugas, admin)
    Route::get('buku', [BukuController::class, 'index']);
    Route::get('buku/{id}', [BukuController::class, 'show']);

    // Hanya petugas & admin
    Route::middleware('role:admin,petugas')->group(function () {
        Route::apiResource('kategori', KategoriController::class);
        Route::apiResource('penerbit', PenerbitController::class);
        Route::apiResource('rak', RakController::class);
        Route::apiResource('anggota', AnggotaController::class);
        Route::patch('anggota/{id}/status', [AnggotaController::class, 'toggleStatus']);
        
        Route::apiResource('petugas', PetugasController::class);
        
        Route::apiResource('buku', BukuController::class)->except(['index','show']);
        Route::patch('buku/{id}/stok', [BukuController::class, 'updateStok']);
        
        Route::apiResource('peminjaman', PeminjamanController::class);
        
        Route::apiResource('pengembalian', PengembalianController::class)->except(['update', 'destroy']);
        
        Route::apiResource('reservasi', ReservasiController::class);
        Route::patch('reservasi/{id}/klaim', [ReservasiController::class, 'klaim']);
        Route::patch('reservasi/{id}/batal', [ReservasiController::class, 'batal']);
        
        Route::apiResource('denda', DendaController::class);
        Route::patch('denda/{denda}/status', [DendaController::class, 'updateStatus']);
        Route::get('denda/{denda}/pembayaran', [PembayaranDendaController::class, 'index']);
        Route::post('denda/{denda}/pembayaran', [PembayaranDendaController::class, 'store']);
        Route::get('pembayaran-denda/{pembayaran_denda}', [PembayaranDendaController::class, 'show']);
        Route::get('denda/{denda}/riwayat-status', [RiwayatStatusDendaController::class, 'index']);
    });

    // Hanya admin
    Route::middleware('role:admin')->group(function () {
        // Endpoint khusus admin seperti hapus permanen, dll
    });
});
