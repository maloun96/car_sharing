<?php

use App\Http\Controllers\Backend\AppointmentController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ParkingController;

/*
 * All route names are prefixed with 'admin.'.
 */
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

/*
* Parking CRUD
*/
Route::get('parking', [ParkingController::class, 'index'])->name('parking.index');
Route::get('parking/create', [ParkingController::class, 'create'])->name('parking.create');
Route::post('parking', [ParkingController::class, 'store'])->name('parking.store');
/*
 * Specific Parking
 */
Route::group(['prefix' => 'parking/{parking}'], function () {
	Route::patch('/', [ParkingController::class, 'update'])->name('parking.update');
	Route::get('edit', [ParkingController::class, 'edit'])->name('parking.edit');
	Route::get('delete', [ParkingController::class, 'destroy'])->name('parking.delete-permanently');
});





/*
* Appointment CRUD
*/
Route::get('appointment', [AppointmentController::class, 'index'])->name('appointment.index');
Route::get('appointment/create', [AppointmentController::class, 'create'])->name('appointment.create');
Route::post('appointment', [AppointmentController::class, 'store'])->name('appointment.store');

/*
 * Appointment Parking
 */
Route::group(['prefix' => 'appointment/{appointment}'], function () {
    Route::patch('/', [AppointmentController::class, 'update'])->name('appointment.update');
    Route::get('edit', [AppointmentController::class, 'edit'])->name('appointment.edit');
    Route::get('delete', [AppointmentController::class, 'destroy'])->name('appointment.delete-permanently');
});
