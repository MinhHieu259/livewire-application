<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Livewire\Admin\Appointments\CreateAppointmentForm;
use App\Http\Livewire\Admin\Appointments\ListAppointments;
use App\Http\Livewire\Admin\Users\ListUsers;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function (){
    Route::get('/dashboard', DashboardController::class)->name('admin.dashboard');

    Route::get('/users', ListUsers::class)->name('admin.users');

    Route::get('/appointments', ListAppointments::class)->name('admin.appointments');

    Route::get('/appointments/create', CreateAppointmentForm::class)->name('admin.appointments.create');
});

