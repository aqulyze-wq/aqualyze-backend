@extends('layouts.app')

@section('content')

<!-- HEADER HALAMAN -->
<div class="aq-page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <div>
        <h1 class="aq-page-title">Raw Data Monitoring</h1>
        <p class="aq-page-subtitle">
            Monitor dan filter seluruh data masuk dari perangkat ESP32.
        </p>
    </div>
    
    <!-- GRUP TOMBOL EXPORT (EXCEL, CSV, PDF) -->
    <div style="display: flex; gap: 8px;">
        <!-- Tombol Excel -->
        <a href="{{ route('raw-data.export-excel', request()->query()) }}" class="btn" style="background-color: #10b981; color: white; display: inline-flex; align-items: center; gap: 6px; border-radius: 12px; padding: 8px 16px; font-size: 13px; font-weight: 600; text-decoration: none;">
            <i class="bi bi-file-earmark-excel"></i> Excel
        </a>

        <!-- Tombol CSV -->
        <a href="{{ route('raw-data.export-csv', request()->query()) }}" class="btn" style="background-color: #0ea5e9; color: white; display: inline-flex; align-items: center; gap: 6px; border-radius: 12px; padding: 8px 16px; font-size: 13px; font-weight: 600; text-decoration: none;">
            <i class="bi bi-file-earmark-text"></i> CSV
        </a>

        <!-- Tombol PDF -->
        <a href="{{ route('raw-data.export-pdf', request()->query()) }}" target="_blank" class="btn" style="background-color: #ef4444; color: white; display: inline-flex; align-items: center; gap: 6px; border-radius: 12px; padding: 8px 16px; font-size: 13px; font-weight: 600; text-decoration: none;">
            <i class="bi bi-file-earmark-pdf"></i> PDF
        </a>
    </div>
</div>

