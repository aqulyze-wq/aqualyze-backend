@extends('layouts.app')

@section('content')

{{-- Page Header --}}
<div class="aq-page-header" style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
    
    <div class="aq-card mb-4">

        <form method="GET">

            <div class="row">

                <div class="col-md-4">

                    <label class="form-label fw-bold">

                        Device

                    </label>

                    <select
                        class="form-select"
                        name="device"
                        onchange="this.form.submit()">

                        <option value="">

                            Semua Device

                        </option>

                        @foreach($devices as $device)

                            <option
                                value="{{ $device->device_id }}"
                                {{ request('device')==$device->device_id?'selected':'' }}>

                                {{ $device->nama_device }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

        </form>

    </div>

    <div>
        <h1>Dashboard</h1>
        <p>Overview of water quality parameters — live sensor data.</p>
    </div>
    <div style="display:flex;align-items:center;gap:0.75rem;">
        <span class="aq-live-dot">Auto-refresh every 5s</span>
    </div>
</div>

{{-- ── Stat Cards ── --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem;margin-bottom:1.5rem;">

    {{-- Suhu --}}
    <div class="aq-stat-card">
        <div style="display:flex;align-items:center;justify-content:space-between;">
            <span class="aq-stat-label">Suhu Air</span>
            <div class="aq-stat-icon" style="background:#EFF6FF;color:#2563EB;">
                <i class="bi bi-thermometer-half"></i>
            </div>
        </div>
        <div>
            <div class="aq-stat-value" style="color:#2563EB;">
                {{ $latest->suhu }}<span class="aq-stat-unit">°C</span>
            </div>
        </div>
        <div style="display:flex;align-items:center;justify-content:space-between;">
            <span class="aq-badge {{ $latest->status_suhu === 'Normal' ? 'aq-badge-success' : 'aq-badge-warning' }}">
                <i class="bi bi-{{ $latest->status_suhu === 'Normal' ? 'check-circle-fill' : 'exclamation-triangle-fill' }}"></i>
                {{ $latest->status_suhu }}
            </span>
            <span class="aq-stat-footer">Ideal: 25 – 30°C</span>
        </div>
    </div>

    {{-- pH --}}
    <div class="aq-stat-card">
        <div style="display:flex;align-items:center;justify-content:space-between;">
            <span class="aq-stat-label">pH Air</span>
            <div class="aq-stat-icon" style="background:#F5F3FF;color:#7C3AED;">
                <i class="bi bi-droplet-half"></i>
            </div>
        </div>
        <div>
            <div class="aq-stat-value" style="color:#7C3AED;">
                {{ $latest->ph }}<span class="aq-stat-unit">pH</span>
            </div>
        </div>
        <div style="display:flex;align-items:center;justify-content:space-between;">
            <span class="aq-badge {{ $latest->status_ph === 'Normal' ? 'aq-badge-success' : 'aq-badge-warning' }}">
                <i class="bi bi-{{ $latest->status_ph === 'Normal' ? 'check-circle-fill' : 'exclamation-triangle-fill' }}"></i>
                {{ $latest->status_ph }}
            </span>
            <span class="aq-stat-footer">Ideal: 6.5 – 8.0</span>
        </div>
    </div>

    {{-- Kekeruhan --}}
    <div class="aq-stat-card">
        <div style="display:flex;align-items:center;justify-content:space-between;">
            <span class="aq-stat-label">Kekeruhan</span>
            <div class="aq-stat-icon" style="background:#ECFEFF;color:#0891B2;">
                <i class="bi bi-water"></i>
            </div>
        </div>
        <div>
            <div class="aq-stat-value" style="color:#0891B2;">
                {{ $latest->kekeruhan }}<span class="aq-stat-unit">NTU</span>
            </div>
        </div>
        <div style="display:flex;align-items:center;justify-content:space-between;">
            <span class="aq-badge {{ $latest->status_kekeruhan === 'Normal' ? 'aq-badge-success' : 'aq-badge-warning' }}">
                <i class="bi bi-{{ $latest->status_kekeruhan === 'Normal' ? 'check-circle-fill' : 'exclamation-triangle-fill' }}"></i>
                {{ $latest->status_kekeruhan }}
            </span>
            <span class="aq-stat-footer">Ideal: 0 - 30 NTU</span>
        </div>
    </div>


    {{-- Total Data --}}
    <div class="aq-stat-card">
        <div style="display:flex;align-items:center;justify-content:space-between;">
            <span class="aq-stat-label">Total Data</span>
            <div class="aq-stat-icon" style="background:#EFF6FF;color:#2563EB;">
                <i class="bi bi-database-fill"></i>
            </div>
        </div>
        <div>
            <div class="aq-stat-value" style="color:#0F172A;">
                {{ number_format($totalData) }}
            </div>
        </div>
        <div>
            <span class="aq-stat-footer">
                <i class="bi bi-clock"></i>
                {{ $latest->created_at->format('d M Y, H:i') }}
            </span>
        </div>
    </div>

</div>

{{-- ── Bottom Row: Live Summary + Chart ── --}}
<div style="display:grid;grid-template-columns:1fr 2fr;gap:1rem;align-items:start;">

    {{-- Live Monitoring Summary --}}
    <div class="aq-card" style="height:100%;">
        <div class="aq-card-header">
            <span class="aq-card-title">
                <i class="bi bi-broadcast" style="color:var(--aq-primary);margin-right:0.375rem;"></i>
                Live Readings
            </span>
            <span class="aq-badge aq-badge-live">
                <i class="bi bi-circle-fill" style="font-size:0.45rem;"></i>
                Live
            </span>
        </div>
        <div class="aq-card-body" style="display:flex;flex-direction:column;gap:1rem;">

            {{-- Suhu --}}
            <div style="background:var(--aq-surface);border:1px solid var(--aq-border);border-radius:var(--aq-radius-sm);padding:1rem;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.75rem;">
                    <div style="display:flex;align-items:center;gap:0.5rem;">
                        <i class="bi bi-thermometer-half" style="color:#2563EB;font-size:1rem;"></i>
                        <span style="font-size:0.75rem;font-weight:600;color:var(--aq-text-secondary);text-transform:uppercase;letter-spacing:0.05em;">Suhu Air</span>
                    </div>
                    @php
                        $statusClass = match($latest->status_suhu){
                            'Normal'  => 'aq-badge-success',
                            'Warning' => 'aq-badge-warning',
                            'Bahaya'  => 'aq-badge-danger',
                            default   => 'aq-badge-warning'
                        };
                    @endphp
                    <span class="aq-badge {{ $statusClass }}">
                        {{ $latest->status_suhu }}
                    </span>
                </div>
                <div style="font-size:1.875rem;font-weight:800;color:#2563EB;letter-spacing:-0.03em;line-height:1;">
                    {{ $latest->suhu }}<span style="font-size:1rem;font-weight:500;color:var(--aq-text-secondary);margin-left:2px;">°C</span>
                </div>
                {{-- Progress bar --}}
                <div style="margin-top:0.75rem;background:#E2E8F0;border-radius:99px;height:4px;overflow:hidden;">
                    <div style="height:100%;border-radius:99px;background:#2563EB;width:{{ min(100, max(0, ($latest->suhu / 40) * 100)) }}%;transition:width 0.5s;"></div>
                </div>
            </div>

            {{-- pH --}}
            <div style="background:var(--aq-surface);border:1px solid var(--aq-border);border-radius:var(--aq-radius-sm);padding:1rem;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.75rem;">
                    <div style="display:flex;align-items:center;gap:0.5rem;">
                        <i class="bi bi-droplet-half" style="color:#7C3AED;font-size:1rem;"></i>
                        <span style="font-size:0.75rem;font-weight:600;color:var(--aq-text-secondary);text-transform:uppercase;letter-spacing:0.05em;">pH Air</span>
                    </div>
                    @php
                        $statusClass = match($latest->status_ph){
                            'Normal'  => 'aq-badge-success',
                            'Warning' => 'aq-badge-warning',
                            'Bahaya'  => 'aq-badge-danger',
                            default   => 'aq-badge-warning'
                        };
                        @endphp
                <span class="aq-badge {{ $statusClass }}">
                    {{ $latest->status_ph }}
                </span>
                </div>
                <div style="font-size:1.875rem;font-weight:800;color:#7C3AED;letter-spacing:-0.03em;line-height:1;">
                    {{ $latest->ph }}<span style="font-size:1rem;font-weight:500;color:var(--aq-text-secondary);margin-left:2px;">pH</span>
                </div>
                <div style="margin-top:0.75rem;background:#E2E8F0;border-radius:99px;height:4px;overflow:hidden;">
                    <div style="height:100%;border-radius:99px;background:#7C3AED;width:{{ min(100, max(0, ($latest->ph / 14) * 100)) }}%;transition:width 0.5s;"></div>
                </div>
            </div>

            {{-- Kekeruhan --}}
            <div style="background:var(--aq-surface);border:1px solid var(--aq-border);border-radius:var(--aq-radius-sm);padding:1rem;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.75rem;">
                    <div style="display:flex;align-items:center;gap:0.5rem;">
                        <i class="bi bi-water" style="color:#0891B2;font-size:1rem;"></i>
                        <span style="font-size:0.75rem;font-weight:600;color:var(--aq-text-secondary);text-transform:uppercase;letter-spacing:0.05em;">Kekeruhan</span>
                    </div>
                    @php
                    $statusClass = match($latest->status_kekeruhan){
                        'Normal'  => 'aq-badge-success',
                        'Warning' => 'aq-badge-warning',
                        'Bahaya'  => 'aq-badge-danger',
                        default   => 'aq-badge-warning'
                    };
                    @endphp
                    <span class="aq-badge {{ $statusClass }}">
                        {{ $latest->status_kekeruhan }}
                    </span>
                </div>
                <div style="font-size:1.875rem;font-weight:800;color:#0891B2;letter-spacing:-0.03em;line-height:1;">
                    {{ $latest->kekeruhan }}<span style="font-size:1rem;font-weight:500;color:var(--aq-text-secondary);margin-left:2px;">NTU</span>
                </div>
                <div style="margin-top:0.75rem;background:#E2E8F0;border-radius:99px;height:4px;overflow:hidden;">
                    <div style="height:100%;border-radius:99px;background:#0891B2;width:{{ min(100, max(0, ($latest->kekeruhan / 100) * 100)) }}%;transition:width 0.5s;"></div>
                </div>
            </div>

        </div>
    </div>

    {{-- Trend Chart --}}
    <div class="aq-card">
        <div class="aq-card-header">
            <span class="aq-card-title">
                <i class="bi bi-graph-up" style="color:var(--aq-primary);margin-right:0.375rem;"></i>
                Sensor Trend
            </span>
            <span style="font-size:0.75rem;color:var(--aq-text-muted);">Last 20 readings</span>
        </div>
        <div class="aq-card-body">
            <div style="display:flex;align-items:center;gap:1.25rem;margin-bottom:1rem;flex-wrap:wrap;">
                <div style="display:flex;align-items:center;gap:0.375rem;font-size:0.75rem;color:var(--aq-text-secondary);">
                    <span style="display:inline-block;width:20px;height:3px;border-radius:2px;background:#2563EB;"></span>
                    Suhu (°C)
                </div>
                <div style="display:flex;align-items:center;gap:0.375rem;font-size:0.75rem;color:var(--aq-text-secondary);">
                    <span style="display:inline-block;width:20px;height:3px;border-radius:2px;background:#7C3AED;"></span>
                    pH
                </div>
                <div style="display:flex;align-items:center;gap:0.375rem;font-size:0.75rem;color:var(--aq-text-secondary);">
                    <span style="display:inline-block;width:20px;height:3px;border-radius:2px;background:#0891B2;"></span>
                    Kekeruhan (NTU)
                </div>
            </div>
            <div class="aq-chart-container">
                <canvas id="sensorChart"></canvas>
            </div>
        </div>
    </div>

</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels   = @json($history->pluck('created_at')->map(fn($d) => \Carbon\Carbon::parse($d)->format('H:i')));
    const suhuData = @json($history->pluck('suhu'));
    const phData   = @json($history->pluck('ph'));
    const ntuData  = @json($history->pluck('kekeruhan'));

    Chart.defaults.font.family = "'Inter', ui-sans-serif, system-ui, sans-serif";
    Chart.defaults.font.size   = 12;
    Chart.defaults.color       = '#64748B';

    new Chart(document.getElementById('sensorChart'), {
        type: 'line',
        data: {
            labels,
            datasets: [
                {
                    label: 'Suhu (°C)',
                    data: suhuData,
                    borderColor: '#2563EB',
                    backgroundColor: 'rgba(37,99,235,0.08)',
                    borderWidth: 2,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    pointBackgroundColor: '#2563EB',
                    fill: true,
                    tension: 0.4,
                },
                {
                    label: 'pH',
                    data: phData,
                    borderColor: '#7C3AED',
                    backgroundColor: 'rgba(124,58,237,0.06)',
                    borderWidth: 2,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    pointBackgroundColor: '#7C3AED',
                    fill: true,
                    tension: 0.4,
                },
                {
                    label: 'Kekeruhan (NTU)',
                    data: ntuData,
                    borderColor: '#0891B2',
                    backgroundColor: 'rgba(8,145,178,0.06)',
                    borderWidth: 2,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    pointBackgroundColor: '#0891B2',
                    fill: true,
                    tension: 0.4,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0F172A',
                    titleColor: '#94A3B8',
                    bodyColor: '#F8FAFC',
                    padding: 12,
                    cornerRadius: 8,
                    borderColor: '#1E293B',
                    borderWidth: 1,
                },
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: { maxTicksLimit: 8 },
                },
                y: {
                    grid: { color: '#F1F5F9', drawBorder: false },
                    border: { display: false, dash: [4, 4] },
                },
            },
        },
    });
</script>

{{-- Auto-refresh --}}
<script>
    setTimeout(function () { location.reload(); }, 5000);
</script>

@endsection
