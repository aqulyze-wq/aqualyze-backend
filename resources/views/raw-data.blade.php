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
                >

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
