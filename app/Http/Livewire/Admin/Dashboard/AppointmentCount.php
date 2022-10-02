<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Models\Appointment;
use Livewire\Component;

class AppointmentCount extends Component
{
    public $appointmentCount;

    public function mount() {
        $this->getAppointmentCount();
    }

    public function getAppointmentCount($status = null) {
       $this->appointmentCount = Appointment::query()
       ->when($status, function($query, $status) {
           return $query->where('status', $status);
       })->count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard.appointment-count');
    }
}
