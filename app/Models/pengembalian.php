<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengembalian extends Model
{
    use HasFactory;
    protected $table = "pengembalian";//tell system that table we are using is 'pengembalian' cuz by deafult it's 'pengembalians'
    protected $dates = [
        'created_at',
        'updated_at',
        'tanggal_dipinjam'
    ];
    public $fillable = ['peminjaman_id','siswa_id', 'buku_id', 'denda','tanggal_dikembalikan'];
}
