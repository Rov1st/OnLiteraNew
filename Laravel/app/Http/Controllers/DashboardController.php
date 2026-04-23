<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BukuOffline;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Pengembalian;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data untuk card
        $jumlahAnggota = User::count();
        $jumlahBuku = BukuOffline::count();
        $jumlahPeminjamanBelumKonfirmasi = Peminjaman::where('status', 'Menunggu Dikonfirmasi')->count();
        $peminjamanBelumKonfirmasi = Peminjaman::where('status', 'Menunggu Konfirmasi')
        ->with('user')
        ->get();

        // Ambil data untuk chart (per bulan)
        $peminjamanPerBulan = [];
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $peminjamanPerBulan[] = Peminjaman::whereMonth('tanggal_pinjam', $bulan)
                ->whereYear('tanggal_pinjam', date('Y'))
                ->count();
        }
        // Statistik tambahan
        $peminjamanBulanIni = Peminjaman::whereMonth('tanggal_pinjam', now()->month)->count();
        $pengembalianBulanIni = Pengembalian::whereMonth('tanggal_kembali', now()->month)->count();
        $totalDendaBulanIni = Pengembalian::whereMonth('tanggal_kembali', now()->month)->sum('denda');

        // Top 5 Buku
        $topBuku = DetailPeminjaman::with('buku')
            ->select('id_buku', DB::raw('COUNT(*) as total'))
            ->groupBy('id_buku')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // Top 5 User
        $topUser = Peminjaman::with('user')
            ->select('id_user', DB::raw('COUNT(*) as total'))
            ->groupBy('id_user')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // Status peminjaman (pie chart)
        $statusPeminjaman = Peminjaman::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // fallback default kalau kosong
        if ($statusPeminjaman->isEmpty()) {
            $statusPeminjaman = collect([
                'Belum' => 0,
                'Dipinjam' => 0,
                'Selesai' => 0,
            ]);
        }
        return view('dashboard', compact(
            'jumlahAnggota',
            'jumlahBuku',
            'jumlahPeminjamanBelumKonfirmasi',
            'peminjamanBelumKonfirmasi',
            'peminjamanPerBulan',
            'peminjamanBulanIni',
            'pengembalianBulanIni',
            'totalDendaBulanIni',
            'topBuku',
            'topUser',
            'statusPeminjaman'
        ));
    }
}
