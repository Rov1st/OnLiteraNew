<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BukuOnline extends Model
{
    protected $table = 'buku_online'; // Nama tabel yang benar
    protected $primaryKey = 'id_buku';
    protected $fillable = ['judul', 'kategori', 'genre', 'penjelasan', 'img', 'buku_url', 'penulis', 'sumber',];
}
