<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BukuFavorite extends Model
{
    protected $table = 'buku_favorite';
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
