<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAppointmentController;

Route::get('/', function () {
    return 'Api';
});

Route::name('api.')->group(function () {
    Route::apiResource('appointments', ApiAppointmentController::class);
});
