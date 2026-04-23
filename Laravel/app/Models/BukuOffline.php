<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BukuOffline extends Model
{
    protected $table = 'buku_offline';
    protected $primaryKey = 'id_buku';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['judul', 'kategori', 'penjelasan', 'penulis', 'tahun_rilis', 'penerbit', 'tahun_terbit', 'stok', 'img', 'sumber_perpustakaan', 'status', 'counter'];
    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_buku', 'id_buku');
    }

    public function genres()
    {
        return $this->hasMany(Genre::class, 'id_buku', 'id_buku');
    }
}
