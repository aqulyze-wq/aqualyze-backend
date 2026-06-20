<?php

namespace App\Http\Controllers;

use App\Models\SensorData;

class DashboardController extends Controller
{
    public function index()
    {
        $latest = SensorData::orderBy('id', 'desc')->first();

        $history = SensorData::orderBy('id', 'desc')
            ->take(20)
            ->get()
            ->reverse()
            ->values();

        return view('dashboard', compact('latest', 'history'));
    }
}