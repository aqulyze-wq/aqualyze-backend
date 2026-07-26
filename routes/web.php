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
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\RuleEngineController;
use App\Http\Controllers\RawDataController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/monitoring', [DashboardController::class, 'monitoring'])->name('monitoring');
    Route::get('/charts', [DashboardController::class, 'charts'])->name('charts');
    Route::get('/map', [MapController::class, 'index'])->name('map');

    Route::get('/rule-engine', [RuleEngineController::class, 'index'])->name('rule-engine');
    Route::put('/rule-engine', [RuleEngineController::class, 'update'])->name('rule-engine.update');

    Route::get('/raw-data', [RawDataController::class, 'index'])->name('raw-data');
    
    Route::get('/raw-data/export-excel', [RawDataController::class, 'exportExcel'])->name('raw-data.export-excel');
    Route::get('/raw-data/export-csv', [RawDataController::class, 'exportCsv'])->name('raw-data.export-csv');
    Route::get('/raw-data/export-pdf', [RawDataController::class, 'exportPdf'])->name('raw-data.export-pdf');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| ADMIN ONLY
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

    // Device Management
    Route::resource('devices', DeviceController::class);

    // Account Management
    Route::resource('users', UserController::class);

    // Activity Log
    Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('activity.index');

    // Report Management & Export
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/export', [ReportController::class, 'export'])->name('report.export');

});

require __DIR__ . '/auth.php';