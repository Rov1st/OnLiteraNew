<?php

namespace App\Http\Controllers;

use App\Models\BukuOffline;
use App\Models\Genre;
use Illuminate\Http\Request;

class BukuOfflineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $BukuOffline = BukuOffline::with('genres')->get();
        $genres = Genre::all();
        $genreOptions = Genre::select('genre')->distinct()->pluck('genre');
        return view('BukuOffline.index', compact('BukuOffline', 'genres', 'genreOptions'));
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
        $validated = $request->validate([
            'judul' => 'required|string|max:50',
            'kategori' => 'required|string|max:20',
            'genres' => 'required|array',
            'penjelasan' => 'required|string', // untuk TEXT tidak perlu max kecil
            'penulis' => 'required|string|max:30',
            'tahun_rilis' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'penerbit' => 'required|string|max:20',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'stok' => 'required|integer|digits_between:1,2',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
            'sumber_perpustakaan' => 'required|string|max:30',
            'status' => 'required|string|in:tersedia,tidak tersedia',
        ]);

        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = time() . '_' . $image->getClientOriginalName(); // Nama unik
            $image->move(public_path('bukuofflineimg'), $imageName); // Simpan di folder public/sparepart
        } else {
            $imageName = null; // Jika tidak ada gambar yang diupload
        }

        $BukuOffline = BukuOffline::create([
            'judul' => $validated['judul'],
            'kategori' => $validated['kategori'],
            'penjelasan' => $validated['penjelasan'],
            'penulis' => $validated['penulis'],
            'tahun_rilis' => $validated['tahun_rilis'],
            'penerbit' => $validated['penerbit'],
            'tahun_terbit' => $validated['tahun_terbit'],
            'stok' => $validated['stok'],
            'img' => $imageName,
            'sumber_perpustakaan' => $validated['sumber_perpustakaan'],
            'status' => $validated['status'],
        ]);

        // simpan genre satu per satu
        foreach ($request->genres as $g) {
            Genre::create([
                'id_buku' => $BukuOffline->id_buku,
                'genre'   => $g,
            ]);
        }

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
        $genreOptions = Genre::select('genre')->distinct()->pluck('genre');
        return view('BukuOffline.edit', compact('BukuOffline', 'genres', 'genreOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_buku)
    {
        $BukuOffline = BukuOffline::where('id_buku', $id_buku)->firstOrFail();

        $validated = $request->validate([
            'judul' => 'required|string|max:50',
            'kategori' => 'required|string|max:20',
            'genres' => 'required|array',
            'penjelasan' => 'required|string',
            'penulis' => 'required|string|max:30',
            'tahun_rilis' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'penerbit' => 'required|string|max:20',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'stok' => 'required|integer|digits_between:1,2',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sumber_perpustakaan' => 'required|string|max:30',
            'status' => 'required|string|in:tersedia,tidak tersedia',
        ]);

        // handle gambar
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('bukuofflineimg'), $imageName);

            // hapus gambar lama
            if ($BukuOffline->img && file_exists(public_path('bukuofflineimg/' . $BukuOffline->img))) {
                unlink(public_path('bukuofflineimg/' . $BukuOffline->img));
            }
        } else {
            $imageName = $BukuOffline->img;
        }

        // update buku
        $BukuOffline->update([
            'judul' => $validated['judul'],
            'kategori' => $validated['kategori'],
            'penjelasan' => $validated['penjelasan'],
            'penulis' => $validated['penulis'],
            'tahun_rilis' => $validated['tahun_rilis'],
            'penerbit' => $validated['penerbit'],
            'tahun_terbit' => $validated['tahun_terbit'],
            'stok' => $validated['stok'],
            'img' => $imageName,
            'sumber_perpustakaan' => $validated['sumber_perpustakaan'],
            'status' => $validated['status'],
        ]);

        // update genre
        $BukuOffline->genres()->delete();
        foreach ($validated['genres'] as $g) {
            Genre::create([
                'id_buku' => $BukuOffline->id_buku,
                'genre'   => $g,
            ]);
        }


        return redirect()->route('BukuOffline.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_buku)
    {
        $BukuOffline = BukuOffline::where('id_buku', $id_buku)->firstOrFail();

        // hapus genre dulu
        $BukuOffline->genres()->delete();

        // hapus gambar jika ada
        if ($BukuOffline->img && file_exists(public_path('bukuofflineimg/' . $BukuOffline->img))) {
            unlink(public_path('bukuofflineimg/' . $BukuOffline->img));
        }

        // hapus buku
        $BukuOffline->delete();

        return redirect('BukuOffline')->with('success', 'Buku berhasil dihapus!');
    }
}
