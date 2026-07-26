@extends('layouts.app')

@section('content')

<!-- PAGE HEADER -->
<div class="aq-page-header flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <div>
        <h2 class="aq-page-title text-2xl font-bold text-slate-800">Manajemen Perangkat</h2>
        <p class="aq-page-subtitle text-sm text-slate-500 mt-1">
            Kelola seluruh perangkat monitoring Aqualyze.
        </p>
    </div>

    <a href="{{ route('devices.create') }}" class="aq-btn-primary px-4 py-2.5 rounded-lg text-white font-medium flex items-center gap-2 transition-all">
        <i class="bi bi-plus-circle text-lg"></i>
        <span>Tambah Perangkat</span>
    </a>
</div>

<!-- STATS CARDS -->
<div class="aq-device-stats grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <!-- Total Device -->
    <div class="aq-device-stat bg-white p-4 rounded-xl shadow-sm border border-slate-100 flex items-center gap-4">
        <div class="aq-device-icon blue w-12 h-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-hdd-network"></i>
        </div>
        <div>
            <span class="text-xs font-medium text-slate-500 block">Total Device</span>
            <h3 class="text-2xl font-bold text-slate-800">{{ $totalDevices ?? $devices->count() }}</h3>
        </div>
    </div>

    <!-- Online -->
    <div class="aq-device-stat bg-white p-4 rounded-xl shadow-sm border border-slate-100 flex items-center gap-4">
        <div class="aq-device-icon green w-12 h-12 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-wifi"></i>
        </div>
        <div>
            <span class="text-xs font-medium text-slate-500 block">Online</span>
            <h3 class="text-2xl font-bold text-slate-800">{{ $onlineCount ?? $devices->where('status','online')->count() }}</h3>
        </div>
    </div>

    <!-- Offline -->
    <div class="aq-device-stat bg-white p-4 rounded-xl shadow-sm border border-slate-100 flex items-center gap-4">
        <div class="aq-device-icon red w-12 h-12 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-wifi-off"></i>
        </div>
        <div>
            <span class="text-xs font-medium text-slate-500 block">Offline</span>
            <h3 class="text-2xl font-bold text-slate-800">{{ $offlineCount ?? $devices->where('status','offline')->count() }}</h3>
        </div>
    </div>
</div>

<!-- MAIN TABLE CARD -->
<div class="aq-card bg-white p-6 rounded-xl shadow-sm border border-slate-100">

    <!-- FILTER & SEARCH FORM (FUNGSI FILTER AKTIF) -->
    <form method="GET" action="{{ route('devices.index') }}" class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4 mb-6">
        
        <div class="flex flex-wrap items-center gap-3 flex-1">
            <!-- Input Search -->
            <div class="relative min-w-[260px] flex-1 sm:flex-initial">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="bi bi-search"></i>
                </span>
                <input 
                    type="search" 
                    name="search" 
                    class="form-control aq-input pl-9 pr-3 py-2 w-full text-xs border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none" 
                    placeholder="Cari device, lokasi, jenis ikan..."
                    value="{{ request('search') }}"
                    onchange="this.form.submit()"
                >
            </div>

            <!-- Filter Status Dropdown -->
            <div class="w-full sm:w-44">
                <select name="status" class="form-select aq-select py-2 px-3 w-full text-xs border border-slate-200 rounded-lg text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="online" {{ request('status') === 'online' ? 'selected' : '' }}>Online</option>
                    <option value="offline" {{ request('status') === 'offline' ? 'selected' : '' }}>Offline</option>
                </select>
            </div>

            <!-- Tombol Reset Filter jika sedang aktif filter -->
            @if(request('search') || request('status'))
                <a href="{{ route('devices.index') }}" class="text-xs text-slate-500 hover:text-rose-500 flex items-center gap-1">
                    <i class="bi bi-x-circle"></i> Reset Filter
                </a>
            @endif
        </div>

        <button type="submit" class="hidden sm:inline-block px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition-colors">
            Cari
        </button>
    </form>

    <!-- TABLE DATA -->
    <div class="aq-table-wrap overflow-x-auto">
        <table class="aq-table w-full text-xs text-left">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold">
                    <th class="p-3 rounded-l-lg">Device ID</th>
                    <th class="p-3">Jenis Ikan</th>
                    <th class="p-3">Lokasi</th>
                    <th class="p-3 text-center">Status</th>
                    <th class="p-3 text-center">Last Seen</th>
                    <th class="p-3 text-center rounded-r-lg">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($devices as $device)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="p-3 font-semibold text-slate-800">
                            {{ $device->device_id }}
                        </td>
                        <td class="p-3 text-slate-600">
                            {{ $device->jenis_ikan ?? '-' }}
                        </td>
                        <td class="p-3 text-slate-600">
                            {{ $device->lokasi ?? '-' }}
                        </td>
                        <td class="p-3 text-center">
                            @if(strtolower($device->status) === 'online')
                                <span class="aq-badge aq-badge-success inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Online
                                </span>
                            @else
                                <span class="aq-badge aq-badge-danger inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-600 border border-rose-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    Offline
                                </span>
                            @endif
                        </td>
                        <td class="p-3 text-center text-slate-500">
                            {{ $device->last_seen ? \Carbon\Carbon::parse($device->last_seen)->format('d M Y H:i') : '-' }}
                        </td>
                        <td class="p-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('devices.edit', $device->id) }}" class="aq-btn-icon p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                    <i class="bi bi-pencil text-sm"></i>
                                </a>

                                <form action="{{ route('devices.destroy', $device->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="aq-btn-icon p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg transition-colors" onclick="return confirm('Yakin ingin menghapus perangkat ini?')" title="Hapus">
                                        <i class="bi bi-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-10 text-slate-400">
                            <i class="bi bi-hdd-rack text-4xl block mb-2 text-slate-300"></i>
                            Perangkat tidak ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection