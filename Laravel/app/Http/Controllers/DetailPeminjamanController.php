<?php

namespace App\Http\Controllers;

use App\Models\DetailPeminjaman;
use App\Models\BukuOffline;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailPeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $DetailPeminjaman = DetailPeminjaman::with(['peminjaman', 'buku'])->get();
        $peminjaman = Peminjaman::all();
        $buku = BukuOffline::all();
        $user = User::all();

        return view('DetailPeminjaman', compact('DetailPeminjaman', 'peminjaman', 'buku', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pinjam' => 'required|date',
            'tanggal_harus_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|in:Selesai,Belum',
            'id_user' => 'required|integer|exists:users,id',
            'id_buku' => 'required|array|min:1',
            'id_buku.*' => 'integer|exists:buku_offline,id',
        ]);

        DB::beginTransaction();
        try {
            // Simpan data peminjaman
            $peminjaman = Peminjaman::create([
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_harus_kembali' => $request->tanggal_harus_kembali,
                'status' => $request->status,
                'id_user' => $request->id_user,
            ]);

            // Simpan banyak detail peminjaman
            foreach ($request->id_buku as $bukuId) {
                DetailPeminjaman::create([
                    'id_peminjaman' => $peminjaman->id,
                    'id_buku' => $bukuId
                ]);
            }

            DB::commit();
            return redirect('DetailPeminjaman')->with('success', 'Peminjaman berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailPeminjaman $detailPeminjaman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailPeminjaman $detailPeminjaman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_peminjaman)
    {
        $request->validate([
            'tanggal_pinjam'          => 'required|date',
            'tanggal_harus_kembali'   => 'required|date|after_or_equal:tanggal_pinjam',
            'status'                  => 'required|in:Selesai,Belum',
            'id_user'                 => 'required|integer|exists:users,id',
            'id_buku'                 => 'required|array|min:1',
            'id_buku.*'               => 'integer|exists:buku_offline,id',
        ]);

        DB::transaction(function () use ($request, $id_peminjaman) {
            // Kunci baris agar aman di environment konkuren
            $peminjaman = Peminjaman::lockForUpdate()->findOrFail($id_peminjaman);

            // Admin menentukan id_user dari form
            $peminjaman->update([
                'tanggal_pinjam'         => $request->tanggal_pinjam,
                'tanggal_harus_kembali'  => $request->tanggal_harus_kembali,
                'status'                 => $request->status,
                'id_user'                => $request->id_user,
            ]);

            // Reset detail lama
            DetailPeminjaman::where('id_peminjaman', $id_peminjaman)->delete();

            // Insert detail baru (bulk insert biar hemat query)
            $rows = [];
            foreach ($request->id_buku as $bukuId) {
                $rows[] = [
                    'id_peminjaman' => $id_peminjaman,
                    'id_buku'       => $bukuId,
                ];
            }
            DetailPeminjaman::insert($rows);
        });

        return redirect('DetailPeminjaman')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id_peminjaman)
    {
        DB::transaction(function () use ($id_peminjaman) {
            // Hapus detail dulu (jika belum pakai FK cascade)
            DetailPeminjaman::where('id_peminjaman', $id_peminjaman)->delete();

            // Hapus master peminjaman
            Peminjaman::where('id', $id_peminjaman)->delete();
        });

        return redirect('DetailPeminjaman')->with('success', 'Data berhasil dihapus.');
    }
}
