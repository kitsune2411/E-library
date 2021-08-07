<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Users;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CrudSiswa extends Component
{
    public $deleteId = '';
    public $editId = '';
    public $name, $username, $nis, $email, $level, $password;
    
    public function __construct()
    {
        $this->UserModel = new Users();
    }

    public function render()
    {
        if (auth()->user()->level == 1 || auth()->user()->level == 2) {

            $data = [
                'user' => $this->UserModel->AllDataSiswa(),
            ];
    
            return view('livewire.crud-siswa', $data);

        } else {
            abort(403);
        }

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
                'nis' => 'required',
                'email' => 'required|unique:users,email',
                // 'level' => 'required',
                'password' => 'required|min:8',
            ]);

            DB::table('users')->insert([
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
        $edit = Users::findOrFail($id);
        $this->editId = $id;
        $this->name = $edit->name;
        $this->nis = $edit->nis;
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
                'nis' => 'required',
                'email' => 'required|unique:users,email',
                // 'level' => 'required',
                // 'password' => 'required|min:8',
            ]);

            DB::table('users')
                ->where('id', $this->editId)
                ->update([
                'name' => $this->name,
                'username' => $this->username,
                'nis' => $this->nis,
                'email' => $this->email,
                // 'level' => $this->level,
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
            $this->UserModel->DeleteData($this->deleteId);
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