<!-- CONTAINER UTAMA -->
<div class="aq-card">

    <!-- FORM FILTER & SEARCH -->
    <form method="GET" action="{{ url()->current() }}" style="display: flex !important; flex-direction: row !important; align-items: center !important; gap: 12px !important; margin-bottom: 1.5rem !important; flex-wrap: nowrap !important;">
        
        <!-- 1. Input Search -->
        <div style="position: relative; width: 320px; flex-shrink: 0;">
            <i class="bi bi-search" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 14px; pointer-events: none; z-index: 2;"></i>
            <input 
                type="search" 
                name="search" 
                class="aq-input" 
                style="padding-left: 42px !important; border-radius: 12px !important; height: 44px !important; font-size: 13px !important; border: 1px solid #e2e8f0 !important; color: #334155 !important; width: 100% !important; margin: 0 !important;" 
                placeholder="Cari device, lokasi, jenis ikan..." 
                value="{{ request('search') }}"
                onchange="this.form.submit()"
            >
        </div>

        <!-- 2. Dropdown Urutan -->
        <div style="width: 180px; flex-shrink: 0;">
            <select 
                name="direction" 
                class="aq-input aq-select" 
                style="border-radius: 12px !important; height: 44px !important; font-size: 13px !important; border: 1px solid #e2e8f0 !important; color: #334155 !important; width: 100% !important; cursor: pointer !important; margin: 0 !important;" 
                onchange="this.form.submit()"
            >
                <option value="desc" {{ request('direction', 'desc') === 'desc' ? 'selected' : '' }}>Terbaru (Latest)</option>
                <option value="asc" {{ request('direction') === 'asc' ? 'selected' : '' }}>Terlama (Oldest)</option>
            </select>
        </div>

        <!-- 3. Tombol Reset Filter (Jika Aktif) -->
        @if(request('search') || request('direction') === 'asc')
            <a href="{{ url()->current() }}" style="font-size: 13px; color: #ef4444; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; font-weight: 500; white-space: nowrap;">
                <i class="bi bi-x-circle"></i> Reset Filter
            </a>
        @endif

    </form>

    <!-- TABEL DATA -->
    <div class="aq-table-wrap">
        <table class="aq-table">
            <thead>
                <tr>
                    <th><i class="bi bi-geo-alt me-1"></i> LOKASI</th>
                    <th class="text-center"><i class="bi bi-clock me-1"></i> TIMESTAMP</th>
                    <th class="text-center"><i class="bi bi-thermometer me-1"></i> TEMPERATURE (°C)</th>
                    <th class="text-center">TEMPERATURE STATUS</th>
                    <th class="text-center"><i class="bi bi-droplet me-1"></i> PH</th>
                    <th class="text-center">PH STATUS</th>
                    <th class="text-center"><i class="bi bi-water me-1"></i> TURBIDITY (NTU)</th>
                    <th class="text-center">TURBIDITY STATUS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sensorData as $item)
                    <tr>
                        <!-- Lokasi Device -->
                        <td>
                            <strong>{{ optional($item->device)->lokasi ?? 'Lokasi Tidak Diketahui' }}</strong>
                        </td>

                        <!-- Waktu & Tanggal -->
                        <td class="text-center">
                            <div class="aq-date">{{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}</div>
                            <div class="aq-time">{{ $item->created_at ? $item->created_at->format('H:i:s') : '-' }}</div>
                        </td>

                        <!-- Angka Suhu -->
                        <td class="text-center aq-value-temp">
                            {{ $item->suhu }}°C
                        </td>

                        <!-- Badge Status Suhu -->
                        <td class="text-center">
                            @php
                                $sSuhu = strtolower($item->status_suhu ?? '');
                                $badgeClass = 'aq-badge-warning';
                                if (in_array($sSuhu, ['normal', 'good', 'baik'])) $badgeClass = 'aq-badge-success';
                                elseif (in_array($sSuhu, ['danger', 'bahaya', 'kritik'])) $badgeClass = 'aq-badge-danger';
                            @endphp
                            <span class="aq-badge {{ $badgeClass }}">
                                <span class="aq-dot"></span>
                                {{ ucfirst($item->status_suhu ?? 'Warning') }}
                            </span>
                        </td>

                        <!-- Angka pH -->
                        <td class="text-center aq-value-ph">
                            {{ $item->ph }}
                        </td>

                        <!-- Badge Status pH -->
                        <td class="text-center">
                            @php
                                $sPh = strtolower($item->status_ph ?? '');
                                $badgePhClass = 'aq-badge-warning';
                                if (in_array($sPh, ['normal', 'good', 'baik'])) $badgePhClass = 'aq-badge-success';
                                elseif (in_array($sPh, ['danger', 'bahaya', 'kritik'])) $badgePhClass = 'aq-badge-danger';
                            @endphp
                            <span class="aq-badge {{ $badgePhClass }}">
                                <span class="aq-dot"></span>
                                {{ ucfirst($item->status_ph ?? 'Warning') }}
                            </span>
                        </td>

                        <!-- Angka Kekeruhan -->
                        <td class="text-center aq-value-ntu">
                            {{ $item->kekeruhan }} NTU
                        </td>

                        <!-- Badge Status Kekeruhan -->
                        <td class="text-center">
                            @php
                                $sTur = strtolower($item->status_kekeruhan ?? '');
                                $badgeTurClass = 'aq-badge-info';
                                if (in_array($sTur, ['sangat jernih', 'normal', 'good', 'very clear', 'clear'])) $badgeTurClass = 'aq-badge-success';
                                elseif (in_array($sTur, ['keruh', 'warning', 'turbid'])) $badgeTurClass = 'aq-badge-warning';
                                elseif (in_array($sTur, ['sangat keruh', 'danger'])) $badgeTurClass = 'aq-badge-danger';
                            @endphp
                            <span class="aq-badge {{ $badgeTurClass }}">
                                <span class="aq-dot"></span>
                                {{ ucfirst($item->status_kekeruhan ?? 'Normal') }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="aq-empty">
                                <i class="bi bi-hdd-rack"></i>
                                <p>Tidak ada data sensor yang ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION DENGAN STYLING SESUAI GAMBAR -->
    @if ($sensorData->hasPages())
        <div style="display: flex; justify-content: flex-end; margin-top: 1.5rem;">
            <nav style="display: inline-flex; background-color: #1f2937; border-radius: 10px; padding: 4px; gap: 2px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                
                {{-- Previous Page Link --}}
                @if ($sensorData->onFirstPage())
                    <span style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; color: #4b5563; font-size: 14px; cursor: not-allowed;">
                        <i class="bi bi-chevron-left"></i>
                    </span>
                @else
                    <a href="{{ $sensorData->previousPageUrl() }}" style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; color: #9ca3af; text-decoration: none; font-size: 14px; transition: all 0.2s;" onmouseover="this.style.color='#ffffff'" onmouseout="this.style.color='#9ca3af'">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($sensorData->getUrlRange(1, $sensorData->lastPage()) as $page => $url)
                    @if ($page == $sensorData->currentPage())
                        <span style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; background-color: #374151; color: #60a5fa; font-weight: 600; font-size: 14px; border-radius: 6px;">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; color: #38bdf8; text-decoration: none; font-size: 14px; font-weight: 500; border-radius: 6px; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#374151'" onmouseout="this.style.backgroundColor='transparent'">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($sensorData->hasMorePages())
                    <a href="{{ $sensorData->nextPageUrl() }}" style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; color: #9ca3af; text-decoration: none; font-size: 14px; transition: all 0.2s;" onmouseover="this.style.color='#ffffff'" onmouseout="this.style.color='#9ca3af'">
                        <i class="bi bi-chevron-right"></i>
                    </a>
                @else
                    <span style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; color: #4b5563; font-size: 14px; cursor: not-allowed;">
                        <i class="bi bi-chevron-right"></i>
                    </span>
                @endif

            </nav>
        </div>
    @endif

</div>

@endsection