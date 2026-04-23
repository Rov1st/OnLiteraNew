<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailBuku extends Model
{
    protected $table = 'detail_buku'; // Nama tabel yang benar
    protected $primaryKey = 'barcode';
    protected $fillable = ['barcode', 'isbn', 'id_buku'];
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string'; // atau 'int' kalau kolom benar-benar bigint
    public function buku()
    {
        return $this->belongsTo(BukuOffline::class, 'id_buku', 'id_buku');
    }
}
