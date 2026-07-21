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
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SensorData;
use App\Models\Device;


class SensorController extends Controller
{
    public function latest()
    {
        $data = SensorData::orderByDesc('id')->first();
    
        return response()->json($data);
    }
    public function index()
    {
        return response()->json(
            SensorData::latest()->get()
        );
    }
    public function store(Request $request)
    {
        $device = Device::where('device_id', $request->device_id)->first();

        if (!$device) {
            return response()->json([
                'message' => 'Device tidak ditemukan'
            ], 404);
}
    
        $data = SensorData::create([

            'device_id' => $device->id,

            'suhu' => $request->input('data.suhu'),

            'ph' => $request->input('data.ph'),

            'kekeruhan' => $request->input('data.turbidity_ntu'),

            'status_suhu' => $request->input('data.status_suhu'),

            'status_ph' => $request->input('data.status_ph'),

            'status_kekeruhan' => $request->input('data.status_kekeruhan'),

        ]);
        /*
        Device::where('device_id', $request->device_id)
        ->update([

            'status' => $request->input('status.node_status'),

            'ip_address' => $request->input('status.ip'),

            'latitude' => $request->input('location.latitude'),

            'longitude' => $request->input('location.longitude'),

            'altitude' => $request->input('location.altitude_mdpl'),

            'last_seen' => now(),

        ]);
        */

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $data
        ], 201);
        
    }
    public function history()
    {
        $history = SensorData::latest()
            ->take(20)
            ->get()
            ->reverse()
            ->values();
    
        return response()->json($history);
    }
}