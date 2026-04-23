<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    protected $table = 'detail_peminjaman';
    protected $fillable = ['id_peminjaman', 'id_buku', 'stok'];

    // ✅ Konfigurasi untuk tanpa primary key
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    // ✅ Method untuk mencari record tanpa primary key
    public static function findByComposite($id_peminjaman, $id_buku)
    {
        return static::where('id_peminjaman', $id_peminjaman)
                    ->where('id_buku', $id_buku)
                    ->first();
    }

    // ✅ Method untuk delete tanpa primary key
    public function deleteByComposite($id_peminjaman, $id_buku)
    {
        return static::where('id_peminjaman', $id_peminjaman)
                    ->where('id_buku', $id_buku)
                    ->delete();
    }

    // ✅ Method untuk update tanpa primary key
    public static function updateByComposite($id_peminjaman, $id_buku, $data)
    {
        return static::where('id_peminjaman', $id_peminjaman)
                    ->where('id_buku', $id_buku)
                    ->update($data);
    }

    public function buku()
    {
        return $this->belongsTo(BukuOffline::class, 'id_buku', 'id_buku');
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }
}
