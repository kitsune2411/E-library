<?php

use App\Http\Livewire\CrudPetugas;
use App\Http\Livewire\OutputCMS;
use App\Http\Livewire\CMSs;
use App\Http\Livewire\CrudBuku;
use App\Http\Livewire\CrudSiswa;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\ListBuku;
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

    Route::get('/', Dashboard::class)
        ->name('dashboard');

    Route::get('/crud/petugas', CrudPetugas::class)
        ->name('crud-petugas');

    Route::get('/crud/siswa', CrudSiswa::class)
        ->name('crud-siswa');

    Route::get('/crud/buku', CrudBuku::class)
        ->name('crud-buku');

    Route::get('/buku', ListBuku::class)
        ->name('buku');

    Route::get('/cms', CMSs::class)
        ->name('cms');

    Route::get('/cms/output', OutputCMS::class)
        ->name('outputCMS');
});
