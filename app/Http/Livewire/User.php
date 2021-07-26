<?php

namespace App\Http\Livewire;

use App\Models\Users;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Query\Builder;

class User extends Component
{
    public $deleteId = '';
    public $editId = '';
    public $name, $email, $level, $password;
    
    public function __construct()
    {
        $this->UserModel = new Users();
    }

    public function render()
    {
        if (auth()->user()->level == 1) {

            $data = [
                'user' => $this->UserModel->AllData(),
            ];
    
            return view('livewire.user', $data);

        } else {
            abort(403);
        }

    }

    public function ResetInput()
    {
        $this->name = '';
        $this->email = '';
        $this->level = '';
        $this->password = '';
    }

    public function insert()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'level' => 'required',
            'password' => 'required|min:8',
        ]);

        DB::table('users')->insert([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'level' => $this->level,
        ]);
        
        $this->ResetInput();
    }

    public function editId($id)
    {
        $edit = Users::findOrFail($id);
        $this->editId = $id;
        $this->name = $edit->name;
        $this->email = $edit->email;
        $this->level = $edit->level;
        // $this->password = $edit->password;
    }

    public function edit()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required',
            'level' => 'required',
            // 'password' => 'required|min:8',
        ]);

        DB::table('users')
            ->where('id', $this->editId)
            ->update([
            'name' => $this->name,
            'email' => $this->email,
            // 'password' => Hash::make($this->password),
            'level' => $this->level,
        ]);

        $this->ResetInput();
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        $this->UserModel->DeleteData($this->deleteId);
    }

}
