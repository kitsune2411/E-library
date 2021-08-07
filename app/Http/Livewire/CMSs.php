<?php

namespace App\Http\Livewire;

use App\Models\cms;
use Livewire\Component;

class CMSs extends Component
{
    public $header, $title, $content;

    public function mount()
    {
        $array = cms::where('id', 1)->first();

            $this->header = $array->header;
            $this->title = $array->title;
            $this->content = $array->content;
    }

    public function render()
    {
        if (auth()->user()->level == 1 || auth()->user()->level == 2) {

            return view('livewire.view-cms');  
            
        } else {
            abort(403);
        }
    }

    public function ResetInput()
    {
        $this->mount();
    }

    public function update()
    {
        $this->validate([
            'header' => 'required',
            'title' => 'required',
            'content' => 'required',
        ]);

        cms::where('id', 1)->update([
            'header' => $this->header,
            'title' => $this->title,
            'content' => $this->content,
        ]);

        $this->ResetInput();

        session()->flash('message', 'Data Updated Successfully.');

    }
    






}
