<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    protected $table = 'detail_peminjaman';
    protected $fillable = ['id_peminjaman', 'id_buku'];
    public function BukuOffline(){
        return $this->belongsTo(BukuOffline::class, 'id_buku');
    }
    public function Peminjaman(){
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }
}
