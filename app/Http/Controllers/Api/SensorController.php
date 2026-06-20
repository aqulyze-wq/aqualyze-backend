<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SensorData;

class SensorController extends Controller
{
    public function latest()
    {
        $data = SensorData::latest()->first();

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
        $statusSuhu = ($request->suhu >= 28 && $request->suhu <= 30)
            ? 'Normal'
            : 'Warning';
    
        $statusPh = ($request->ph >= 6.5 && $request->ph <= 8)
            ? 'Normal'
            : 'Warning';
    
        $statusKekeruhan = ($request->kekeruhan <= 10)
            ? 'Normal'
            : 'Warning';
    
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
}