<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Models\Setting;
use Livewire\Component;

class UpdateSetting extends Component
{
    public $state = [];

    public function mount(){
        $this->state = Setting::first()->toArray();
    }

    public function updateSetting()
    {
        $setting = Setting::first();
        if ($setting) {
            $setting->update($this->state);
        } else {
            Setting::create($this->state);
        }
        $this->dispatchBrowserEvent('updated', ['message' => 'Settings updated successfully']);
    }

    public function render()
    {
        return view('livewire.admin.settings.update-setting');
    }
}
