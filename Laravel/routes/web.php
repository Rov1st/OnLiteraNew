<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuOnlineController;
use App\Http\Controllers\BukuOfflineController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailPeminjamanController;
use App\Http\Controllers\DetailBukuController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GenreController;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Exports\LaporanBulananExport;



Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'pengelola'])
    ->name('dashboard');

Route::get('/laporan-bulanan/{bulan}/{tahun}', function ($bulan, $tahun) {
    return Excel::download(new LaporanBulananExport($bulan, $tahun), "laporan-{$bulan}-{$tahun}.xlsx");
});

Route::get('/notif/unread-data', function () {
    $pinjamBelumKonfirmasi = \App\Models\Peminjaman::with('user')
        ->where('status', 'Menunggu Konfirmasi')
        ->latest()
        ->take(5)
        ->get();

    $count = \App\Models\Peminjaman::where('status', 'Menunggu Konfirmasi')->count();

    return response()->json([
        'count' => $count,
        'list'  => $pinjamBelumKonfirmasi
    ]);
});


Route::middleware(['auth', 'pengelola'])->group(function () {
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

    Route::get('DetailBuku', [DetailBukuController::class, 'index'])->name('DetailBuku.index');
    Route::get('DetailBuku/create', [DetailBukuController::class, 'create'])->name('DetailBuku.create');
    Route::post('DetailBuku', [DetailBukuController::class, 'store'])->name('DetailBuku.store');
    Route::delete('DetailBuku/{barcode}', [DetailBukuController::class, 'destroy'])->name('DetailBuku.destroy');
    Route::get('DetailBuku/{barcode}/edit', [DetailBukuController::class, 'edit'])->name('DetailBuku.edit');
    Route::put('DetailBuku/{barcode}', [DetailBukuController::class, 'update'])->name('DetailBuku.update');

    Route::get('DetailPeminjaman', [DetailPeminjamanController::class, 'index'])->name('DetailPeminjaman.index');
    Route::get('DetailPeminjaman/create', [DetailPeminjamanController::class, 'create'])->name('DetailPeminjaman.create');
    Route::post('DetailPeminjaman', [DetailPeminjamanController::class, 'store'])->name('DetailPeminjaman.store');
    Route::delete('DetailPeminjaman/{id_peminjaman}', [DetailPeminjamanController::class, 'destroy'])->name('DetailPeminjaman.destroy');
    Route::get('DetailPeminjaman/{id_DetailPeminjaman}/edit', [DetailPeminjamanController::class, 'edit'])->name('DetailPeminjaman.edit');
    Route::put('DetailPeminjaman/{id_peminjaman}', [DetailPeminjamanController::class, 'update'])->name('DetailPeminjaman.update');
    Route::put('DetailPeminjaman/{id}/konfirmasi', [DetailPeminjamanController::class, 'konfirmasi'])->name('DetailPeminjaman.konfirmasi');
    Route::put('DetailPeminjaman/{id}/tolak', [DetailPeminjamanController::class, 'tolak'])->name('DetailPeminjaman.tolak');
    Route::put('DetailPeminjaman/{id}/lunas', [DetailPeminjamanController::class, 'lunas'])->name('DetailPeminjaman.lunas');

    Route::get('Pengembalian', [PengembalianController::class, 'index'])->name('Pengembalian.index');
    Route::get('Pengembalian/create', [PengembalianController::class, 'create'])->name('Pengembalian.create');
    Route::post('Pengembalian', [PengembalianController::class, 'store'])->name('Pengembalian.store');
    Route::delete('Pengembalian/{id_pengembalian}', [PengembalianController::class, 'destroy'])->name('Pengembalian.destroy');
    Route::get('Pengembalian/{id_pengembalian}/edit', [PengembalianController::class, 'edit'])->name('Pengembalian.edit');
    Route::put('Pengembalian/{id_pengembalian}', [PengembalianController::class, 'update'])->name('Pengembalian.update');
    // Routes untuk debugging dan quick fix
    Route::post('DetailPeminjaman/fix-empty-status', [DetailPeminjamanController::class, 'fixEmptyStatus']);
    Route::post('DetailPeminjaman/manual-status-update', [DetailPeminjamanController::class, 'manualStatusUpdate']);

    Route::get('Contact', [ContactController::class, 'index'])->name('Contact.index');
    Route::get('Contact/create', [ContactController::class, 'create'])->name('Contact.create');
    Route::post('Contact', [ContactController::class, 'store'])->name('Contact.store');
    Route::delete('Contact/{id}', [ContactController::class, 'destroy'])->name('Contact.destroy');
    Route::get('Contact/{id}/edit', [ContactController::class, 'edit'])->name('Contact.edit');
    Route::put('Contact/{id}', [ContactController::class, 'update'])->name('Contact.update');
});

Route::middleware(['auth', 'pengelola'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
