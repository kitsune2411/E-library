<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','username', 'email', 'level', 'password'
    ];

    public function pinjam()
    {
        return $this->belongsTo(peminjaman::class);
    }

}
