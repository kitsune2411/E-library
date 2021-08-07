<?php

use App\Http\Livewire\CrudPetugas;
use App\Http\Livewire\OutputCMS;
use App\Http\Livewire\CMSs;
use App\Http\Livewire\CrudSiswa;
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

    Route::get('/crud/petugas', CrudPetugas::class)
        ->name('crud-petugas');

    Route::get('/crud/siswa', CrudSiswa::class)
        ->name('crud-siswa');

    Route::get('/cms', CMSs::class)
        ->name('cms');

    Route::get('/buku', OutputCMS::class)
        ->name('buku');
});
