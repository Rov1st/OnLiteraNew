<?php

namespace App\Http\Controllers;

use App\Models\BukuOnline;
use Illuminate\Http\Request;

class BukuOnlineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $BukuOnline = BukuOnline::all(); // Ambil semua data guru
        return view('BukuOnline.index', compact('BukuOnline'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('BukuOnline/create');
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
            'buku_url' => 'required|string|max:255',
            'penulis' => 'required|string|max:30',
            'sumber' => 'required|string|max:30',
        ]);

        BukuOnline::create([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'genre' => $request->genre,
            'penjelasan' => $request->penjelasan,
            'buku_url' => $request->buku_url,
            'penulis' => $request->penulis,
            'sumber' => $request->sumber,
        ]);

        return redirect('BukuOnline')->with('success', 'buku berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(BukuOnline $bukuOnline)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_buku)
    {
        $BukuOnline = BukuOnline::where('id_buku', $id_buku)->first();
        return view('BukuOnline.edit', compact('BukuOnline'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_buku)
    {
        // Validasi data input
        $request->validate([
            'judul' => 'required|string|max:50',
            'kategori' => 'required|string|max:20',
            'genre' => 'required|string|max:20',
            'penjelasan' => 'required|string|max:255',
            'buku_url' => 'required|string|max:255',
            'penulis' => 'required|string|max:30',
            'sumber' => 'required|string|max:30',
        ]);

        // Cari siswa berdasarkan id
        $BukuOnline = BukuOnline::where('id_buku', $id_buku)->first();

        // Kalau siswa tidak ditemukan
        if (!$BukuOnline) {
            return redirect()->route('BukuOnline.index')->with('error', 'Data buku tidak ditemukan!');
        }

        // Update data siswa
        $BukuOnline->update([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'genre' => $request->genre,
            'penjelasan' => $request->penjelasan,
            'buku_url' => $request->buku_url,
            'penulis' => $request->penulis,
            'sumber' => $request->sumber,
        ]);

        return redirect()->route('BukuOnline.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_buku)
    {
        $BukuOnline = BukuOnline::where('id_buku', $id_buku)->first();
        $BukuOnline->delete();
        return redirect('BukuOnline')->with('success', 'Buku berhasil dihapus!');
    }
}
