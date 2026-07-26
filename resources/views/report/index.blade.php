@extends('layouts.app')

@section('content')

<!-- HEADER HALAMAN + TOMBOL EXPORT -->
<div class="aq-page-header">
    <div>
        <h1 class="aq-page-title">Report Monitoring</h1>
        <p class="aq-page-subtitle">
            Ringkasan & laporan riwayat monitoring kualitas air Aqualyze.
        </p>
    </div>

    <!-- Group Tombol Export (Excel, CSV, PDF) -->
    <div class="d-flex align-items-center gap-2 flex-wrap">
        {{-- Export Excel --}}
        <a href="{{ route('report.export', array_merge(request()->all(), ['format' => 'excel'])) }}" class="aq-btn" style="background: #10b981; color: #ffffff; border-radius: 12px; height: 42px; padding: 0 16px; font-size: 13px; font-weight: 600;">
            <i class="bi bi-file-earmark-excel-fill"></i> Excel
        </a>

        {{-- Export CSV --}}
        <a href="{{ route('report.export', array_merge(request()->all(), ['format' => 'csv'])) }}" class="aq-btn" style="background: #0284c7; color: #ffffff; border-radius: 12px; height: 42px; padding: 0 16px; font-size: 13px; font-weight: 600;">
            <i class="bi bi-file-earmark-spreadsheet-fill"></i> CSV
        </a>

        {{-- Export PDF --}}
        <a href="{{ route('report.export', array_merge(request()->all(), ['format' => 'pdf'])) }}" class="aq-btn" style="background: #ef4444; color: #ffffff; border-radius: 12px; height: 42px; padding: 0 16px; font-size: 13px; font-weight: 600;" target="_blank">
            <i class="bi bi-file-earmark-pdf-fill"></i> PDF
        </a>
    </div>
</div>

<!-- STATISTIK RINGKASAN DATA -->
<div class="aq-device-stats">
    <div class="aq-device-stat">
        <div class="aq-device-icon blue">
            <i class="bi bi-geo-alt-fill"></i>
        </div>
        <div>
            <span>Total Lokasi</span>
            <h3>{{ $totalDevice }}</h3>
        </div>
    </div>

    <div class="aq-device-stat">
        <div class="aq-device-icon green">
            <i class="bi bi-wifi"></i>
        </div>
        <div>
            <span>Lokasi Online</span>
            <h3>{{ $online }}</h3>
        </div>
    </div>

    <div class="aq-device-stat">
        <div class="aq-device-icon red">
            <i class="bi bi-wifi-off"></i>
        </div>
        <div>
            <span>Lokasi Offline</span>
            <h3>{{ $offline }}</h3>
        </div>
    </div>

    <div class="aq-device-stat">
        <div class="aq-device-icon orange">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
        <div>
            <span>Warning Hari Ini</span>
            <h3>{{ $warning }}</h3>
        </div>
    </div>
</div>

