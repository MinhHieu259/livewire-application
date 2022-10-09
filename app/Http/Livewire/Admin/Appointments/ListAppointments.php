<?php

namespace App\Http\Livewire\Admin\Appointments;

use App\Exports\AppointmentExport;
use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Appointment;
use Maatwebsite\Excel\Facades\Excel;

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
            ->orderBy('order_position', 'asc')
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

    public function export()
    {
        return (new AppointmentExport($this->selectedRows))->download('appointments.xls');
    }

    public function updateAppointmentOrder($items){
        foreach ($items as $item){
            Appointment::find($item['value'])->update(['order_position' => $item['order']]);
        }
        $this->dispatchBrowserEvent('updated', ['message' => 'Appointments sorted successfully']);

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
