<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuOnlineController;
use App\Http\Controllers\BukuOfflineController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailPeminjamanController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::get('BukuOnline', [BukuOnlineController::class, 'index'])->name('BukuOnline.index');
Route::get('BukuOnline/create', [BukuOnlineController::class, 'create'])->name('BukuOnline.create');
Route::post('BukuOnline', [BukuOnlineController::class, 'store'])->name('BukuOnline.store');
Route::delete('BukuOnline/{id_buku}', [BukuOnlineController::class, 'destroy'])->name('BukuOnline.destroy');
Route::get('BukuOnline/{id_buku}/edit', [BukuOnlineController::class, 'edit'])->name('BukuOnline.edit');
Route::put('BukuOnline/{id_buku}', [BukuOnlineController::class, 'update'])->name('BukuOnline.update');

Route::get('BukuOffline', [BukuOfflineController::class, 'index'])->name('BukuOffline.index');
Route::get('BukuOffline/create', [BukuOfflineController::class, 'create'])->name('BukuOffline.create');
Route::post('BukuOffline', [BukuOfflineController::class, 'store'])->name('BukuOffline.store');
Route::delete('BukuOffline/{id_buku}', [BukuOfflineController::class, 'destroy'])->name('BukuOffline.destroy');
Route::get('BukuOffline/{id_buku}/edit', [BukuOfflineController::class, 'edit'])->name('BukuOffline.edit');
Route::put('BukuOffline/{id_buku}', [BukuOfflineController::class, 'update'])->name('BukuOffline.update');

Route::get('Peminjaman', [PeminjamanController::class, 'index'])->name('Peminjaman.index');
Route::get('Peminjaman/create', [PeminjamanController::class, 'create'])->name('Peminjaman.create');
Route::post('Peminjaman', [PeminjamanController::class, 'store'])->name('Peminjaman.store');
Route::delete('Peminjaman/{id_peminjaman}', [PeminjamanController::class, 'destroy'])->name('Peminjaman.destroy');
Route::get('Peminjaman/{id_peminjaman}/edit', [PeminjamanController::class, 'edit'])->name('Peminjaman.edit');
Route::put('Peminjaman/{id_peminjaman}', [PeminjamanController::class, 'update'])->name('Peminjaman.update');

Route::get('Pengembalian', [PengembalianController::class, 'index'])->name('Pengembalian.index');
Route::get('Pengembalian/create', [PengembalianController::class, 'create'])->name('Pengembalian.create');
Route::post('Pengembalian', [PengembalianController::class, 'store'])->name('Pengembalian.store');
Route::delete('Pengembalian/{id_pengembalian}', [PengembalianController::class, 'destroy'])->name('Pengembalian.destroy');
Route::get('Pengembalian/{id_pengembalian}/edit', [PengembalianController::class, 'edit'])->name('Pengembalian.edit');
Route::put('Pengembalian/{id_pengembalian}', [PengembalianController::class, 'update'])->name('Pengembalian.update');

Route::get('DetailPeminjaman', [DetailPeminjamanController::class, 'index'])->name('DetailPeminjaman.index');
Route::get('DetailPeminjaman/create', [DetailPeminjamanController::class, 'create'])->name('DetailPeminjaman.create');
Route::post('DetailPeminjaman', [DetailPeminjamanController::class, 'store'])->name('DetailPeminjaman.store');
Route::delete('DetailPeminjaman/{id_DetailPeminjaman}', [DetailPeminjamanController::class, 'destroy'])->name('DetailPeminjaman.destroy');
Route::get('DetailPeminjaman/{id_DetailPeminjaman}/edit', [DetailPeminjamanController::class, 'edit'])->name('DetailPeminjaman.edit');
Route::put('DetailPeminjaman/{id_DetailPeminjaman}', [DetailPeminjamanController::class, 'update'])->name('DetailPeminjaman.update');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
