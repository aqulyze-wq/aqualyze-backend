@extends('layouts.app')

@section('content')

<div class="aq-page-header mb-4">
    <div>
        <h2 class="aq-page-title text-xl font-bold">
            Tambah Perangkat
        </h2>
        <p class="aq-page-subtitle text-sm text-slate-500">
            Tambahkan perangkat monitoring baru ke dalam sistem.
        </p>
    </div>
</div>

<div class="aq-card p-6 bg-white rounded-lg shadow-sm border border-slate-200 max-w-xl">
    <form method="POST" action="{{ route('devices.store') }}">
        @csrf

        <!-- Device ID -->
        <div class="mb-4">
            <label class="block text-sm font-semibold text-slate-700 mb-1">Device ID</label>
            <input
                type="text"
                name="device_id"
                value="{{ old('device_id') }}"
                placeholder="Misal: Aqualyze-Nila-001"
                class="form-control w-full p-2 border border-slate-300 rounded-md @error('device_id') border-red-500 @enderror"
                required>
            @error('device_id')
                <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Jenis Ikan -->
        <div class="mb-4">
            <label class="block text-sm font-semibold text-slate-700 mb-1">Jenis Ikan</label>
            <select
                name="jenis_ikan"
                class="form-control w-full p-2 border border-slate-300 rounded-md @error('jenis_ikan') border-red-500 @enderror"
                required>
                <option value="" disabled selected>-- Pilih Jenis Ikan --</option>
                <option value="Nila" {{ old('jenis_ikan') == 'Nila' ? 'selected' : '' }}>Nila</option>
                <option value="Lele" {{ old('jenis_ikan') == 'Lele' ? 'selected' : '' }}>Lele</option>
                <option value="Mas" {{ old('jenis_ikan') == 'Mas' ? 'selected' : '' }}>Mas</option>
                <option value="Patin" {{ old('jenis_ikan') == 'Patin' ? 'selected' : '' }}>Patin</option>
            </select>
            @error('jenis_ikan')
                <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Lokasi -->
        <div class="mb-5">
            <label class="block text-sm font-semibold text-slate-700 mb-1">Lokasi</label>
            <input
                type="text"
                name="lokasi"
                value="{{ old('lokasi') }}"
                placeholder="Misal: Kolam Nila A"
                class="form-control w-full p-2 border border-slate-300 rounded-md @error('lokasi') border-red-500 @enderror"
                required>
            @error('lokasi')
                <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="aq-btn-primary px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Simpan
            </button>
            <a href="{{ route('devices.index') }}" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-md hover:bg-slate-200">
                Batal
            </a>
        </div>
    </form>
</div>

@endsection