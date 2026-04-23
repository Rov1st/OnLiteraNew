<?php

namespace App\Http\Controllers;

use App\Models\BukuOffline;
use App\Models\Genre;
use App\Models\KeranjangPengguna;
use Illuminate\Http\Request;

class PublicBookController extends Controller
{
    public function show($id)
    {
        $book = BukuOffline::with('genres')->find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Buku Tidak Ditemukan'
            ], 404);
        }

        return response()->json($book);
    }

    public function index()
    {
        $books = BukuOffline::with('genres')->get();

        return response()->json($books);
    }
    public function keranjang($id_user)
    {
        $books = KeranjangPengguna::where('id_user', $id_user)
            ->with('buku')
            ->get();

        if ($books->isEmpty()) {
            return response()->json([
                'message' => 'Keranjang kamu masih kosong nih'
            ], 404);
        }

        return response()->json($books);
    }
    public function counter($id_buku)
    {
        $book = BukuOffline::find($id_buku);

        $book->counter = $book->counter +=1;
        $book->save();
    }
}
