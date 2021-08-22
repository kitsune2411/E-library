<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use App\Models\book;
use Livewire\Component;
use Livewire\WithPagination;

class ListBuku extends Component
{
    use WithPagination;

    public $searchterm;

    public function updatingSearchterm()
    {
        $this->resetPage();
    }

    public function render()
    {
        $searchterm ='%'. $this->searchterm. '%';
        $data = [
            'buku' => book::where('judul_buku', 'like', $searchterm)
                        ->orWhere('penulis', 'like', $searchterm)
                        ->orWhere('penerbit', 'like', $searchterm)
                        ->orWhere('tahun_terbit', 'like', $searchterm)
                        ->paginate(5)
        ];
        return view('livewire.list-buku', $data);
    }
}
