<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SensorController;

Route::get('/latest', [SensorController::class, 'latest']);
Route::get('/sensor-data', [SensorController::class, 'index']);
Route::post('/sensor', [SensorController::class, 'store']);