<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;

class DeviceApiController extends Controller
{
    public function updateStatus(Request $request)
    {
        $request->validate([

            'device_id' => 'required',

            'status' => 'required',

            'ip' => 'nullable',

            'latitude' => 'nullable',

            'longitude' => 'nullable',

            'altitude' => 'nullable',

        ]);

        $device = Device::where(
            'device_id',
            $request->device_id
        )->first();

        if (!$device) {

            return response()->json([
                'message' => 'Device tidak ditemukan'
            ],404);

        }

        $device->update([

            'status' => $request->status,

            'ip_address' => $request->ip,

            'latitude' => $request->latitude,

            'longitude' => $request->longitude,

            'altitude' => $request->altitude,

            'last_seen' => now()

        ]);

        return response()->json([

            'message' => 'Device berhasil diperbarui',

            'device' => $device

        ]);
    }
}