@extends('layouts.app')

@section('content')


<div class="aq-card-header">

    <div>

        <div class="aq-card-title">

            <i class="bi bi-database-fill me-2 text-primary"></i>

            Raw Data Monitoring

        </div>

        <div class="aq-card-desc">

            Monitor all incoming sensor readings from every connected device.

        </div>

    </div>

</div>

<div class="aq-card">
    
    <div class="aq-card-body">
        <form method="GET" class="row g-3 align-items-end mb-5">

            <!-- Search -->
            <div class="col-lg-6 mb-4">

                <label class="form-label fw-semibold text-secondary">
                    Cari Data
                </label>

                <div class="input-group aq-search">

                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>

                    <input
                        type="search"
                        name="search"
                        class="form-control aq-input"
                        value="{{ old('search', $search) }}"
                        placeholder="Cari device, suhu, pH, kekeruhan..."
                    >

                </div>

            </div>

            <!-- Sort -->

            <div class="col-lg-3 mb-4">

                <label class="form-label fw-semibold text-secondary">
                    Urutkan
                </label>

                <select
                    name="direction"
                    class="form-select aq-select"

                    <option value="desc"
                        {{ $direction == 'desc' ? 'selected' : '' }}>
                        Terbaru
                    </option>

                    <option value="asc"
                        {{ $direction == 'asc' ? 'selected' : '' }}>
                        Terlama
                    </option>

                </select>

            </div>

            <!-- Button -->

            <div class="col-lg-3 d-grid">

                <button
                    type="submit"
                    class="btn btn-primary aq-btn">

                    <i class="bi bi-funnel me-2"></i>

                    Terapkan

                </button>

            </div>
        </form>
<div class="aq-page-header">
    <div>
        <h2 class="aq-page-title">Raw Data</h2>
        <p class="aq-page-subtitle">Filtered sensor readings received from ESP32 devices.</p>
    </div>
</div>

