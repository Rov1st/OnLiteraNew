<?php

namespace App\Http\Controllers;

use App\Models\KeranjangPengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\BukuFavorite;
use App\Models\BukuOffline;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Contact;

class UserExperienceController extends Controller
{
    public function pushKeranjang(Request $request)
    {
        // Log the incoming request for debugging
        Log::info('Keranjang request:', $request->all());

        $validator = Validator::make($request->all(), [
            'id_user' => 'required|integer|exists:users,id',
            'id_buku' => 'required|integer|exists:buku_offline,id_buku',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed:', $validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Check if item already exists in cart
            $existing = KeranjangPengguna::where('id_user', $request->id_user)
                ->where('id_buku', $request->id_buku)
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku sudah ada di keranjang'
                ], 409);
            }

            $keranjang = KeranjangPengguna::create([
                'id_user' => $request->id_user,
                'id_buku' => $request->id_buku,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditambahkan ke keranjang',
                'data' => $keranjang
            ]);
        } catch (\Exception $e) {
            Log::error('Error adding to cart: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Internal server error: ' . $e->getMessage()
            ], 500);
        }
    }
    public function hapusKeranjang($id_user, $id_buku)
    {
        $keranjang = KeranjangPengguna::where('id_user', $id_user)
            ->where('id_buku', $id_buku)
            ->delete();

        if (!$keranjang) {
            return response()->json([
                'success' => false,
                'message' => 'Mungkin keranjang kosong!'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dihapus dari keranjang',
            'deleted_count' => $keranjang
        ]);
    }
    public function pinjamDariKeranjang(Request $request)
    {
        $request->validate([
            'id_user' => 'required|integer|exists:users,id',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'password' => 'required|string',
            'books' => 'required|array|min:1',
            'books.*.id_buku' => 'required|integer',
            'books.*.stock' => 'required|integer|min:1',
        ]);

        $user = User::find($request->id_user);
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password salah!'
            ], 401);
        }

        if (empty($user->NISN) || strlen($user->NISN) < 10) {
            return response()->json([
                'success' => false,
                'message' => 'Tolong masukkan NISN yang valid di tab profil!'
            ], 422);
        }

        $cekPinjam = Peminjaman::where('id_user', $request->id_user)
            ->where('status', 'Terlambat')
            ->first();

        if ($cekPinjam) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu masih punya denda yang belum dibayar'
            ], 422);
        }

        $result = DB::transaction(function () use ($request) {
            // map request books => [id_buku => jumlah]
            $booksInput = collect($request->input('books'))->mapWithKeys(function ($b) {
                return [(int)$b['id_buku'] => (int)$b['stock']];
            })->toArray();

            // Ambil keranjang user (cek apakah buku yg diminta memang ada di keranjang)
            $keranjangItems = KeranjangPengguna::where('id_user', $request->id_user)->pluck('id_buku')->toArray();
            $notInCart = array_diff(array_keys($booksInput), $keranjangItems);
            if (!empty($notInCart)) {
                throw new \Exception('Beberapa buku tidak ditemukan di keranjang.');
            }

            // Cek/ambil peminjaman aktif dengan tanggal yang sama & status 'Belum'
            $peminjaman = Peminjaman::where('id_user', $request->id_user)
                ->where('status', 'Menunggu Konfirmasi')
                ->whereDate('tanggal_pinjam', $request->tanggal_pinjam)
                ->first();

            if (!$peminjaman) {
                $peminjaman = Peminjaman::create([
                    'id_user' => $request->id_user,
                    'tanggal_pinjam' => $request->tanggal_pinjam,
                    'tanggal_harus_kembali' => Carbon::parse($request->tanggal_pinjam)->addDays(5),
                    'status' => 'Menunggu Konfirmasi',
                ]);
            }

            $detailList = [];

            foreach ($booksInput as $id_buku => $jumlahPinjam) {
                $book = BukuOffline::find($id_buku);
                if (!$book) {
                    throw new \Exception("Buku dengan id {$id_buku} tidak ditemukan.");
                }

                if ($book->stok < $jumlahPinjam) {
                    throw new \Exception("Stok buku \"{$book->judul}\" tidak cukup!");
                }

                // Cek apakah sudah ada detail untuk id_peminjaman + id_buku (gunakan query builder)
                $existing = DB::table('detail_peminjaman')
                    ->where('id_peminjaman', $peminjaman->id_peminjaman)
                    ->where('id_buku', $id_buku)
                    ->first();

                if ($existing) {
                    // increment stok di row yang spesifik (menghindari update tanpa where)
                    DB::table('detail_peminjaman')
                        ->where('id_peminjaman', $peminjaman->id_peminjaman)
                        ->where('id_buku', $id_buku)
                        ->update(['stok' => DB::raw("stok + " . (int)$jumlahPinjam)]);

                    $updated = DB::table('detail_peminjaman')
                        ->where('id_peminjaman', $peminjaman->id_peminjaman)
                        ->where('id_buku', $id_buku)
                        ->first();
                    $detailList[] = $updated;
                } else {
                    // insert new detail (query builder)
                    DB::table('detail_peminjaman')->insert([
                        'id_peminjaman' => $peminjaman->id_peminjaman,
                        'id_buku' => $id_buku,
                        'stok' => $jumlahPinjam
                    ]);

                    $created = DB::table('detail_peminjaman')
                        ->where('id_peminjaman', $peminjaman->id_peminjaman)
                        ->where('id_buku', $id_buku)
                        ->first();
                    $detailList[] = $created;
                }

                // Kurangi stok buku master
                $book->stok = $book->stok - $jumlahPinjam;
                $book->save();
            }

            // Hapus hanya entri keranjang yang sudah diproses
            KeranjangPengguna::where('id_user', $request->id_user)
                ->whereIn('id_buku', array_keys($booksInput))
                ->delete();

            return [
                'peminjaman' => $peminjaman,
                'details' => $detailList
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }


    public function toggleFavorit(Request $request)
    {
        $request->validate([
            'id_user' => 'required|integer',
            'id_buku' => 'required|integer',
        ]);

        $favorit = BukuFavorite::where('id_user', $request->id_user)
            ->where('id_buku', $request->id_buku)
            ->first();

        if ($favorit) {
            // Gunakan query langsung, bukan $favorit->delete()
            BukuFavorite::where('id_user', $request->id_user)
                ->where('id_buku', $request->id_buku)
                ->delete();

            return response()->json(['success' => true, 'status' => 'unfavorited']);
        } else {
            BukuFavorite::create([
                'id_user' => $request->id_user,
                'id_buku' => $request->id_buku
            ]);
            return response()->json(['success' => true, 'status' => 'favorited']);
        }
    }
    public function checkFavorit($id_user, $id_buku)
    {
        $isFavorite = BukuFavorite::where('id_user', $id_user)
            ->where('id_buku', $id_buku)
            ->exists();

        return response()->json(['favorited' => $isFavorite]);
    }

    // Ambil semua favorit user
    public function favorit($id_user)
    {
        $favorits = BukuFavorite::with('buku')->where('id_user', $id_user)->get();
        return response()->json($favorits);
    }
    public function cekAktif($id_user, $tanggal)
    {
        // Cari peminjaman user dengan status 'belum' dan tanggal_pinjam sama
        $aktif = Peminjaman::where('id_user', $id_user)
            ->where('status', 'Menunggu Konfirmasi')
            ->where('tanggal_pinjam', $tanggal)
            ->first(); // ambil satu record saja

        if ($aktif) {
            return response()->json($aktif);
        } else {
            return response()->json(null); // atau bisa pakai []
        }
    }

    public function pinjamFull(Request $request)
    {
        $request->validate([
            'id_user' => 'required|integer',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'id_buku' => 'required|integer',
            'stok' => 'required|integer',
            'password' => 'required|string'
        ]);

        $user = User::find($request->id_user);
        $cekPinjam = Peminjaman::where('id_user', $request->id_user)
            ->where('status', 'Terlambat')
            ->first();

        if ($cekPinjam) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu masih punya denda yang belum dibayar'
            ], 422);
        }

        // cek password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password salah!'
            ], 401);
        }

        // cek apakah user punya NISN valid
        if (!$user->NISN || strlen($user->NISN) < 10) {
            return response()->json([
                'success' => false,
                'message' => 'Tolong masukkan NISN yang valid di tab profil!'
            ], 422);
        }

        $result = DB::transaction(function () use ($request) {

            // 1. Cek peminjaman aktif
            $peminjaman = Peminjaman::where('id_user', $request->id_user)
                ->where('status', 'Menunggu Konfirmasi')
                ->whereDate('tanggal_pinjam', $request->tanggal_pinjam)
                ->first();



            // 2. Jika tidak ada, buat peminjaman baru
            if (!$peminjaman) {
                $peminjaman = Peminjaman::create([
                    'id_user' => $request->id_user,
                    'tanggal_pinjam' => $request->tanggal_pinjam,
                    'tanggal_harus_kembali' => Carbon::parse($request->tanggal_pinjam)->addDays(5),
                    'status' => 'Menunggu Konfirmasi',
                ]);
            }

            // 3. Cek stok buku
            $book = BukuOffline::find($request->id_buku);
            if (!$book) {
                throw new \Exception('Buku tidak ditemukan!');
            }
            if ($book->stok < $request->stok) {
                throw new \Exception('Stok buku tidak cukup!');
            }

            // 4. Cek apakah buku sudah ada di detail peminjaman
            $detail = DB::table('detail_peminjaman')
                ->where('id_peminjaman', $peminjaman->id_peminjaman)
                ->where('id_buku', $request->id_buku)
                ->first();

            if ($detail) {
                DB::table('detail_peminjaman')
                    ->where('id_peminjaman', $peminjaman->id_peminjaman)
                    ->where('id_buku', $request->id_buku)
                    ->limit(1)
                    ->update([
                        'stok' => DB::raw('stok + ' . $request->stok)
                    ]);
            } else {
                DB::table('detail_peminjaman')->insert([
                    'id_peminjaman' => $peminjaman->id_peminjaman,
                    'id_buku' => $request->id_buku,
                    'stok' => $request->stok
                ]);
            }

            // 5. Kurangi stok buku offline
            DB::table('buku_offline')
                ->where('id_buku', $request->id_buku)
                ->limit(1)
                ->update([
                    'stok' => DB::raw('stok - ' . $request->stok)
                ]);

            // Ambil kembali detail terbaru
            $detailUpdated = DB::table('detail_peminjaman')
                ->where('id_peminjaman', $peminjaman->id_peminjaman)
                ->where('id_buku', $request->id_buku)
                ->first();

            return [
                'peminjaman' => $peminjaman,
                'detail' => $detailUpdated
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }

    public function tampilTransaksi($id_user)
    {
        try {
            // Ambil semua peminjaman user dengan relasi yang diperlukan
            $peminjaman = Peminjaman::with([
                'DetailPeminjaman.buku',
                'pengembalian' // Tambahkan relasi pengembalian
            ])
                ->where('id_user', $id_user)
                ->orderBy('tanggal_pinjam', 'desc')
                ->get();

            // Format data sesuai kebutuhan frontend
            $result = $peminjaman->map(function ($pinjam) {
                // Tentukan status dan tanggal kembali
                $status = $pinjam->status;
                $tanggal_kembali_aktual = null;

                // Jika ada pengembalian, update status dan tanggal kembali
                if ($pinjam->pengembalian) {
                    $status = 'Dikembalikan';
                    $tanggal_kembali_aktual = $pinjam->pengembalian->tanggal_kembali;
                }

                return [
                    'id' => $pinjam->id_peminjaman,
                    'tanggal_pinjam' => $pinjam->tanggal_pinjam,
                    'tanggal_harus_kembali' => $pinjam->tanggal_harus_kembali, // Tanggal yang seharusnya dikembalikan
                    'tanggal_kembali_aktual' => $tanggal_kembali_aktual, // Tanggal aktual pengembalian
                    'status' => $status,
                    'denda' => $pinjam->pengembalian->denda ?? 0, // Tambahkan informasi denda jika ada
                    'books' => $pinjam->DetailPeminjaman->map(function ($detail) {
                        return [
                            'id' => $detail->buku->id_buku,
                            'judul' => $detail->buku->judul,
                            'penulis' => $detail->buku->penulis,
                            'isbn' => $detail->buku->isbn ?? '-', // Pastikan field isbn ada di tabel
                            'qty' => $detail->stok
                        ];
                    })->toArray()
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function contactUs(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name'    => 'required|string|max:40',
            'email'   => 'required|email|max:100',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        // Simpan ke database
        Contact::create([
            'nama'   => $validated['name'],
            'email'  => $validated['email'],
            'subjek' => $validated['subject'],
            'pesan'  => $validated['message'],
        ]);

        // Redirect atau response JSON
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Pesan berhasil dikirim!']);
        }

        return redirect()->back()->with('success', 'Pesan berhasil dikirim!');
    }

    public function batalkanPeminjaman($id_peminjaman)
    {
        try {
            // Cari peminjaman berdasarkan ID
            $peminjaman = Peminjaman::find($id_peminjaman);

            // Validasi: peminjaman tidak ditemukan
            if (!$peminjaman) {
                return response()->json([
                    'success' => false,
                    'message' => 'Peminjaman tidak ditemukan'
                ], 404);
            }

            // Validasi: hanya bisa dibatalkan jika statusnya "Menunggu Konfirmasi"
            if ($peminjaman->status !== 'Menunggu Konfirmasi') {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya peminjaman dengan status "Menunggu Konfirmasi" yang bisa dibatalkan'
                ], 400);
            }

            // Update status menjadi "Dibatalkan"
            $peminjaman->status = 'Dibatalkan';
            $peminjaman->save();

            // Kembalikan stok buku yang dipinjam
            $detailPeminjaman = DetailPeminjaman::where('id_peminjaman', $id_peminjaman)->get();

            foreach ($detailPeminjaman as $detail) {
                $buku = BukuOffline::find($detail->id_buku);
                if ($buku) {
                    // Kembalikan stok buku
                    $buku->stok += $detail->stok;
                    $buku->save();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Peminjaman berhasil dibatalkan dan stok buku telah dikembalikan',
                'data' => [
                    'id_peminjaman' => $peminjaman->id_peminjaman,
                    'status' => $peminjaman->status,
                    'tanggal_pinjam' => $peminjaman->tanggal_pinjam,
                    'tanggal_harus_kembali' => $peminjaman->tanggal_harus_kembali
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
