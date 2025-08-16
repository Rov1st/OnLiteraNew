<?php

namespace App\Http\Controllers;

use App\Models\BukuOffline;
use Illuminate\Http\Request;

class BukuOfflineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $BukuOffline = BukuOffline::all();
        return view('BukuOffline.index', compact('BukuOffline'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('BukuOffline/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:50',
            'kategori' => 'required|string|max:20',
            'genre' => 'required|string|max:20',
            'penjelasan' => 'required|string|max:255',
            'penulis' => 'required|string|max:30',
            'penerbit' => 'required|string|max:20',
            'sumber_perpustakaan' => 'required|string|max:30',
            'status' => 'required|string|in:tersedia,tidak tersedia',
        ]);

        BukuOffline::create([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'genre' => $request->genre,
            'penjelasan' => $request->penjelasan,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'sumber_perpustakaan' => $request->sumber_perpustakaan,
            'status' => $request->status,
        ]);

        return redirect('BukuOffline')->with('success', 'buku berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(BukuOffline $bukuOffline)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_buku)
    {
        $BukuOffline = BukuOffline::where('id_buku', $id_buku)->first();
        return view('BukuOffline.edit', compact('BukuOffline'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_buku)
    {
        $request->validate([
            'judul' => 'required|string|max:50',
            'kategori' => 'required|string|max:20',
            'genre' => 'required|string|max:20',
            'penjelasan' => 'required|string|max:255',
            'penulis' => 'required|string|max:30',
            'penerbit' => 'required|string|max:20',
            'sumber_perpustakaan' => 'required|string|max:30',
            'status' => 'required|string|in:tersedia,tidak tersedia',
        ]);

        // Cari siswa berdasarkan id
        $BukuOffline = BukuOffline::where('id_buku', $id_buku)->first();

        // Kalau siswa tidak ditemukan
        if (!$BukuOffline) {
            return redirect()->route('BukuOffline.index')->with('error', 'Data buku tidak ditemukan!');
        }

        // Update data siswa
        $BukuOffline->update([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'genre' => $request->genre,
            'penjelasan' => $request->penjelasan,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'sumber_perpustakaan' => $request->sumber_perpustakaan,
            'status' => $request->status,
        ]);

        return redirect()->route('BukuOffline.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_buku)
    {
        $BukuOffline = BukuOffline::where('id_buku', $id_buku)->first();
        $BukuOffline->delete();
        return redirect('BukuOffline')->with('success', 'Buku berhasil dihapus!');
    }
}
