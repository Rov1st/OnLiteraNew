<?php

namespace App\Http\Controllers;

use App\Models\DetailBuku;
use App\Models\BukuOffline;
use Illuminate\Http\Request;

class DetailBukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $detail = DetailBuku::with(['buku'])->get();
        $buku = BukuOffline::all();

        return view('DetailBuku.index', compact('detail', 'buku'));
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
            'barcode' => 'required|numeric|digits_between:1,15|unique:detail_buku,barcode',
            'id_buku' => 'required|integer|exists:buku_offline,id_buku',
        ]);

        DetailBuku::create([
            'barcode' => $request->barcode,
            'id_buku' => $request->id_buku,
        ]);
        return redirect('DetailBuku')->with('success', 'Detail Buku Berhasil Ditambah..');
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailBuku $detailBuku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailBuku $detailBuku)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $barcode)
    {
        $detail = DetailBuku::where('barcode', $barcode)->first();

        if (!$detail) {
            return redirect('DetailBuku')->with('success', 'Detail Gagal Diubah..');
        }


        $request->validate([
            'id_buku' => 'required|integer|digits_between:1,11|exists:buku_offline,id_buku',

        ]);

        $detail->update([
            'id_buku' => $request->id_buku,
        ]);

        return redirect('DetailBuku')->with('success', 'Detail Buku Berhasil Ditambah..');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($barcode)
    {
        DetailBuku::where('barcode',$barcode)->delete();
        return redirect('DetailBuku')->with('success', 'Detail Buku berhasil dihapus..');
    }
}
