<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SensorData;
use App\Models\Device;
use App\Models\RuleEngine;
use Illuminate\Support\Facades\Log;

class SensorController extends Controller
{
    public function latest()
    {
        $data = SensorData::orderByDesc('id')->first();
        return response()->json($data);
    }

    public function index()
    {
        return response()->json(SensorData::latest()->get());
    }

    public function store(Request $request)
    {
        try {
            // Ambil identifier device dari request
            $deviceIdInput = $request->input('device_id');

            // 1. Cari Device (Mendukung pencarian berdasarkan device_id, ID angka, atau nama_device)
            // KODE BARU (SUDAH DIPERBAIKI)
            $device = Device::where('device_id', $deviceIdInput)
                        ->orWhere('id', $deviceIdInput)
                        ->orWhere('lokasi', $deviceIdInput) // Menggunakan 'lokasi' sebagai pengganti nama_device
                        ->first();

            // Jika device tidak ditemukan, ambil device default atau buat jika perlu
            if (!$device) {
                // Alternatif: Ambil device pertama sebagai fallback agar data tidak hilang
                $device = Device::first();
                
                if (!$device) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Device ' . $deviceIdInput . ' tidak ditemukan di database!'
                    ], 404);
                }
            }

            // 2. Ambil data sensor (Mendukung format nested JSON "data.suhu" maupun flat "suhu")
            $suhu       = $request->input('data.suhu') ?? $request->input('suhu');
            $ph         = $request->input('data.ph') ?? $request->input('ph');
            $kekeruhan  = $request->input('data.turbidity_ntu') ?? $request->input('kekeruhan');

            // Ambil Rule Engine dari database
            $rule = RuleEngine::first();

            // Cari status otomatis
            $statusSuhu      = $request->input('data.status_suhu') ?? $request->input('status_suhu') ?? $this->determineTempStatus($suhu, $rule);
            $statusPh        = $request->input('data.status_ph') ?? $request->input('status_ph') ?? $this->determinePhStatus($ph, $rule);
            $statusKekeruhan = $request->input('data.status_kekeruhan') ?? $request->input('status_kekeruhan') ?? $this->determineTurbidityStatus($kekeruhan, $rule);

            // 3. Simpan Riwayat Data Sensor ke Tabel SensorData
            $data = SensorData::create([
                'device_id'        => $device->id, // Menyimpan ID Relasi ke tabel devices
                'suhu'             => $suhu,
                'ph'               => $ph,
                'kekeruhan'        => $kekeruhan,
                'status_suhu'      => $statusSuhu,
                'status_ph'        => $statusPh,
                'status_kekeruhan' => $statusKekeruhan,
            ]);

            // 4. Update Informasi Device (jika data status/lokasi dikirim)
            $updateData = ['last_seen' => now()];
            
            if ($request->has('status.node_status')) {
                $updateData['status'] = $request->input('status.node_status');
            }
            if ($request->has('status.ip')) {
                $updateData['ip_address'] = $request->input('status.ip');
            }
            if ($request->has('location.latitude')) {
                $updateData['latitude'] = $request->input('location.latitude');
            }
            if ($request->has('location.longitude')) {
                $updateData['longitude'] = $request->input('location.longitude');
            }
            if ($request->has('lokasi')) {
                $updateData['lokasi'] = $request->input('lokasi');
            }

            $device->update($updateData);

            return response()->json([
                'status'  => 'success',
                'message' => 'Data berhasil disimpan',
                'data'    => $data
            ], 201);

        } catch (\Exception $e) {
            Log::error('Sensor store error: ' . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan pada server: ' . $e->getMessage()
            ], 500);
        }
    }

    private function determineTempStatus($val, $rule)
    {
        if (!$rule || is_null($val)) return 'Normal';
        if ($val >= $rule->temperature_normal_min && $val <= $rule->temperature_normal_max) return 'Normal';
        if ($val >= $rule->temperature_warning_min && $val <= $rule->temperature_warning_max) return 'Warning';
        return 'Danger';
    }

    private function determinePhStatus($val, $rule)
    {
        if (!$rule || is_null($val)) return 'Normal';
        if ($val >= $rule->ph_normal_min && $val <= $rule->ph_normal_max) return 'Normal';
        if ($val >= $rule->ph_warning_min && $val <= $rule->ph_warning_max) return 'Warning';
        return 'Danger';
    }

    private function determineTurbidityStatus($val, $rule)
    {
        if (!$rule || is_null($val)) return 'Clear';
        if ($val <= $rule->turbidity_very_clear_max) return 'Very Clear';
        if ($val <= $rule->turbidity_clear_max) return 'Clear';
        return 'Turbid';
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