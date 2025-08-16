<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Peminjaman = Peminjaman::all();
        $Pengembalian = Pengembalian::all(); // Ambil semua data Pengembalian
        $Pengembalian = Pengembalian::with('peminjaman')->get(); // Ambil semua data Pengembalian
        return view('Pengembalian.index', compact('Pengembalian', 'Peminjaman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Peminjaman = Peminjaman::all();
        $Pengembalian = Pengembalian::all();
        return view('Pengembalian/create', compact('Peminjaman', 'Pengembalian'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'id_peminjaman' => 'required|integer|exists:peminjaman,id_peminjaman',
            'tanggal_kembali' => 'required|date',
            'tanggal_harus_kembali' => 'required|date',
            'denda' => 'required|integer',
        ]);


        Pengembalian::create([
            'id_peminjaman' => $request->id_peminjaman,
            'tanggal_kembali' => $request->tanggal_kembali,
            'tanggal_harus_kembali' => $request->tanggal_harus_kembali,
            'denda' => $request->denda,
        ]);
        return redirect('Pengembalian')->with('success', 'nilai Berhasil Ditambah..');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengembalian $pengembalian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_pengembalian)
    {
        $Peminjaman = Peminjaman::all();

        $Pengembalian = Pengembalian::where('id_pengembalian', $id_pengembalian)->first();

        return view('Pengembalian/edit', compact('Peminjaman', 'Pengembalian'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_pengembalian)
    {
         $Pengembalian = Pengembalian::where('id_pengembalian', $id_pengembalian)->first();

        if (!$Pengembalian) {
            return redirect('Pengembalian')->with('success', 'Peminjaman Gagal Diubah..');
        }


        $request->validate([
            'id_peminjaman' => 'required|integer|exists:peminjaman,id_peminjaman',
            'tanggal_kembali' => 'required|date',
            'tanggal_harus_kembali' => 'required|date',
            'denda' => 'required|integer',
        ]);

        $Pengembalian->update([
            'id_peminjaman' => $request->id_peminjaman,
            'tanggal_kembali' => $request->tanggal_kembali,
            'tanggal_harus_kembali' => $request->tanggal_harus_kembali,
            'denda' => $request->denda,
        ]);

        return redirect('Pengembalian')->with('success', 'Data Peminjaman Berhasil Diubah..');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_pengembalian)
    {
         Pengembalian::where('id_pengembalian', $id_pengembalian)->delete();
        return redirect('Pengembalian')->with('success', 'Peminjaman berhasil dihapus..');
    }
}
