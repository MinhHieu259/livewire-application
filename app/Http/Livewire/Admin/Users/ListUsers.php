<?php

namespace App\Http\Livewire\Admin\Users;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class ListUsers extends AdminComponent
{
    use WithFileUploads;

    public $user;
    public $state = [];
    public $showEditModal = false;
    public $userIdBeingRemove = null;
    public $searchTerm = null;
    public $photo;

    public function addNew()
    {
        $this->reset();
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function createUser()
    {
        $validatedData = Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ])->validate();

        if ($this->photo) {
            $validatedData['avatar'] = $this->photo->store('/', 'avatars');
        }

        $validatedData['password'] = bcrypt($validatedData['password']);

        User::create($validatedData);
        session()->flash('message', 'User Create SuccessFully');
        $this->dispatchBrowserEvent('hide-form', ['message' => 'User added Successfully']);
        return redirect()->back();
    }

    public function updateUser()
    {
        $validatedData = Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'password' => 'sometimes|confirmed'
        ])->validate();

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }

        if ($this->photo) {
            Storage::disk('avatars')->delete($this->user->avatar);
            $validatedData['avatar'] = $this->photo->store('/', 'avatars');
        }

        $this->user->update($validatedData);
        session()->flash('message', 'User Create SuccessFully');
        $this->dispatchBrowserEvent('hide-form', ['message' => 'User update Successfully']);
    }

    public function edit(User $user)
    {
        $this->reset();
        $this->user = $user;
        $this->showEditModal = true;
        $this->state = $user->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function confirmUserRemove($userId)
    {
        $this->userIdBeingRemove = $userId;
        $this->dispatchBrowserEvent('show-delete-modal');
    }

    public function deleteUser()
    {
        $user = User::findOrFail($this->userIdBeingRemove);
        $user->delete();
        $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'User Delete SuccessFully']);
    }

    public function changeRole(User $user, $role) {
        Validator::make(['role' => $role], [
            'role' => [
                'required',
                Rule::in(User::ROLE_ADMIN, User::ROLE_USER)
            ],
        ])->validate();
        $user->update(['role' => $role]);
        $this->dispatchBrowserEvent('updated', ['message' => 'Role changed to '.$role.' successfully']);
    }

    public function render()
    {
        $users = User::query()->where('name', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('email', 'like', '%' . $this->searchTerm . '%')
            ->latest()->paginate(5);
        return view('livewire.admin.users.list-users', [
            'users' => $users
        ]);
    }
}
