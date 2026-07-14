@extends('layouts.app')

@section('content')

<div class="aq-page-header">
    <div>
        <h2 class="aq-page-title">Manajemen Perangkat</h2>
        <p class="aq-page-subtitle">
            Kelola seluruh perangkat monitoring Aqualyze.
        </p>
    </div>

    <a
    href="{{ route('devices.create') }}"
    class="aq-btn-primary">

    <i class="bi bi-plus-circle"></i>

    Tambah Perangkat

    </a>
</div>

<div class="aq-device-stats">

    <div class="aq-device-stat">

        <div class="aq-device-icon blue">

            <i class="bi bi-hdd-network"></i>

        </div>

        <div>

            <span>Total Device</span>

            <h3>{{ $devices->count() }}</h3>

        </div>

    </div>

    <div class="aq-device-stat">

        <div class="aq-device-icon green">

            <i class="bi bi-wifi"></i>

        </div>

        <div>

            <span>Online</span>

            <h3>{{ $devices->where('status','online')->count() }}</h3>

        </div>

    </div>

    <div class="aq-device-stat">

        <div class="aq-device-icon red">

            <i class="bi bi-wifi-off"></i>

        </div>

        <div>

            <span>Offline</span>

            <h3>{{ $devices->where('status','offline')->count() }}</h3>

        </div>

    </div>

</div>

<div class="aq-card">
    

    <div class="d-flex justify-content-between align-items-center mb-3">

        <input
            type="text"
            class="form-control"
            placeholder="Cari perangkat..."
            style="max-width:320px;">

        <select
            class="form-select"
            style="width:180px;">

            <option>Semua Status</option>
            <option>Online</option>
            <option>Offline</option>

        </select>

    </div>
    <table class="aq-table">

        <thead>

        <tr>

            <th>Device ID</th>

            <th>Nama Device</th>

            <th>Jenis Ikan</th>

            <th>Lokasi</th>

            <th>Status</th>

            <th>Last Seen</th>

            <th>Aksi</th>

        </tr>

        </thead>

        <tbody>

        @forelse($devices as $device)

        <tr>

            <td>

                <strong>{{ $device->device_id }}</strong>

            </td>

            <td>

                {{ $device->nama_device }}

            </td>

            <td>

                {{ $device->jenis_ikan }}

            <td>

                {{ $device->lokasi }}

            </td>

            <td>

                @if($device->status=="online")

                    <span class="aq-badge aq-badge-success">

                        Online

                    </span>

                @else

                    <span class="aq-badge aq-badge-danger">

                        Offline

                    </span>

                @endif

            </td>

            <td>

                {{ \Carbon\Carbon::parse($device->last_seen)->format('d M Y H:i') }}

            </td>

            <td>

                <a href="{{ route('devices.edit', $device->id) }}"
                   class="aq-btn-icon">

                    <i class="bi bi-pencil"></i>

                </a>

                <form
                action="{{ route('devices.destroy',$device->id) }}"
                method="POST"
                style="display:inline;">

                @csrf

                @method('DELETE')

                <button
                type="submit"
                class="aq-btn-icon text-danger"

                onclick="return confirm('Yakin ingin menghapus perangkat ini?')">

                <i class="bi bi-trash"></i>

                </button>

                </form>

            </td>

        </tr>

        @empty

        <tr>

            <td colspan="7">

                Belum ada device.

            </td>

        </tr>

        @endforelse

        </tbody>

    </table>

</div>


@endsection