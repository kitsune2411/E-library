<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Users;
use App\Models\book;
use App\Models\peminjaman as ModelsPeminjaman;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class Peminjaman extends Component
{
    use WithPagination;
    public $searchterm='';
    public $deleteId = '';
    public $peminjam, $buku, $tanggal_pinjam;

    public function render()
    {
        if (auth()->user()->level == 1 || auth()->user()->level == 2 ) {
            
            $searchterm ='%'. $this->searchterm. '%';
            $data= [
                'siswa' => Users::where('level',3)->get(),
                'book' => book::where('stok','>',0)->get(),
                'peminjaman' => ModelsPeminjaman::join('users','siswa_id','=','users.id')
                                    ->join('books','buku_id','=','books.id_buku')
                                    ->select('peminjaman.*','users.name','books.judul_buku')
                                    ->orWhere('users.name', 'like', $searchterm)
                                    ->orWhere('books.judul_buku', 'like', $searchterm)
                                    ->orWhere('peminjaman.tanggal_dipinjam', 'like', $searchterm)
                                    ->paginate(5),
            ];
            return view('livewire.peminjaman', $data);
        } else {
            abort(403);
        }
    }

    public function ResetInput()
    {
        $this->peminjam = '';
        $this->buku = '';
        $this->tanggal_pinjam = '';
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
            
            $this->alertAddSuccess();
        } catch (\Throwable $th) {
            $this->alertError();
        }
    }

    public function deleteId($id)
    {
        $delete = ModelsPeminjaman::where('id', $id)->firstOrFail();
        $this->deleteId = $delete->id;
        $this->buku = $delete->buku_id;
    }

    public function delete()
    {
        try {
            book::where('id_buku', $this->buku)->increment('stok',1);
            ModelsPeminjaman::where('id', $this->deleteId)->delete();
            $this->alertDeleteSuccess();
        } catch (\Throwable $th) {
            $errorCode = $th->errorInfo[1];
            //error code 1451 mean Cannot delete or update a parent row: a foreign key constraint. This error generally comes when we want to delete child table row.
            if($errorCode == 1451){
                $this->alertForeignError();
            } else {
                $this->alertError();
            }
        }
    }

    public function alertAddSuccess()
    {
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'success',  'message' => 'Buku berhasil dipinjam!']);
    }

    public function alertDeleteSuccess()
    {
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'success',  'message' => 'Peminjaman Berhasil Dihapus!']);
    }

    public function alertForeignError()
    {
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'error',  'message' => 'Buku telah dikembalikan!']);
    }

    public function alertError()
    {
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'error',  'message' => 'Something is Wrong!' ]);
    }
}
