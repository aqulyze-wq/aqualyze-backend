<?php
// ================================================================
// Nama Sistem  : Aqualyze - Smart Water Monitoring System
// Author       : Refan Rustoni Putra
// NIM          : 10824005
// Versi        : 1.3.0
// Tahun        : 2026
// Ownership    : Capstone Project - Universitas
// Deskripsi    : Sistem monitoring kualitas air berbasis IoT
//                dengan API Laravel sebagai backend.
// ================================================================

// ======================= Library ================================
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SensorController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DeviceApiController;

// Login   
Route::post('/login', [AuthController::class, 'login']);

// Sensor (Disesuaikan agar /sensor/store cocok dengan ESP32)
Route::get('/latest', [SensorController::class, 'latest']);
Route::get('/sensor-data', [SensorController::class, 'index']);
Route::post('/sensor/store', [SensorController::class, 'store']); // Diubah dari /sensor ke /sensor/store
Route::post('/sensor', [SensorController::class, 'store']);      // Cadangan jika sewaktu-waktu dibutuhkan
Route::get('/history', [SensorController::class, 'history']);

// Device Update (Duplikasi dihapus, menggunakan DeviceApiController)
Route::post('/device/update', [DeviceApiController::class, 'updateStatus']);

// Logout
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);