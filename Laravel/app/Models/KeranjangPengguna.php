<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\BukuOffline;

class KeranjangPengguna extends Model
{
    protected $table = 'keranjang_pengguna';
    protected $fillable = ['id_user', 'id_buku'];
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function buku()
    {
        return $this->belongsTo(BukuOffline::class, 'id_buku', 'id_buku');
    }
}
