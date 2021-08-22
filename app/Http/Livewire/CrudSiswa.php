<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Users as Siswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class CrudSiswa extends Component
{
    use WithPagination;

    public $searchterm;
    public $deleteId = '';
    public $editId = '';
    public $name, $username, $nis, $email, $level, $password;
    
    public function render()
    {
        if (auth()->user()->level == 1 || auth()->user()->level == 2) {

            $searchterm ='%'. $this->searchterm. '%';
            $data = [
                'user' => Siswa::
                            where(function($query) use ($searchterm) {
                                $query->where('level', 3)
                                    ->where('name', 'like', $searchterm);
                            })
                            ->orWhere(function($query) use ($searchterm) {
                                $query->where('level', 3)
                                    ->where('username', 'like', $searchterm);
                            })
                            ->orWhere(function($query) use ($searchterm) {
                                $query->where('level', 3)
                                    ->where('email', 'like', $searchterm);
                            })
                            ->orWhere(function($query) use ($searchterm) {
                                $query->where('level', 3)
                                    ->where('nis', 'like', $searchterm);
                            })
                            ->paginate(5),
            ];
    
            return view('livewire.crud-siswa', $data);

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
        $this->username = '';
        $this->email = '';
        $this->nis = '';
        $this->password = '';
    }

    public function insert()
    {
        try {
            $this->validate([
                'name' => 'required',
                'username' => 'required|unique:users,username',
                'nis' => 'required|unique:users,nis',
                'email' => 'required|unique:users,email',
                'password' => 'required|min:8',
            ]);

            Siswa::create([
                'name' => $this->name,
                'username' => $this->username,
                'nis' => $this->nis,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'level' => 3,
            ]);

            $this->alertAddSuccess();

        } catch (\Throwable $th) {
            //throw $th;
            $this->alertError();
        }
        
        $this->ResetInput();

    }

    public function editId($id)
    {
        $edit = Siswa::findOrFail($id);
        $this->editId = $id;
        $this->name = $edit->name;
        $this->nis = $edit->nis;
        $this->username = $edit->username;
        $this->email = $edit->email;
        // $this->password = $edit->password;
    }

    public function edit()
    {
        try {
            $this->validate([
                'name' => 'required',
                'username' => 'required|unique:users,username,'.$this->editId,
                'nis' => 'required|unique:users,nis,'.$this->editId,
                'email' => 'required|unique:users,email,'.$this->editId,
                // 'password' => 'required|min:8',
            ]);

            Siswa::where('id', $this->editId)
                ->update([
                'name' => $this->name,
                'username' => $this->username,
                'nis' => $this->nis,
                'email' => $this->email,
                // 'password' => Hash::make($this->password),
            ]);

            $this->alertUpdateSuccess();

        } catch (\Throwable $th) {
            //throw $th;
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
            Siswa::where('id', $this->deleteId)->delete();
            $this->alertDeleteSuccess();
        } catch (\Throwable $th) {
            $this->alertError();
        }
        
    }

    public function alertAddSuccess()
    {
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'success',  'message' => 'Siswa Created Successfully!']);
    }

    public function alertUpdateSuccess()
    {
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'success',  'message' => 'Siswa Updated Successfully!']);
    }

    public function alertDeleteSuccess()
    {
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'success',  'message' => 'Siswa Deleted Successfully!']);
    }

    public function alertError()
    {
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'error',  'message' => 'Something is Wrong!' ]);
    }
}
