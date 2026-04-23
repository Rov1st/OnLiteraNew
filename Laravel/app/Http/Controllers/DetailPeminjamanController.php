<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\User;
use App\Models\BukuOffline;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DetailPeminjamanController extends Controller
{
    public function index(Request $request)
    {
        // Update otomatis untuk peminjaman terlambat
        Peminjaman::where('status', 'Dikonfirmasi')
            ->where('tanggal_harus_kembali', '<', now())
            ->update(['status' => 'Terlambat']);

        $status = $request->get('status');
        $query = Peminjaman::with(['user', 'detailPeminjaman.buku', 'pengembalian']);

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $peminjaman = $query->get();

        $users = User::all();
        $buku = BukuOffline::all();

        return view('DetailPeminjaman.index', compact('peminjaman', 'users', 'buku', 'status'));
    }


    public function store(Request $request)
    {
        $data = $request->all();

        $id_buku = array_filter($data['id_buku'] ?? []);
        $stok = array_filter($data['stok'] ?? []);

        $request->merge([
            'id_buku' => array_values($id_buku),
            'stok' => array_values($stok),
        ]);

        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_buku.*' => 'required|exists:buku_offline,id_buku',
            'stok.*' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $tanggalPinjam = Carbon::parse($request->tanggal_pinjam);
                $tanggalHarusKembali = $tanggalPinjam->copy()->addDays(5);

                // Buat peminjaman
                $peminjaman = Peminjaman::create([
                    'id_user' => $request->id_user,
                    'tanggal_pinjam' => $request->tanggal_pinjam,
                    'tanggal_harus_kembali' => $tanggalHarusKembali,
                    'status' => 'Dikonfirmasi',
                ]);

                foreach ($request->id_buku as $index => $id_buku) {
                    $jumlahDipinjam = $request->stok[$index] ?? 1;
                    $buku = BukuOffline::lockForUpdate()->findOrFail($id_buku);

                    if ($buku->stok < $jumlahDipinjam) {
                        throw new \Exception("Stok buku {$buku->judul} tidak mencukupi!");
                    }

                    // LANGSUNG KURANGI STOK SAAT REQUEST (BERBAHAYA!)
                    $buku->decrement('stok', $jumlahDipinjam);

                    DetailPeminjaman::create([
                        'id_peminjaman' => $peminjaman->id_peminjaman,
                        'id_buku' => $id_buku,
                        'stok' => $jumlahDipinjam,
                    ]);
                }
            });

            return redirect()->route('DetailPeminjaman.index')
                ->with('success', 'Peminjaman berhasil diajukan dan stok telah dikurangi');
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_pinjam' => 'required|date',
            'tanggal_harus_kembali' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'id_user' => 'required',
            'id_buku.*' => 'required|exists:buku_offline,id_buku',
            'stok.*' => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $peminjaman = Peminjaman::with('detailPeminjaman.buku', 'pengembalian')->findOrFail($id);
                $statusLama = $peminjaman->status;

                // ✅ PERBAIKAN: Hitung berdasarkan hari saja, abaikan jam
                $tanggalKembali = Carbon::parse($request->tanggal_kembali)->startOfDay();
                $tanggalHarusKembali = Carbon::parse($request->tanggal_harus_kembali)->startOfDay();

                if ($tanggalKembali->greaterThan($tanggalHarusKembali)) {
                    $hariTerlambat = $tanggalHarusKembali->diffInDays($tanggalKembali);
                } else {
                    $hariTerlambat = 0;
                }

                // ✅ Cast ke integer untuk memastikan kelipatan 5000
                $denda = (int)($hariTerlambat * 5000);

                $statusBaru = $denda > 0 ? 'Terlambat' : 'Dikembalikan';

                // Cek pengembalian pertama kali
                $belumAdaTanggalKembali = !$peminjaman->pengembalian || !$peminjaman->pengembalian->tanggal_kembali;

                // Update peminjaman
                $peminjaman->update(['status' => $statusBaru]);

                // Update detail peminjaman
                $peminjaman->detailPeminjaman()->delete();
                foreach ($request->id_buku as $index => $id_buku) {
                    DetailPeminjaman::create([
                        'id_peminjaman' => $peminjaman->id_peminjaman,
                        'id_buku' => $id_buku,
                        'stok' => $request->stok[$index],
                    ]);
                }

                // Kembalikan stok
                if ($belumAdaTanggalKembali && in_array($statusLama, ['Dikonfirmasi', 'Terlambat'])) {
                    foreach ($peminjaman->detailPeminjaman as $detail) {
                        $detail->buku->increment('stok', $detail->stok);
                    }
                }

                // Catat pengembalian
                Pengembalian::updateOrCreate(
                    ['id_peminjaman' => $peminjaman->id_peminjaman],
                    [
                        'tanggal_kembali' => $request->tanggal_kembali,
                        'tanggal_harus_kembali' => $request->tanggal_harus_kembali,
                        'denda' => $denda,
                    ]
                );
            });

            return redirect()->route('DetailPeminjaman.index')
                ->with('success', 'Pengembalian berhasil dicatat');
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id_peminjaman)
    {
        try {
            DB::transaction(function () use ($id_peminjaman) {
                $peminjaman = Peminjaman::with('detailPeminjaman.buku')->findOrFail($id_peminjaman);

                // Selalu kembalikan stok karena stok sudah dikurangi saat request
                foreach ($peminjaman->detailPeminjaman as $detail) {
                    $detail->buku->increment('stok', $detail->stok);
                }

                $peminjaman->detailPeminjaman()->delete();
                $peminjaman->pengembalian()->delete();
                $peminjaman->delete();
            });

            return redirect()->route('DetailPeminjaman.index')
                ->with('success', 'Data peminjaman berhasil dihapus dan stok dikembalikan');
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function lunas($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Ubah status ke Dikembalikan
        $peminjaman->status = 'Dikembalikan';
        $peminjaman->save();

        return redirect()->back()->with('success', 'Status berhasil diubah menjadi Dikembalikan');
    }


    public function konfirmasi($id)
    {
        try {
            $peminjaman = Peminjaman::findOrFail($id);

            if ($peminjaman->status !== 'Menunggu Konfirmasi') {
                throw new \Exception('Peminjaman tidak dalam status menunggu konfirmasi.');
            }

            // Hanya ubah status, stok sudah dikurangi saat request
            $peminjaman->update(['status' => 'Dikonfirmasi']);

            return redirect()->route('DetailPeminjaman.index')
                ->with('success', 'Peminjaman berhasil dikonfirmasi');
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function tolak($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $peminjaman = Peminjaman::with('detailPeminjaman.buku')->findOrFail($id);

                if ($peminjaman->status !== 'Menunggu Konfirmasi') {
                    throw new \Exception('Peminjaman tidak dalam status menunggu konfirmasi.');
                }

                // WAJIB: Kembalikan stok yang sudah dikurangi saat request
                foreach ($peminjaman->detailPeminjaman as $detail) {
                    $buku = $detail->buku;

                    // Log untuk tracking
                    // \Log::info("Mengembalikan stok buku {$buku->judul}: {$detail->stok} unit");

                    // Tambahkan kembali stok yang sudah dikurangi
                    $buku->increment('stok', $detail->stok);
                }

                $peminjaman->update(['status' => 'Ditolak']);
            });

            return redirect()->route('DetailPeminjaman.index')
                ->with('success', 'Peminjaman berhasil ditolak dan stok buku telah dikembalikan');
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Quick Fix Methods untuk debugging
    public function fixEmptyStatus(Request $request)
    {
        $request->validate([
            'default_status' => 'required|in:Menunggu Konfirmasi,Dikonfirmasi,Ditolak,Dikembalikan'
        ]);

        try {
            $updated = DB::table('peminjaman')
                ->whereNull('status')
                ->orWhere('status', '')
                ->orWhereRaw('TRIM(status) = ""')
                ->update(['status' => $request->default_status]);

            return redirect()->back()
                ->with('success', "Berhasil memperbaiki {$updated} record dengan status kosong");
        } catch (\Exception $e) {
            return back()->withErrors('Error: ' . $e->getMessage());
        }
    }

    public function manualStatusUpdate(Request $request)
    {
        $request->validate([
            'id_peminjaman' => 'required|exists:peminjaman,id_peminjaman',
            'new_status' => 'required|in:Menunggu Konfirmasi,Dikonfirmasi,Ditolak,Dikembalikan'
        ]);

        try {
            $peminjaman = Peminjaman::findOrFail($request->id_peminjaman);
            $oldStatus = $peminjaman->status;

            $peminjaman->update(['status' => $request->new_status]);

            return redirect()->back()
                ->with('success', "Status peminjaman ID {$request->id_peminjaman} berhasil diubah dari '{$oldStatus}' ke '{$request->new_status}'");
        } catch (\Exception $e) {
            return back()->withErrors('Error: ' . $e->getMessage());
        }
    }
}
