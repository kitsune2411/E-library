<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class peminjaman extends Model
{
    use HasFactory;
    protected $table = "peminjaman";//tell system that table we are using is 'peminjaman' cuz by deafult it's 'peminjamans'
    public $fillable = ['siswa_id', 'buku_id', 'created_at'];

    public function siswa()
    {
        return $this->hasOne(Users::class);
    }

    public function buku()
    {
        return $this->hasOne(book::class);
    }
}
