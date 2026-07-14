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
        // =======================
        // Status Suhu
        // Normal  : 25 - 30
        // Warning : 23 - <25 atau >30 - 32
        // Bahaya  : <23 atau >32
        // =======================

        if ($request->suhu >= 25 && $request->suhu <= 30) {

            $statusSuhu = "Normal";

        } elseif (
            ($request->suhu >= 23 && $request->suhu < 25) ||
            ($request->suhu > 30 && $request->suhu <= 32)
        ) {

            $statusSuhu = "Warning";

        } else {

            $statusSuhu = "Bahaya";

        }
    
        // =======================
        // Status pH
        // Normal : 6.5 - 8.0
        // Warning : 6.0 - <6.5 atau >8.0 - 8.5
        // Bahaya : <6.0 atau >8.5
        // =======================

        if ($request->ph >= 6.5 && $request->ph <= 8) {

            $statusPh = "Normal";

        } elseif (
            ($request->ph >= 6 && $request->ph < 6.5) ||
            ($request->ph > 8 && $request->ph <= 8.5)
        ) {

            $statusPh = "Warning";

        } else {

            $statusPh = "Bahaya";

        }
    
        // =======================
        // Status Kekeruhan
        // Normal  : 0 - 30 NTU
        // Warning : >30 - 50 NTU
        // Bahaya  : >50 NTU
        // =======================

        if ($request->kekeruhan <= 30) {

            $statusKekeruhan = "Normal";

        } elseif ($request->kekeruhan <= 50) {

            $statusKekeruhan = "Warning";

        } else {

            $statusKekeruhan = "Bahaya";

        }
    
        $data = SensorData::create([
            'suhu' => $request->suhu,
            'ph' => $request->ph,
            'kekeruhan' => $request->kekeruhan,
            'status_suhu' => $statusSuhu,
            'status_ph' => $statusPh,
            'status_kekeruhan' => $statusKekeruhan,
        ]);
    
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