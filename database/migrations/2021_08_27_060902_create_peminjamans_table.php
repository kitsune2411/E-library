<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeminjamansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->unique();
            $table->foreignId('buku_id');
            $table->timestamp('tanggal_dipinjam',0)->nullable();
            $table->timestamps();

            $table->foreign('siswa_id')->references('id')->on('users');
            $table->foreign('buku_id')->references('id_buku')->on('books');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peminjaman');
    }
}
