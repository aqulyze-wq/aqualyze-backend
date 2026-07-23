<?php
// ================================================================
// Nama Sistem  : Aqualyze - Smart Water Monitoring System
// Author       : Refan Rustoni Putra(10824005), Andini Putri Yani(10824011)
// Versi        : 1.3.0
// Tahun        : 2026
// Ownership    : Capstone Project - Universitas
// Deskripsi    : Sistem monitoring kualitas air berbasis IoT
//                dengan API Laravel sebagai backend.
// ================================================================

// ======================= Library ================================


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\SensorData;
use App\Models\ActivityLog; // <-- 1. Import Model ActivityLog di sini

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $devices = Device::orderBy('nama_device')->get();

        $selectedDevice = $request->device;

        // Query dasar untuk SensorData
        $query = SensorData::query();

        if ($selectedDevice) {
            $query->where('device_id', $selectedDevice);
        }

        // Data statistik device dinamis
        $totalDevices = Device::count();
        
        // Menghitung status online & offline
        $onlineDevices = Device::where('status', 'online')->count();
        $offlineDevices = Device::where('status', 'offline')->count();

        // Data terbaru sensor
        $latest = (clone $query)
            ->latest()
            ->first();

        // Waktu update terakhir
        $lastUpdate = $latest ? $latest->created_at : Device::latest('updated_at')->first()?->updated_at;

        // History untuk chart
        $history = (clone $query)
            ->latest()
            ->take(20)
            ->get()
            ->reverse()
            ->values();

        // Ambil 4 Recent Activity Logs beserta relasi user
        $recentActivities = ActivityLog::with('user')->latest()->take(4)->get();

        // Total data
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
            'recentActivities' // <-- 2. Variabel disangkutkan ke view di sini
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
