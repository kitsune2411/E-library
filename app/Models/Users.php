<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'email', 'level', 'password'
    ];


    public function AllData()
    {
        return DB::table('users')->get();
    }

    public function DeleteData($id)
    {
        DB::table('users')
            ->where('id', $id)
            ->delete();
    }
}
