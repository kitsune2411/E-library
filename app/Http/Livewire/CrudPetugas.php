<?php

namespace App\Http\Livewire;

use App\Models\Users as Petugas;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Query\Builder;
use Livewire\WithPagination;

class CrudPetugas extends Component
{
    use WithPagination;

    public $searchterm;
    public $deleteId = '';
    public $editId = '';
    public $name, $username, $email, $level, $password;

    public function render()
    {
        if (auth()->user()->level == 1) {

            $searchterm ='%'. $this->searchterm. '%'; 
            $data = [
                'user' => Petugas::
                            where(function($query) use ($searchterm) {
                                $query->where('level', 2)
                                      ->where('name', 'like', $searchterm);
                            })
                            ->orWhere(function($query) use ($searchterm) {
                                $query->where('level', 2)
                                      ->where('username', 'like', $searchterm);
                            })
                            ->orWhere(function($query) use ($searchterm) {
                                $query->where('level', 2)
                                      ->where('email', 'like', $searchterm);
                            })
                            ->paginate(5),
            ];
    
            return view('livewire.crud-petugas', $data);

        } else {
            abort(403);
        }

    }

    public function updatingSearchterm()
    {
        $this->resetPage();
    }

    public function ResetInput()
    {
        $this->name = '';
        $this->email = '';
        $this->username = '';
        $this->password = '';
    }



    public function insert()
    {
        try {
            $this->validate([
                'name' => 'required',
                'username' => 'required|unique:users,username',
                'email' => 'required|unique:users,email',
                // 'level' => 'required',
                'password' => 'required|min:8',
            ]);

            Petugas::create([
                'name' => $this->name,
                'username' => $this->username,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'level' => 2,
            ]);

            $this->alertAddSuccess();

        } catch (\Throwable $th) {
            $this->alertError();
        }
        
        $this->ResetInput();
    }

    public function editId($id)
    {
        $edit = Petugas::findOrFail($id);
        $this->editId = $id;
        $this->name = $edit->name;
        $this->username = $edit->username;
        $this->email = $edit->email;
        // $this->level = $edit->level;
        // $this->password = $edit->password;
    }

    public function edit()
    {
        try {
            $this->validate([
                'name' => 'required',
                'username' => 'required|unique:users,username,' .$this->editId,
                'email' => 'required|unique:users,username,' .$this->editId,
                // 'level' => 'required',
                // 'password' => 'required|min:8',
            ]);

            Petugas::where('id', $this->editId)
                ->update([
                'name' => $this->name,
                'username' => $this->username,
                'email' => $this->email,
                // 'level' => $this->level,
                // 'password' => Hash::make($this->password),
            ]);

            $this->alertUpdateSuccess();
    
        } catch (\Throwable $th) {
            $this->alertError();
        }
        
        $this->ResetInput();
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        try {
            Petugas::where('id', $this->deleteId)->delete();
            $this->alertDeleteSuccess();
        } catch (\Throwable $th) {
            $this->alertError();
        }
        
    }

    public function alertAddSuccess()
    {
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'success',  'message' => 'Petugas Created Successfully!']);
    }

    public function alertUpdateSuccess()
    {
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'success',  'message' => 'Petugas Updated Successfully!']);
    }

    public function alertDeleteSuccess()
    {
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'success',  'message' => 'Petugas Deleted Successfully!']);
    }

    public function alertError()
    {
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'error',  'message' => 'Something is Wrong!' ]);
    }

}
