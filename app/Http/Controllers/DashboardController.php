<?php

// ================================================================
// Nama Sistem  : Aqualyze - Smart Water Monitoring System
// Author       : Refan Rustoni Putra (10824005), 
//                Andini Putri Yani (10824011)
// Versi        : 1.4.2
// Tahun        : 2026
// Ownership    : Capstone Project - Universitas
// Deskripsi    : Sistem monitoring kualitas air berbasis IoT
//                dengan API Laravel sebagai backend.
// ================================================================

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\SensorData;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil daftar device (diurutkan berdasarkan lokasi atau device_id)
        $devices = Device::orderBy('lokasi')->orderBy('device_id')->get();

        $selectedDevice = $request->device;

        // Query dasar untuk SensorData
        $query = SensorData::query();

        if ($selectedDevice) {
            $query->where('device_id', $selectedDevice);
        }

        // Data statistik device
        $totalDevices  = Device::count();
        $onlineDevices  = Device::whereRaw('LOWER(status) = ?', ['online'])->count();
        $offlineDevices = Device::whereRaw('LOWER(status) = ?', ['offline'])->count();

        // Data terbaru sensor berdasarkan filter device
        $latest = (clone $query)
            ->latest()
            ->first();

        // Waktu update terakhir
        $lastUpdate = $latest 
            ? $latest->created_at 
            : Device::latest('last_seen')->first()?->last_seen;

        // History untuk chart (20 data terakhir)
        $history = (clone $query)
            ->latest()
            ->take(20)
            ->get()
            ->reverse()
            ->values();

        // Ambil 4 Recent Activity Logs beserta relasi user
        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(4)
            ->get();

        // Total data tersimpan
        $totalData = (clone $query)->count();

        return view('dashboard', compact(
            'devices',
            'selectedDevice',
            'latest',
            'history',
            'totalData',
            'totalDevices',
            'onlineDevices',
            'offlineDevices',
            'lastUpdate',
            'recentActivities'
        ));
    }

    public function monitoring()
    {
        $latest = SensorData::latest()->first();

        $history = SensorData::latest()
            ->take(100)
            ->get()
            ->reverse()
            ->values();

        return view('monitoring', compact('latest', 'history'));
    }

    public function charts()
    {
        $latest = SensorData::latest()->first();

        $history = SensorData::latest()
            ->take(100)
            ->get()
            ->reverse()
            ->values();

        return view('charts', compact('latest', 'history'));
    }
}