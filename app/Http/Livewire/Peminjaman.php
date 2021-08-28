<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Users;
use App\Models\book;
use App\Models\peminjaman as ModelsPeminjaman;
use Illuminate\Support\Facades\DB;

class Peminjaman extends Component
{
    public $peminjam, $buku, $tanggal_pinjam;

    public function render()
    {
        $data= [
            'siswa' => Users::where('level',3)->get(),
            'book' => book::where('stok','>',0)->get(),
            'peminjaman' => ModelsPeminjaman::join('users','siswa_id','=','users.id')
                                ->join('books','buku_id','=','books.id_buku')
                                ->select('peminjaman.*','users.name','books.judul_buku')
                                ->get(),
        ];
        return view('livewire.peminjaman', $data);
    }

    public function pinjam()
    {
        try {
            $this->validate([
                'peminjam' => 'required',
                'buku' => 'required',
                'tanggal_pinjam' => 'required',
            ]);

            book::where('id_buku', $this->buku)->decrement('stok',1);

            ModelsPeminjaman::create([
                'siswa_id' => $this->peminjam,
                'buku_id' => $this->buku,
                'tanggal_dipinjam' => $this->tanggal_pinjam,
            ]);
            

        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
