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

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $devices = Device::orderBy('nama_device')->get();

        $selectedDevice = $request->device;

        // Query dasar
        $query = SensorData::query();

        if ($selectedDevice) {
            $query->where('device_id', $selectedDevice);
        }

        // Data terbaru
        $latest = (clone $query)
            ->latest()
            ->first();

        // History untuk chart
        $history = (clone $query)
            ->latest()
            ->take(20)
            ->get()
            ->reverse()
            ->values();

        // Total data
        $totalData = (clone $query)->count();

        return view('dashboard', compact(
            'devices',
            'selectedDevice',
            'latest',
            'history',
            'totalData'
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