<div class="aq-card">
    <div class="aq-card-header">
        <div>
            <span class="aq-card-title">Raw Data</span>
            <div class="text-muted" style="font-size:0.8125rem; margin-top: 4px;">Search and sort sensor readings in a single view.</div>
        </div>
    </div>

    <div class="aq-card-body">
        <form method="GET" class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
            <div class="d-flex flex-column flex-lg-row align-items-lg-end gap-3">
                <div class="form-group mb-0" style="min-width:320px; max-width:380px; width:100%;">
                    <label class="form-label mb-1">Search</label>
                    <div class="input-group" style="height:44px;">
                        <span class="input-group-text bg-white border-end-0" style="height:44px;">
                            <i class="bi bi-search"></i>
                        </span>
                        <input
                            type="search"
                            name="search"
                            class="form-control border-start-0"
                            style="height:44px;"
                            value="{{ old('search', $search) }}"
                            placeholder="Search device, temperature, pH, turbidity..."
                            aria-label="Search"
                        >
                    </div>
                </div>

                <div class="form-group mb-0" style="min-width:180px; max-width:180px; width:100%;">
                    <label class="form-label mb-1">Sort By</label>
                    <select
                        name="direction"
                        class="form-select"
                        style="height:44px;"
                    >
                        <option value="desc" {{ $direction === 'desc' ? 'selected' : '' }}>Latest First</option>
                        <option value="asc" {{ $direction === 'asc' ? 'selected' : '' }}>Oldest First</option>
                    </select>
                </div>
            </div>

            <div class="text-muted text-end" style="min-width: 180px;">
                Showing {{ $sensorData->count() }} of {{ $sensorData->total() }} records
            </div>
        </form>

        <div class="aq-table-wrap">
            <table class="aq-table">
                <thead>
                    <tr>

                        <th class="text-start">

                            <i class="bi bi-cpu me-2"></i>

                            Device

                        </th>
                        <th class="text-center">
                            <i class="bi bi-clock me-2"></i>
                            Timestamp
                        </th>
                        <th class="text-center">
                            <i class="bi bi-thermometer me-2"></i>
                            Temperature (°C)
                        </th>
                        <th class="text-center">Temperature Status</th>
                        <th class="text-center">
                            <i class="bi bi-droplet me-2"></i>
                            pH
                        </th>
                        <th class="text-center">pH Status</th>
                        <th class="text-center">
                            <i class="bi bi-water me-2"></i>
                            Turbidity (NTU)
                        </th>
                        <th class="text-start">Device</th>
                        <th class="text-center">Timestamp</th>
                        <th class="text-center">Temperature (°C)</th>
                        <th class="text-center">Temperature Status</th>
                        <th class="text-center">pH</th>
                        <th class="text-center">pH Status</th>
                        <th class="text-center">Turbidity (NTU)</th>
                        <th class="text-center">Turbidity Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sensorData as $item)
                        <tr>

                            <td>

                                <div class="d-flex align-items-center gap-2">

                                    <div
                                        class="rounded-circle bg-primary"
                                        style="width:10px;height:10px;">
                                    </div>

                                    <span class="fw-semibold">

                                        {{ optional($item->device)->nama_device ?? 'Unknown Device' }}

                                    </span>

                                </div>

                            </td>
                            <td class="text-center">
                                <div class="aq-date">
                                    {{ $item->created_at->format('d M Y') }}
                                </div>

                                <div class="aq-time">
                                    {{ $item->created_at->format('H:i:s') }}
                                </div>
                            </td>

                            <td class="text-center aq-value-temp">{{ $item->suhu }}°C</td>

                            <td class="text-center">
                                <span class="aq-badge {{ $item->status_suhu === 'Normal'
                                    ? 'aq-badge-success'
                                    : ($item->status_suhu === 'Warning'
                                    ? 'aq-badge-warning'
                                    : 'aq-badge-danger') }}">

                                        <i class="bi bi-circle-fill"
                                        style="font-size:7px;"></i>

                                        {{ $item->status_suhu }}

                                    </span>
                            </td>
                            
                           <td class="text-center aq-value-ph">{{ $item->ph }}</td>

                            <td class="text-center">
                                <span class="aq-badge {{ $item->status_ph === 'Normal'
                                 ? 'aq-badge-success' : ($item->status_ph === 'Warning' 
                                 ? 'aq-badge-warning' 
                                 : 'aq-badge-danger') }}">

                                    <i class="bi bi-circle-fill"
                                    style="font-size:7px;"></i>
                                    {{ $item->status_ph }}
                                </span>
                            </td>
                            <td class="text-center aq-value-ntu">{{ $item->kekeruhan }} NTU</td>
                            <td>{{ optional($item->device)->nama_device ?? 'Unknown Device' }}</td>
                            <td class="text-center">
                                <div style="font-weight:500;color:var(--aq-text-primary);font-size:0.8125rem;">
                                    {{ $item->created_at->format('d M Y') }}
                                </div>
                                <div class="text-muted" style="font-size:0.75rem;margin-top:1px;">
                                    {{ $item->created_at->format('H:i:s') }}
                                </div>
                            </td>
                            <td class="text-center" style="font-weight:700;color:#2563EB;">{{ $item->suhu }}°C</td>
                            <td class="text-center">
                                <span class="aq-badge {{ $item->status_suhu === 'Normal' ? 'aq-badge-success' : ($item->status_suhu === 'Warning' ? 'aq-badge-warning' : 'aq-badge-danger') }}">
                                    {{ $item->status_suhu }}
                                </span>
                            </td>
                            <td class="text-center" style="font-weight:700;color:#7C3AED;">{{ $item->ph }}</td>
                            <td class="text-center">
                                <span class="aq-badge {{ $item->status_ph === 'Normal' ? 'aq-badge-success' : ($item->status_ph === 'Warning' ? 'aq-badge-warning' : 'aq-badge-danger') }}">
                                    {{ $item->status_ph }}
                                </span>
                            </td>
                            <td class="text-center" style="font-weight:700;color:#0891B2;">{{ $item->kekeruhan }} NTU</td>
                            <td class="text-center">
                                @php
                                    $turbidityBadge = 'aq-badge-info';
                                    if ($item->status_kekeruhan === 'Very Clear' || $item->status_kekeruhan === 'Sangat Jernih') {
                                        $turbidityBadge = 'aq-badge-success';
                                    } elseif ($item->status_kekeruhan === 'Clear' || $item->status_kekeruhan === 'Jernih') {
                                        $turbidityBadge = 'aq-badge-info';
                                    } elseif ($item->status_kekeruhan === 'Turbid' || $item->status_kekeruhan === 'Keruh') {
                                        $turbidityBadge = 'aq-badge-warning';
                                    } elseif ($item->status_kekeruhan === 'Very Turbid' || $item->status_kekeruhan === 'Sangat Keruh') {
                                        $turbidityBadge = 'aq-badge-danger';
                                    }
                                @endphp
                                <span class="aq-badge {{ $turbidityBadge }}">


                                <i class="bi bi-circle-fill"
                                style="font-size:7px;"></i>

                                    {{ $item->status_kekeruhan }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>


                        <td colspan="8" class="text-center py-5">

                            <i class="bi bi-database-x"
                            style="font-size:40px;color:#9ca3af;"></i>

                            <br><br>

                            Tidak ada data yang ditemukan.

                        </td>

                            <td colspan="8" class="text-center">No matching records found.</td>

                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-4">
            {{ $sensorData->links() }}
        </div>
    </div>
</div>

@endsection
