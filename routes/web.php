<?php

use App\Http\Livewire\Petugas;
use App\Http\Livewire\PinjamBuku;
use App\Http\Livewire\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/user', User::class)
        ->name('user');

    Route::get('/cms', Petugas::class)
        ->name('cms');

    Route::get('/buku', PinjamBuku::class)
        ->name('buku');

    Route::post('/add', [User::class, 'insert'] )
        ->name('add');
});
