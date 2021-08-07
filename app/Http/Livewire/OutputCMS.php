<?php

namespace App\Http\Livewire;

use App\Models\cms;
use Livewire\Component;

class OutputCMS extends Component
{

    public function render()
    {
        $cms = [
            'cms' => cms::where('id', 1)->get()
        ];
        
        return view('livewire.output-cms', $cms);
    }
}
