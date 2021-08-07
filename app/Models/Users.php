<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama','username', 'email', 'level', 'password'
    ];


    public function AllDataPetugas()
    {
        return DB::table('users')
            ->where('level', 2)
            ->get();
    }

    public function AllDataSiswa()
    {
        return DB::table('users')
            ->where('level', 3)
            ->get();
    }

    public function DeleteData($id)
    {
        DB::table('users')
            ->where('id', $id)
            ->delete();
    }
}
