<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Analytics extends Component
{
    public function render()
    {
        return view('livewire.analytics')->layout('layouts.realtime');
    }
}
