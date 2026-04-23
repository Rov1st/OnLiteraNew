<?php

// routes/api.php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Models\User;
use App\Models\BukuOffline;
use App\Models\Genre;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicBookController;
use App\Http\Controllers\UserExperienceController;
use League\Flysystem\UrlGeneration\PublicUrlGenerator;

Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register']);

Route::get('/users', function () {
    return User::all();
});

Route::post('/favorit/toggle', [UserExperienceController::class, 'toggleFavorit']);
Route::get('/favorite/check/{id_user}/{id_buku}', [UserExperienceController::class, 'checkFavorit']);
Route::get('/favorit/{id_user}', [UserExperienceController::class, 'favorit']);

Route::get('/peminjaman/aktif/{id_user}/{tanggal}', [UserExperienceController::class, 'cekAktif']);
Route::post('/peminjaman', [UserExperienceController::class, 'pinjamBuku']);
Route::post('/peminjaman/detail', [UserExperienceController::class, 'pinjamSatuBuku']);
Route::post('/peminjaman/full', [UserExperienceController::class, 'pinjamFull']);
Route::post('/peminjaman/keranjang', [UserExperienceController::class, 'pinjamDariKeranjang']);
Route::get('/transaksi/{id_user}', [UserExperienceController::class, 'tampilTransaksi']);
Route::put('/transaksi/{id}/batalkan', [UserExperienceController::class, 'batalkanPeminjaman']);

Route::post('/contact', [UserExperienceController::class, 'contactUs']);


Route::post('/counter/{id_buku}', [PublicBookController::class, 'counter']);

Route::post('/keranjang', [UserExperienceController::class, 'pushKeranjang']);
Route::get('/keranjang/{id_user}', [PublicBookController::class,'keranjang']);
Route::get('/keranjang/{id_user}/{id_buku}', [UserExperienceController::class, 'hapusKeranjang']);

Route::get('/book/{id}', [PublicBookController::class, 'show']);
Route::get('/book', [PublicBookController::class, 'index']);

Route::get('/genre/{id}', [PublicBookController::class, 'displayGenre']);

Route::put('/user/{id}', [AuthController::class, 'update']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/update-phone', [AuthController::class, 'updatePhone']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json($request->user());
});

