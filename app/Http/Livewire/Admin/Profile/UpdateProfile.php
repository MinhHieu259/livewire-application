<?php

namespace App\Http\Livewire\Admin\Profile;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\FileUploadConfiguration;
use Livewire\WithFileUploads;

class UpdateProfile extends Component
{
    use WithFileUploads;

    public $image;

    public function updatedImage()
    {
        $previuosPath = auth()->user()->avatar;
        $path = $this->image->store('/', 'avatars');
        auth()->user()->update(['avatar' => $path]);
        Storage::disk('avatars')->delete($previuosPath);
        $this->dispatchBrowserEvent('updated', ['message' => 'Profile updated successfully']);
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
