<?php

namespace App\Http\Livewire\Admin\Users;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class ListUsers extends AdminComponent
{
    public $user;
    public $state = [];
    public $showEditModal = false;
    public $userIdBeingRemove = null;
    public function addNew()
    {
        $this->state = [];
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

    public function updateUser(){
        $validatedData = Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$this->user->id,
            'password'=> 'sometimes|confirmed'
        ])->validate();

       if(!empty($validatedData['password'])){
           $validatedData['password'] = bcrypt($validatedData['password']);
       }

       $this->user->update($validatedData);
        session()->flash('message', 'User Create SuccessFully');
        $this->dispatchBrowserEvent('hide-form', ['message' => 'User update Successfully']);
    }

    public function edit(User $user){
        $this->user = $user;
        $this -> showEditModal = true;
        $this->state = $user->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function confirmUserRemove($userId){
        $this->userIdBeingRemove = $userId;
        $this->dispatchBrowserEvent('show-delete-modal');
    }

    public function deleteUser(){
         $user = User::findOrFail($this->userIdBeingRemove);
         $user->delete();
         $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'User Delete SuccessFully']);
    }

    public function render()
    {
        $users = User::latest()->paginate(5);
        return view('livewire.admin.users.list-users', [
            'users' => $users
        ]);
    }
}
