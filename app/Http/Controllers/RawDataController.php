<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\SensorData;

class RawDataController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $direction = $request->query('direction', 'desc') === 'asc' ? 'asc' : 'desc';

        $sensorData = SensorData::with('device')
            ->whereHas('device')
            ->when($search, function ($query, $value) {
                $query->whereHas('device', function ($query) use ($value) {
                    $query->where('nama_device', 'like', "%{$value}%");
                })
                ->orWhere('suhu', 'like', "%{$value}%")
                ->orWhere('ph', 'like', "%{$value}%")
                ->orWhere('kekeruhan', 'like', "%{$value}%");
            })
            ->orderBy('created_at', $direction)
            ->paginate(15)
            ->withQueryString();

        return view('raw-data', [
            'sensorData' => $sensorData,
            'search' => $search,
            'direction' => $direction,
        ]);
    }
}
