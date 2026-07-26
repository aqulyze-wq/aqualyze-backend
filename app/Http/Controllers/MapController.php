<?php

namespace App\Http\Controllers;

use App\Models\Device;

class MapController extends Controller
{
    public function index()
    {
        $devices = Device::all();

        return view('map', compact('devices'));
    }
}