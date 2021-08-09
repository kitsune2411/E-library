<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListBuku extends Component
{
    public $searchterm;

    public function render()
    {
        $searchterm ='%'. $this->searchterm. '%';
        $data = [
            'buku' => DB::table('buku')
                        ->where('judul_buku', 'like', $searchterm)
                        ->orWhere('penulis', 'like', $searchterm)
                        ->orWhere('penerbit', 'like', $searchterm)
                        ->orWhere('tahun_terbit', 'like', $searchterm)
                        ->get()
        ];
        return view('livewire.list-buku', $data);
    }
}
