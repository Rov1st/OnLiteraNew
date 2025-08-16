<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BukuOffline;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data untuk card
        $jumlahAnggota = User::count();
        $jumlahBuku = BukuOffline::count();
        $jumlahPeminjamanBelumKonfirmasi = Peminjaman::where('status', 'Belum')->count();

        // Ambil data untuk chart (per bulan)
        $peminjamanPerBulan = [];
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $peminjamanPerBulan[] = Peminjaman::whereMonth('tanggal_pinjam', $bulan)
            ->whereYear('tanggal_pinjam', date('Y'))
            ->count();
        }

        return view('dashboard', compact(
            'jumlahAnggota',
            'jumlahBuku',
            'jumlahPeminjamanBelumKonfirmasi',
            'peminjamanPerBulan'
        ));
    }
}


