<?php

namespace App\Http\Livewire;

use App\Models\Users;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Query\Builder;

class CrudPetugas extends Component
{
    public $deleteId = '';
    public $editId = '';
    public $name, $username, $email, $level, $password;
    
    public function __construct()
    {
        $this->UserModel = new Users();
    }

    public function render()
    {
        if (auth()->user()->level == 1) {

            $data = [
                'user' => $this->UserModel->AllDataPetugas(),
            ];
    
            return view('livewire.crud-petugas', $data);

        } else {
            abort(403);
        }

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

            DB::table('users')->insert([
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
        $edit = Users::findOrFail($id);
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
                'username' => 'required|unique:users,username',
                'email' => 'required|unique:users,email',
                // 'level' => 'required',
                // 'password' => 'required|min:8',
            ]);

            DB::table('users')
                ->where('id', $this->editId)
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
            $this->UserModel->DeleteData($this->deleteId);
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
