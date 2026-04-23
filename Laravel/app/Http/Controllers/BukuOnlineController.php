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
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
            'buku_url' => 'required|string|max:255',
            'penulis' => 'required|string|max:30',
            'sumber' => 'required|string|max:30',
        ]);

        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = time() . '_' . $image->getClientOriginalName(); // Nama unik
            $image->move(public_path('bukuonlineimg'), $imageName); // Simpan di folder public/sparepart
        } else {
            $imageName = null; // Jika tidak ada gambar yang diupload
        }

        BukuOnline::create([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'genre' => $request->genre,
            'penjelasan' => $request->penjelasan,
            'img' => $imageName,
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
        $BukuOnline = BukuOnline::where('id_buku', $id_buku)->first();
        // Validasi data input
        $request->validate([
            'judul' => 'required|string|max:50',
            'kategori' => 'required|string|max:20',
            'genre' => 'required|string|max:20',
            'penjelasan' => 'required|string|max:255',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
            'buku_url' => 'required|string|max:255',
            'penulis' => 'required|string|max:30',
            'sumber' => 'required|string|max:30',
        ]);

        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('bukuonlineimg'), $imageName);

            // hapus file lama jika ada
            if ($BukuOnline->img && file_exists(public_path('bukuonlineimg/' . $BukuOnline->img))) {
                unlink(public_path('bukuonlineimg/' . $BukuOnline->img));
            }
        } else {
            $imageName = $BukuOnline->img; // tetap pakai gambar lama
        }

        // Cari siswa berdasarkan id

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
            'img' => $imageName,
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
         if ($BukuOnline->image) {
            $imagePath = public_path('BukuOnline/' . $BukuOnline->image);

            // Hapus gambar jika file ada
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $BukuOnline->delete();
        return redirect('BukuOnline')->with('success', 'Buku berhasil dihapus!');
    }
}
