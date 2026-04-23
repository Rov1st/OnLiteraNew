<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $table = 'genre';
    protected $primaryKey = null;   // tidak ada PK
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['id_buku', 'genre'];

    public function buku()
    {
         return $this->belongsTo(BukuOffline::class, 'id_buku', 'id_buku');
    }
}
