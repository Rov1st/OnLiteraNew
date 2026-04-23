<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\BukuOffline;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buku = BukuOffline::with('genres')->get();
        return view('Genre.index', compact('buku'));
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
            'id_buku' => 'required|integer|exists:buku_offline,id_buku',
            'genre' => 'required|array',
            'genre.*' => 'nullable|string|max:30',

        ]);

        $buku = BukuOffline::findOrFail($request->id_buku);

        $genres = collect($request->genre)
            ->filter()
            ->map(fn($g) => ['id_buku' => $buku->id_buku, 'genre' => $g])
            ->toArray();

        Genre::insert($genres);
        return redirect('Genre')->with('success', 'genre Buku Berhasil Ditambah..');
    }


    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_buku)
    {
        $request->validate([
            'id_buku' => 'required|integer|exists:buku_offline,id_buku',
            'genre' => 'required|array',
            'genre.*' => 'nullable|string|max:30',
        ]);

        // Hapus semua genre lama
        Genre::where('id_buku', $id_buku)->delete();

        // Insert ulang
        foreach ($request->genre as $g) {
            if (!empty($g)) {
                Genre::create([
                    'id_buku' => $request->id_buku,
                    'genre'   => $g,
                ]);
            }
        }

        return redirect('Genre')->with('success', 'Genre berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_buku)
    {
        $deleted = Genre::where('id_buku', $id_buku)->delete();

        if (!$deleted) {
            return redirect('Genre')->with('error', 'Genre gagal dihapus.');
        }

        return redirect('Genre')->with('success', 'Genre berhasil dihapus.');
    }
}
