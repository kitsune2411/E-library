<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class book extends Model
{
    use HasFactory;
    protected $fillable = [
        'judul_buku', 'penulis', 'penerbit' , 'tahun_terbit','stok', 'foto_buku'
    ];

    public function Pinjam()
    {
        return $this->belongsTo(peminjaman::class);
    }
}