<!-- CONTAINER UTAMA -->
<div class="aq-card">

    <!-- FORM FILTER TANGGAL & LOKASI -->
    <form method="GET" action="{{ url()->current() }}" class="mb-4">
        <div class="row g-3 align-items-end">
            
            <!-- Tanggal Awal -->
            <div class="col-md-3">
                <label style="font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 6px; display: block;">
                    <i class="bi bi-calendar-event me-1"></i> Tanggal Awal
                </label>
                <input 
                    type="date" 
                    name="start" 
                    class="aq-input" 
                    style="border-radius: 12px !important; height: 44px !important; font-size: 13px !important; border: 1px solid #e2e8f0 !important;" 
                    value="{{ request('start') }}"
                >
            </div>

            <!-- Tanggal Akhir -->
            <div class="col-md-3">
                <label style="font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 6px; display: block;">
                    <i class="bi bi-calendar-check me-1"></i> Tanggal Akhir
                </label>
                <input 
                    type="date" 
                    name="end" 
                    class="aq-input" 
                    style="border-radius: 12px !important; height: 44px !important; font-size: 13px !important; border: 1px solid #e2e8f0 !important;" 
                    value="{{ request('end') }}"
                >
            </div>

            <!-- Select Lokasi -->
            <div class="col-md-3">
                <label style="font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 6px; display: block;">
                    <i class="bi bi-geo-alt-fill me-1"></i> Lokasi
                </label>
                <select 
                    name="device" 
                    class="aq-input aq-select" 
                    style="border-radius: 12px !important; height: 44px !important; font-size: 13px !important; border: 1px solid #e2e8f0 !important; cursor: pointer !important;"
                >
                    <option value="">Semua Lokasi</option>
                    @foreach($devices as $device)
                        <option value="{{ $device->id }}" {{ request('device') == $device->id ? 'selected' : '' }}>
                            {{ $device->lokasi ?? 'Lokasi #'.$device->id }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tombol Action -->
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="aq-btn aq-btn-primary w-100" style="height: 44px; border-radius: 12px; font-size: 13px;">
                    <i class="bi bi-funnel-fill"></i> Filter Data
                </button>

                @if(request('start') || request('end') || request('device'))
                    <a href="{{ url()->current() }}" class="aq-btn" style="height: 44px; border-radius: 12px; font-size: 13px; background: #f1f5f9; color: #ef4444; border: 1px solid #cbd5e1; white-space: nowrap;">
                        <i class="bi bi-x-circle"></i>
                    </a>
                @endif
            </div>

        </div>
    </form>

    <!-- TABEL DATA REPORT -->
    <div class="aq-table-wrap">
        <table class="aq-table">
            <thead>
                <tr>
                    <th class="text-center"><i class="bi bi-clock me-1"></i> WAKTU</th>
                    <th><i class="bi bi-geo-alt-fill me-1"></i> LOKASI</th>
                    <th class="text-center"><i class="bi bi-thermometer me-1"></i> SUHU (°C)</th>
                    <th class="text-center"><i class="bi bi-droplet me-1"></i> PH</th>
                    <th class="text-center"><i class="bi bi-water me-1"></i> KEKERUHAN (NTU)</th>
                    <th class="text-center">STATUS KESELURUHAN</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                    <tr>
                        <!-- Timestamp -->
                        <td class="text-center">
                            <div class="aq-date">{{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}</div>
                            <div class="aq-time">{{ $item->created_at ? $item->created_at->format('H:i') : '-' }}</div>
                        </td>

                        <!-- Lokasi -->
                        <td>
                            <strong>{{ optional($item->device)->lokasi ?? 'Lokasi #' . ($item->device_id ?? '-') }}</strong>
                        </td>

                        <!-- Suhu -->
                        <td class="text-center aq-value-temp">
                            {{ $item->suhu }}°C
                        </td>

                        <!-- pH -->
                        <td class="text-center aq-value-ph">
                            {{ $item->ph }}
                        </td>

                        <!-- Kekeruhan -->
                        <td class="text-center aq-value-ntu">
                            {{ $item->kekeruhan }} NTU
                        </td>

                        <!-- Status -->
                        <td class="text-center">
                            @if(
                                strtolower($item->status_suhu ?? '') === 'warning' ||
                                strtolower($item->status_ph ?? '') === 'warning' ||
                                strtolower($item->status_kekeruhan ?? '') === 'warning'
                            )
                                <span class="aq-badge aq-badge-warning">
                                    <span class="aq-dot"></span> Warning
                                </span>
                            @elseif(
                                strtolower($item->status_suhu ?? '') === 'danger' ||
                                strtolower($item->status_ph ?? '') === 'danger' ||
                                strtolower($item->status_kekeruhan ?? '') === 'danger'
                            )
                                <span class="aq-badge aq-badge-danger">
                                    <span class="aq-dot"></span> Bahaya
                                </span>
                            @else
                                <span class="aq-badge aq-badge-success">
                                    <span class="aq-dot"></span> Normal
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="aq-empty">
                                <i class="bi bi-file-earmark-bar-graph"></i>
                                <p>Tidak ada data laporan pada rentang waktu ini.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="mt-3">
        {{ $data->withQueryString()->links() }}
    </div>

</div>

@endsection