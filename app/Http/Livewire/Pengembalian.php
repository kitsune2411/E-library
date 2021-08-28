<?php

namespace App\Http\Livewire;

use App\Models\book;
use App\Models\peminjaman;
use App\Models\pengembalian as ModelsPengembalian;
use App\Models\Users;
use DateTime;
use Livewire\Component;
use Carbon\Carbon;

class Pengembalian extends Component
{
    public $buku, $tanggal_pengembalian,$peminjam, $tanggal_pinjam;

    public function render()
    {
        $data= [
            'siswa' => Users::where('level',3)->get(),
            'book' => book::where('stok','>',0)->get(),
            'peminjaman' => peminjaman::join('users','siswa_id','=','users.id')
                                ->join('books','buku_id','=','books.id_buku')
                                ->select('peminjaman.*','users.name','books.*')
                                ->get(),
        ];
        return view('livewire.pengembalian', $data);
    }

    public function kembalikan()
    {
        try {
            $data_peminjaman = peminjaman::
                where('siswa_id', $this->peminjam)
                ->where('buku_id', $this->buku)
                ->where('tanggal_dipinjam', $this->tanggal_pinjam)
                ->first();

            $id_peminjaman = $data_peminjaman->id;

            $tgl_pinjam = new Carbon($this->tanggal_pinjam);
            $tgl_kembali = new Carbon($this->tanggal_pengembalian) ;

            $due_pengembalian = $tgl_pinjam->addDays(5);

            $hitungtelat = $due_pengembalian->diff($this->tanggal_pengembalian);
            $telat = $hitungtelat->format('%a');

            if ($telat > 0) {
                $denda = $telat * 1000;            
            } else {
                $denda = 0;
            }

            $this->validate([
                'peminjam' => 'required',
                'buku' => 'required',
                'tanggal_pinjam' => 'required',
                'tanggal_pengembalian' => 'required',
            ]);

            book::where('id_buku', $this->buku)->increment('stok',1);

            ModelsPengembalian::create([
                'peminjaman_id'=> $id_peminjaman,
                'siswa_id' => $this->peminjam,
                'buku_id' => $this->buku,
                'denda' => $denda,
                'tanggal_dikembalikan' =>$this->tanggal_pengembalian,
            ]);

        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }
}
