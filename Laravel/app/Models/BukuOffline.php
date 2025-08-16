<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BukuOffline extends Model
{
    protected $table = 'buku_offline';
    protected $primaryKey = 'id_buku';
    protected $fillable = ['judul','kategori','genre','penjelasan','penulis','penerbit','sumber_perpustakaan','status'];
}
