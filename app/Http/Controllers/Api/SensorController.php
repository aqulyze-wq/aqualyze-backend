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
        $data = SensorData::create([
            'suhu' => $request->suhu,
            'ph' => $request->ph,
            'kekeruhan' => $request->kekeruhan,
            'status_suhu' => $request->status_suhu,
            'status_ph' => $request->status_ph,
            'status_kekeruhan' => $request->status_kekeruhan,
        ]);
    
        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $data
        ], 201);
    }
}