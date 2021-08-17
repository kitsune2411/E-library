<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\buku;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CrudBuku extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $searchterm;
    public $deleteId = '';
    public $deletefoto = null;
    public $editId = '';
    public $judul_buku, $penerbit, $penulis, $tahun_terbit, $foto_buku;

    public function render()
    {
        if (auth()->user()->level == 1 || auth()->user()->level == 2 ) {

            $searchterm ='%'. $this->searchterm. '%';
            $data = [
                'buku' => DB::table('buku')
                        ->where('judul_buku', 'like', $searchterm)
                        ->orWhere('penulis', 'like', $searchterm)
                        ->orWhere('penerbit', 'like', $searchterm)
                        ->orWhere('tahun_terbit', 'like', $searchterm)
                        ->paginate(5)
            ];

            return view('livewire.crud-buku', $data);
        } else {
            abort(403);
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function ResetInput()
    {
        $this->judul_buku = '';
        $this->penerbit = '';
        $this->penulis = '';
        $this->tahun_terbit = '';
        $this->foto_buku = null;
    }

    public function insert()
    {
        
        try {
            $this->validate([
                'judul_buku' => 'required',
                'penulis' => 'required',
                'penerbit' => 'required',
                'tahun_terbit' => 'required',
                'foto_buku' => 'image|mimes:jpg,jpeg,png,svg,gif,jfif|max:12288',//12MB
            ]);

            $file = $this->foto_buku->store('buku image', 'public');
            
            DB::table('buku')->insert([
                'judul_buku' => $this->judul_buku,
                'penerbit' => $this->penerbit,
                'penulis' => $this->penulis,
                'tahun_terbit' => $this->tahun_terbit,
                'foto_buku' => $file,
            ]);
            
            $this->alertAddSuccess();
        } catch (\Throwable $th) {
            $this->alertError();
        }

        $this->ResetInput();
    }

    public function editId ($id_buku)
    {
        $edit = DB::table('buku')->where('id_buku', $id_buku)->first();
        $this->editId = $id_buku;
        $this->judul_buku = $edit->judul_buku;
        $this->penerbit = $edit->penerbit;
        $this->penulis = $edit->penulis;
        $this->tahun_terbit = $edit->tahun_terbit;
        $this->foto_buku = $edit->foto_buku;
    }

    public function edit()
    {
        try {
            $this->validate([
                'judul_buku' => 'required',
                'penerbit' => 'required',
                'penulis' => 'required',
                'tahun_terbit' => 'required',
                // 'foto_buku' => 'image|mimes:jpg,jpeg,png,svg,gif|max:204800',// max: 200 MB
            ]);
      
            // $file = $this->foto_buku->store('buku image', 'public');

            DB::table('buku')
                ->where('id_buku', $this->editId)
                ->update([
                    'judul_buku' => $this->judul_buku,
                    'penerbit' => $this->penerbit,
                    'penulis' => $this->penulis,
                    'tahun_terbit' => $this->tahun_terbit,
                    // 'foto_buku' => $file,
                ]);

            $this->alertUpdateSuccess();
        } catch (\Throwable $th) {
            $this->alertError();
        }

        $this->ResetInput();
    }

    public function deleteId($id_buku)
    {
        $delete = DB::table('buku')->where('id_buku', $id_buku)->first();
        $this->deleteId = $id_buku;
        $this->deletefoto = $delete->foto_buku;
        
    }

    public function delete()
    {
        try {
            unlink(public_path('storage/'.$this->deletefoto));
            DB::table('buku')
                ->where('id_buku', $this->deleteId)
                ->delete();

                $this->alertDeleteSuccess();
        } catch (\Throwable $th) {
            $this->alertError();
        }
    }

    public function alertAddSuccess()
    {
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'success',  'message' => 'Buku Created Successfully!']);
    }

    public function alertUpdateSuccess()
    {
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'success',  'message' => 'Buku Updated Successfully!']);
    }

    public function alertDeleteSuccess()
    {
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'success',  'message' => 'Buku Deleted Successfully!']);
    }

    public function alertError()
    {
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'error',  'message' => 'Something is Wrong!' ]);
    }

    public function ListBuku()
    {
        return redirect()->to('/buku');
    }

}
