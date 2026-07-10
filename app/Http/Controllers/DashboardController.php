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
namespace App\Http\Controllers;

use App\Models\SensorData;

class DashboardController extends Controller
{
    public function index()
    {
        $latest = SensorData::orderByDesc('id')->first();
    
        $history = SensorData::orderByDesc('id')
            ->take(20)
            ->get()
            ->reverse()
            ->values();
    
        $totalData = SensorData::count();
    
        return view('dashboard', compact(
            'latest',
            'history',
            'totalData'
        ));
    }

    public function monitoring()
    {
        $latest = SensorData::orderBy('id', 'desc')->first();
    
        $history = SensorData::orderBy('id', 'desc')
            ->take(100)
            ->get()
            ->reverse()
            ->values();
    
        return view('monitoring', compact('latest', 'history'));
    }

   public function charts()
    {
        $latest = SensorData::orderBy('id', 'desc')->first();

        $history = SensorData::orderBy('id', 'desc')
            ->take(100)
            ->get()
            ->reverse()
            ->values();

        return view('charts', compact('latest', 'history'));
    }
}
