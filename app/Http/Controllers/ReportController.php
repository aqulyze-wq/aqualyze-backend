<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\SensorData;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $totalDevice = Device::count();

        $online = Device::where('status', 'online')->count();

        $offline = Device::where('status', 'offline')->count();

        $warning = SensorData::whereDate('created_at', today())
            ->where(function ($query) {

                $query->where('status_suhu', 'Warning')
                    ->orWhere('status_ph', 'Warning')
                    ->orWhere('status_kekeruhan', 'Warning');

            })
            ->count();

        $query = SensorData::latest();

        if ($request->filled('start')) {
            $query->whereDate('created_at', '>=', $request->start);
        }

        if ($request->filled('end')) {
            $query->whereDate('created_at', '<=', $request->end);
        }

        if ($request->filled('device')) {
            $query->where('device_id', $request->device);
        }

        $data = $query->paginate(15);

        $devices = Device::all();

        return view('report.index', compact(
            'totalDevice',
            'online',
            'offline',
            'warning',
            'data',
            'devices'
        ));
    }
}