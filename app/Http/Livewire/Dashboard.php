<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        if (auth()->user()->level == 1) {
    
            return view('dashboard.dashboard-admin');

        } elseif (auth()->user()->level == 2) {

            return view('dashboard.dashboard-petugas');

        }  elseif (auth()->user()->level == 3) {

            return view('dashboard.dashboard-siswa');

        } else {
            abort(403);
        }
    }
}
