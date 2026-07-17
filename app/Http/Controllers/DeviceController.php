<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use App\Helpers\ActivityHelper;

class DeviceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Tampilkan semua device
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $devices = Device::latest()->get();

        return view('devices.index', compact('devices'));
    }

    /*
    |--------------------------------------------------------------------------
    | Form tambah device
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('devices.create');
    }

    /*
    |--------------------------------------------------------------------------
    | Simpan device baru
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'device_id'   => 'required|unique:devices,device_id',

            'nama_device' => 'required',

            'jenis_ikan'  => 'required',

            'lokasi'       => 'required',

        ]);

        Device::create([

            'device_id'   => $request->device_id,

            'nama_device' => $request->nama_device,

            'jenis_ikan'  => $request->jenis_ikan,

            'lokasi'      => $request->lokasi,

            'status'      => 'offline',

            'last_seen'   => now(),

        ]);
        ActivityHelper::log(

            'Device',

            'Menambahkan device '.$request->nama_device

        );

        return redirect()
            ->route('devices.index')
            ->with('success', 'Perangkat berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | Form edit
    |--------------------------------------------------------------------------
    */

    public function edit(Device $device)
    {
        return view('devices.edit', compact('device'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update device
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Device $device)
    {
        $request->validate([

            'device_id'   => 'required|unique:devices,device_id,' . $device->id,

            'nama_device' => 'required',

            'jenis_ikan'  => 'required',

            'lokasi'      => 'required',

        ]);

        $device->update([

            'device_id'   => $request->device_id,

            'nama_device' => $request->nama_device,

            'jenis_ikan'  => $request->jenis_ikan,

            'lokasi'      => $request->lokasi,

        ]);

        ActivityHelper::log(

            'Device',

            'Mengubah device '.$device->nama_device

        );

        return redirect()

            ->route('devices.index')

            ->with('success','Perangkat berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | Hapus device
    |--------------------------------------------------------------------------
    */

    public function destroy(Device $device)
    {
        ActivityHelper::log(

            'Device',

            'Menghapus device '.$device->nama_device

        );

        $device->delete();

        return redirect()

            ->route('devices.index')

            ->with('success','Perangkat berhasil dihapus.');
    }
}
