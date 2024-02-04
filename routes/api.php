<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ScheduleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//Route::group(['middleware' => 'api'], function()  updateDriver
//{
    Route::get('/all-users', [UserController::class, 'allUsers']);
    Route::post('/test-user', [UserController::class, 'saveUser']);
    Route::put('/update-user/{id}', [UserController::class, 'updateUser']);
    Route::delete('/delete-user/{id}', [UserController::class, 'deleteUser']);

    Route::get('/all-buses', [BusController::class, 'allBuses']);
    Route::post('/test-bus', [BusController::class, 'saveBus']);
    Route::put('/update-bus/{id}', [BusController::class, 'updateBus']);
    Route::delete('/delete-bus/{id}', [BusController::class, 'deleteBus']);

    Route::get('/all-drivers', [DriverController::class, 'allDrivers']);
    Route::post('/test-driver', [DriverController::class, 'saveDriver']);
    Route::put('/update-driver/{id}', [DriverController::class, 'updateDriver']);
    Route::delete('/delete-driver/{id}', [DriverController::class, 'deleteDriver']);

    Route::get('/all-customers', [CustomerController::class, 'allCustomers']);
    Route::post('/test-customer', [CustomerController::class, 'saveCustomer']);
    Route::put('/update-customer/{id}', [CustomerController::class, 'updateCustomer']);
    Route::delete('/delete-customer/{id}', [CustomerController::class, 'deleteCustomer']);

    Route::get('/all-schedules', [ScheduleController::class, 'allSchedules']);
    Route::post('/test-schedule', [ScheduleController::class, 'saveSchedule']);
    Route::put('/update-schedule/{id}', [ScheduleController::class, 'updateSchedule']);
    Route::delete('/delete-schedule/{id}', [ScheduleController::class, 'deleteSchedule']);

    Route::get('/all-bookings', [BookingController::class, 'allBookings']);
    Route::post('/test-booking', [BookingController::class, 'saveBooking']);
    Route::put('/update-booking/{id}', [BookingController::class, 'updateBooking']);
    Route::delete('/delete-booking/{id}', [BookingController::class, 'deleteBooking']);

    Route::get('/all-payments', [PaymentController::class, 'allPayments']);
    Route::post('/test-payment', [PaymentController::class, 'savePayment']);
    Route::put('/update-payment/{id}', [PaymentController::class, 'updatePayment']);
    Route::delete('/delete-payment/{id}', [PaymentController::class, 'deletePayment']);
//});

