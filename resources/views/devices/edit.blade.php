@extends('layouts.app')

@section('content')

<div class="aq-page-header">
    <div>
        <h2 class="aq-page-title">Edit Perangkat</h2>
        <p class="aq-page-subtitle">
            Perbarui informasi perangkat monitoring.
        </p>
    </div>
</div>

<div class="aq-card">

    <form action="{{ route('devices.update', $device) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Device ID</label>
            <input
                type="text"
                name="device_id"
                class="form-control"
                value="{{ old('device_id', $device->device_id) }}"
                required>
        </div>

        <div class="mb-3">
            <label>Nama Device</label>
            <input
                type="text"
                name="nama_device"
                class="form-control"
                value="{{ old('nama_device', $device->nama_device) }}"
                required>
        </div>

        <div class="mb-3">
            <label>Jenis Ikan</label>

            <select name="jenis_ikan" class="form-control">

                <option value="Nila"
                    {{ $device->jenis_ikan == 'Nila' ? 'selected' : '' }}>
                    Nila
                </option>

                <option value="Lele"
                    {{ $device->jenis_ikan == 'Lele' ? 'selected' : '' }}>
                    Lele
                </option>

                <option value="Mas"
                    {{ $device->jenis_ikan == 'Mas' ? 'selected' : '' }}>
                    Mas
                </option>

                <option value="Patin"
                    {{ $device->jenis_ikan == 'Patin' ? 'selected' : '' }}>
                    Patin
                </option>

            </select>

        </div>

        <div class="mb-3">
            <label>Lokasi</label>
            <input
                type="text"
                name="lokasi"
                class="form-control"
                value="{{ old('lokasi', $device->lokasi) }}"
                required>
        </div>

        <button type="submit" class="aq-btn-primary">
            <i class="bi bi-check-circle"></i>
            Simpan Perubahan
        </button>

        <a href="{{ route('devices.index') }}" class="btn btn-secondary">
            Batal
        </a>

    </form>

</div>

@endsection