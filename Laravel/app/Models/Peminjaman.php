<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    protected $fillable = ['tanggal_pinjam', 'tanggal_harus_kembali', 'status', 'id_user'];

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
