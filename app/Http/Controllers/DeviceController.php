<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use App\Helpers\ActivityHelper;

class DeviceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Tampilkan semua device (lengkap dengan search & filter)
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        // 1. Ambil hitungan statistik keseluruhan untuk card di atas
        $totalDevices = Device::count();
        $onlineCount  = Device::whereRaw('LOWER(status) = ?', ['online'])->count();
        $offlineCount = Device::whereRaw('LOWER(status) = ?', ['offline'])->count();

        // 2. Query dasar untuk tabel
        $query = Device::query();

        // 3. Filter berdasarkan pencarian kata kunci
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('device_id', 'like', "%{$search}%")
                  ->orWhere('jenis_ikan', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        // 4. Filter berdasarkan status (online / offline)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 5. Eksekusi query
        $devices = $query->latest()->get();

        return view('devices.index', compact(
            'devices',
            'totalDevices',
            'onlineCount',
            'offlineCount'
        ));
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
            'device_id'  => 'required|unique:devices,device_id',
            'jenis_ikan' => 'required',
            'lokasi'     => 'required',
        ]);

        Device::create([
            'device_id'  => $request->device_id,
            'jenis_ikan' => $request->jenis_ikan,
            'lokasi'     => $request->lokasi,
            'status'     => 'offline',
            'last_seen'  => now(),
        ]);

        ActivityHelper::log(
            'Device',
            'Menambahkan device ' . $request->device_id . ' (' . $request->lokasi . ')'
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
            'device_id'  => 'required|unique:devices,device_id,' . $device->id,
            'jenis_ikan' => 'required',
            'lokasi'     => 'required',
        ]);

        $device->update([
            'device_id'  => $request->device_id,
            'jenis_ikan' => $request->jenis_ikan,
            'lokasi'     => $request->lokasi,
        ]);

        ActivityHelper::log(
            'Device',
            'Mengubah device ' . $device->device_id
        );

        return redirect()
            ->route('devices.index')
            ->with('success', 'Perangkat berhasil diperbarui.');
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
            'Menghapus device ' . $device->device_id
        );

        $device->delete();

        return redirect()
            ->route('devices.index')
            ->with('success', 'Perangkat berhasil dihapus.');
    }
}