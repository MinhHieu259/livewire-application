<?php

namespace App\Http\Livewire\Admin\Profile;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Livewire\Component;
use Livewire\FileUploadConfiguration;
use Livewire\WithFileUploads;

class UpdateProfile extends Component
{
    use WithFileUploads;

    public $image;
    public $state = [];

    public function mount() {
        $this->state = auth()->user()->only(['name', 'email']);
    }

    public function updatedImage()
    {
        $previuosPath = auth()->user()->avatar;
        $path = $this->image->store('/', 'avatars');
        auth()->user()->update(['avatar' => $path]);
        Storage::disk('avatars')->delete($previuosPath);
        $this->dispatchBrowserEvent('updated', ['message' => 'Profile updated successfully']);
    }

    public function updateProfile(UpdatesUserProfileInformation $updater) {
        $updater->update(auth()->user(), [
            'name' => $this->state['name'],
            'email' => $this->state['email'],
        ]);
        $this->emit('nameChanged', auth()->user()->name);
        $this->dispatchBrowserEvent('updated', ['message' => 'Profile updated successfully']);
    }

    public function changePassword(UpdatesUserPasswords $updater) {
        $updater->update(
            auth()->user(),
            $attributes = Arr::only($this->state, ['current_password', 'password', 'password_confirmation'])
        );

//        collect($attributes)->map(function($value, $key){
//            $this->state[$key] = '';
//        });

        collect($attributes)->map(fn ($value, $key) => $this->state[$key] = '');

        $this->dispatchBrowserEvent('updated', ['message' => 'Password changed successfully']);

    }

    protected function cleanupOldUploads()
    {

        $storage = Storage::disk('local');
        foreach ($storage->allFiles('livewire-tmp') as $filePathname) {
            if (!$storage->exists($filePathname)) continue;

            $yesterdaysStamp = now()->subSeconds(4)->timestamp;
            if ($yesterdaysStamp > $storage->lastModified($filePathname)) {
                $storage->delete($filePathname);
            }
        }
    }

    public function render()
    {
        return view('livewire.admin.profile.update-profile');
    }
}
