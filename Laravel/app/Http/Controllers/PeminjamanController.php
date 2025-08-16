<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Peminjaman = Peminjaman::all(); // Ambil semua data Peminjaman
        $Peminjaman = Peminjaman::with('user')->get(); // Ambil semua data Peminjaman
        $user = User::all();
        return view('Peminjaman.index', compact('user','Peminjaman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::all();
        $Peminjaman = Peminjaman::all();
        return view('Peminjaman/create', compact('user', 'Peminjaman'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pinjam' => 'required|date',
            'tanggal_harus_kembali' => 'required|date',
            'status' => 'required|in:Selesai,Belum',
            'id_user' => 'required|integer|exists:users,id',
        ]);


        Peminjaman::create([
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_harus_kembali' => $request->tanggal_harus_kembali,
            'status' => $request->status,
            'id_user' => $request->id_user,
        ]);
        return redirect('Peminjaman')->with('success', 'nilai Berhasil Ditambah..');
    }

    /**
     * Display the specified resource.
     */
    public function show(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_peminjaman)
    {
        $user = User::all();

        $Peminjaman = Peminjaman::where('id_peminjaman', $id_peminjaman)->first();

        return view('Peminjaman/edit', compact('Peminjaman', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_peminjaman)
    {
        $Peminjaman = Peminjaman::where('id_Peminjaman', $id_peminjaman)->first();

        if (!$Peminjaman) {
            return redirect('Peminjaman')->with('success', 'Peminjaman Gagal Diubah..');
        }


        $request->validate([
            'tanggal_pinjam' => 'required|date',
            'tanggal_harus_kembali' => 'required|date',
            'status' => 'required|in:Selesai,Belum',
            'id_user' => 'required|integer|exists:users,id',
        ]);

        $Peminjaman->update([
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_harus_kembali' => $request->tanggal_harus_kembali,
            'status' => $request->status,
            'id_user' => $request->id_user,
        ]);

        return redirect('Peminjaman')->with('success', 'Data Peminjaman Berhasil Diubah..');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_peminjaman)
    {
        Peminjaman::where('id_peminjaman', $id_peminjaman)->delete();
        return redirect('Peminjaman')->with('success', 'Peminjaman berhasil dihapus..');
    }
}
