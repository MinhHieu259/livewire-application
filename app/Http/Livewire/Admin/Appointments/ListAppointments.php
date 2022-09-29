<?php

namespace App\Http\Livewire\Admin\Appointments;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Appointment;

class ListAppointments extends AdminComponent
{
    protected $listeners = ['deleteConfirmed' => 'deleteAppointment'];

    public $appointmentIdBeingRemoved = null;

    public $status = null;

    protected $queryString = ['status'];

    public $selectedRows = [];

    public $selectPageRows = false;

    public function confirmAppointmentRemoval($appointmentId)
    {
        $this->appointmentIdBeingRemoved = $appointmentId;

        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    public function deleteAppointment()
    {
        $appointment = Appointment::findOrFail($this->appointmentIdBeingRemoved);
        $appointment->delete();
        $this->dispatchBrowserEvent('deleted', ['message' => 'Appointment deleted successfully']);
    }

    public function filterAppointmentsByStatus($status = null)
    {
        $this->resetPage();
        $this->status = $status;
    }

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->appointments->pluck('id')->map(function ($id) {
                return (string)$id;
            });
        } else {
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function getAppointmentsProperty()
    {
        return Appointment::with('client')
            ->when($this->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(5);
    }

    public function markAllAsScheduled()
    {
        Appointment::whereIn('id', $this->selectedRows)->update(['status' => 'SCHEDULED']);
        $this->dispatchBrowserEvent('updated', ['message' => 'All selected appointment got updated scheduled']);
        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function markAllAsClosed()
    {
        Appointment::whereIn('id', $this->selectedRows)->update(['status' => 'CLOSED']);
        $this->dispatchBrowserEvent('updated', ['message' => 'All selected appointment got updated closed']);
        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function deleteSelectedRows()
    {
        Appointment::whereIn('id', $this->selectedRows)->delete();
        $this->dispatchBrowserEvent('deleted', ['message' => 'All selected appointment got deleted']);
        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function render()
    {
        $appointments = $this->appointments;
        $appointmentCount = Appointment::count();
        $cheduledAppointmentCount = Appointment::where('status', 'scheduled')->count();
        $closeAppointmentCount = Appointment::where('status', 'closed')->count();
        return view('livewire.admin.appointments.list-appointments', [
            'appointments' => $appointments,
            'appointmentCount' => $appointmentCount,
            'cheduledAppointmentCount' => $cheduledAppointmentCount,
            'closeAppointmentCount' => $closeAppointmentCount
        ]);
    }
}
