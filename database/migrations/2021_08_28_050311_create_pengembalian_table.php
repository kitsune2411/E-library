<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengembalianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id');
            $table->foreignId('siswa_id');
            $table->foreignId('buku_id');
            $table->integer('denda');
            $table->timestamp('tanggal_dikembalikan',0)->nullable();
            $table->timestamps();

            $table->foreign('siswa_id')->references('id')->on('users');
            $table->foreign('buku_id')->references('id_buku')->on('books');
            $table->foreign('peminjaman_id')->references('id')->on('peminjaman');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengembalian');
    }
}
