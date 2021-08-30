<?php

namespace App\Http\Livewire;

use App\Models\book;
use App\Models\peminjaman;
use App\Models\pengembalian as ModelsPengembalian;
use App\Models\Users;
use DateTime;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;

use function PHPUnit\Framework\throwException;

class Pengembalian extends Component
{
    use WithPagination;
    public $searchterm='';
    public $deleteId = '';
    public $buku, $tanggal_pengembalian,$peminjam, $tanggal_pinjam;

    public function render()
    {
        if (auth()->user()->level == 1 || auth()->user()->level == 2 ) {

            $searchterm ='%'. $this->searchterm. '%';
            $data= [
                'siswa' => Users::where('level',3)->get(),
                'book' => book::where('stok','>',0)->get(),
                'pengembalian' => ModelsPengembalian::join('peminjaman','peminjaman_id','=','peminjaman.id')
                                    ->join('users','siswa_id','=','users.id')
                                    ->join('books','buku_id','=','books.id_buku')
                                    ->select('pengembalian.*','peminjaman.tanggal_dipinjam','users.name','books.judul_buku')
                                    ->orWhere('users.name', 'like', $searchterm)
                                    ->orWhere('books.judul_buku', 'like', $searchterm)
                                    ->orWhere('peminjaman.tanggal_dipinjam', 'like', $searchterm)
                                    ->orWhere('pengembalian.tanggal_dikembalikan', 'like', $searchterm)
                                    ->orWhere('pengembalian.denda', 'like', $searchterm)
                                    ->paginate(5)
            ];
            return view('livewire.pengembalian', $data);
        } else {
            abort(403);
        }
    }

    public function ResetInput()
    {
        $this->peminjam = '';
        $this->buku = '';
        $this->tanggal_pinjam = '';
        $this->tanggal_pengembalian = '';
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
            $telat = $hitungtelat->format('%r%a');

            if ($telat > 0) {
                $denda = $telat * 1000;            
            } elseif ($tgl_kembali->lt($tgl_pinjam)) {
               throw new \Exception(908);// 908 = tanggal pengembalian salah ( i made this up )
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
                'denda' => $denda,
                'tanggal_dikembalikan' =>$this->tanggal_pengembalian,
            ]);

            $this->alertAddSuccess();
        } catch (\Throwable $th) {
            if ($th->getMessage() == '908') {
                $this->alertPengembalianDateError();
            } elseif ($th->getCode() == 0) {
                //error code for something is Null or not found
                $this->alertNotFound();
                dd($th);
            } elseif (isset($th->errorInfo)) {
                $errorCode = $th->errorInfo[1];
                //error code for duplicate entry is 1062
                if($errorCode == 1062){
                    // houston, we have a duplicate entry problem 
                    $this->alertDupliclateError();
                } else {
                    $this->alertError();
                }
            } else {
                $this->alertError();
            }
        }
    }

    public function deleteId($id)
    {
        $delete = ModelsPengembalian::join('peminjaman','peminjaman_id','=','peminjaman.id')
                    ->where('pengembalian.id', $id)->firstOrFail();
        $this->deleteId = $id;
        $this->buku = $delete->buku_id;
    }

    public function delete()
    {
        try {
            book::where('id_buku', $this->buku)->decrement('stok',1);
            ModelsPengembalian::where('id', $this->deleteId)->delete();
            $this->alertDeleteSuccess();
        } catch (\Throwable $th) {
            $this->alertError();
        }
    }

    public function alertAddSuccess()
    {
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'success',  'message' => 'Buku berhasil dikembalikan!']);
    }

    public function alertDeleteSuccess()
    {
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'success',  'message' => 'Pengembalian Berhasil Dihapus!']);
    }

    public function alertNotFound()
    {
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'error',  'message' => 'Peminjaman tidak ditemukan!']);
    }

    public function alertDupliclateError()
    {
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'error',  'message' => 'Buku telah dikembalikan!']);
    }

    public function alertPengembalianDateError()
    {
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'error',  'message' => 'Upss, Tanggal pengembalian sebelum tanggal peminjaman!']);
    }

    public function alertError()
    {
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'error',  'message' => 'Something is Wrong!' ]);
    }
}
