<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class ListUsers extends Component
{

    public $state = [];
    public $showEditModal = false;
    public function addNew()
    {
        $this-> showEditModal = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function createUser() {
       $validatedData = Validator::make($this->state, [
           'name' => 'required',
           'email' => 'required|email|unique:users',
           'password'=> 'required|confirmed'
       ])->validate();

       $validatedData['password'] = bcrypt($validatedData['password']);

       User::create($validatedData);
       session()->flash('message', 'User Create SuccessFully');
        $this->dispatchBrowserEvent('hide-form', ['message' => 'User added Successfully']);
       return redirect()->back();
    }

    public function edit(User $user){
        $this -> showEditModal = true;
        $this->dispatchBrowserEvent('show-form');
    }

    public function render()
    {
        $users = User::latest()->paginate();
        return view('livewire.admin.users.list-users', [
            'users' => $users
        ]);
    }
}
