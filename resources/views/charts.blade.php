@extends('layouts.app')

@section('content')

{{-- Page Header --}}
<div class="aq-page-header" style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
    <div>
        <h1>Grafik Data Sensor</h1>
        <p>Visualisasi tren parameter kualitas air — 100 data terakhir.</p>
    </div>
    <span style="font-size:0.75rem;color:var(--aq-text-muted);display:flex;align-items:center;gap:0.375rem;">
        <i class="bi bi-calendar3"></i>
        {{ now()->format('d M Y') }}
    </span>
</div>

{{-- ── Summary Cards ── --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem;margin-bottom:1.5rem;">

    <div class="aq-stat-card">
        <div style="display:flex;align-items:center;justify-content:space-between;">
            <span class="aq-stat-label">Suhu Terkini</span>
            <div class="aq-stat-icon" style="background:#EFF6FF;color:#2563EB;">
                <i class="bi bi-thermometer-half"></i>
            </div>
        </div>
        <div class="aq-stat-value" style="color:#2563EB;">
            {{ $latest->suhu }}<span class="aq-stat-unit">°C</span>
        </div>
        <span class="aq-badge {{ $latest->status_suhu === 'Normal' ? 'aq-badge-success' : 'aq-badge-warning' }}">
            <i class="bi bi-{{ $latest->status_suhu === 'Normal' ? 'check-circle-fill' : 'exclamation-triangle-fill' }}"></i>
            {{ $latest->status_suhu }}
        </span>
    </div>

    <div class="aq-stat-card">
        <div style="display:flex;align-items:center;justify-content:space-between;">
            <span class="aq-stat-label">pH Terkini</span>
            <div class="aq-stat-icon" style="background:#F5F3FF;color:#7C3AED;">
                <i class="bi bi-droplet-half"></i>
            </div>
        </div>
        <div class="aq-stat-value" style="color:#7C3AED;">
            {{ $latest->ph }}<span class="aq-stat-unit">pH</span>
        </div>
        <span class="aq-badge {{ $latest->status_ph === 'Normal' ? 'aq-badge-success' : 'aq-badge-warning' }}">
            <i class="bi bi-{{ $latest->status_ph === 'Normal' ? 'check-circle-fill' : 'exclamation-triangle-fill' }}"></i>
            {{ $latest->status_ph }}
        </span>
    </div>

    <div class="aq-stat-card">
        <div style="display:flex;align-items:center;justify-content:space-between;">
            <span class="aq-stat-label">Kekeruhan Terkini</span>
            <div class="aq-stat-icon" style="background:#ECFEFF;color:#0891B2;">
                <i class="bi bi-water"></i>
            </div>
        </div>
        <div class="aq-stat-value" style="color:#0891B2;">
            {{ $latest->kekeruhan }}<span class="aq-stat-unit">NTU</span>
        </div>
        <span class="aq-badge {{ $latest->status_kekeruhan === 'Normal' ? 'aq-badge-success' : 'aq-badge-warning' }}">
            <i class="bi bi-{{ $latest->status_kekeruhan === 'Normal' ? 'check-circle-fill' : 'exclamation-triangle-fill' }}"></i>
            {{ $latest->status_kekeruhan }}
        </span>
    </div>

</div>

{{-- ── Charts ── --}}

{{-- Suhu Chart --}}
<div class="aq-card" style="margin-bottom:1rem;">
    <div class="aq-card-header">
        <div style="display:flex;align-items:center;gap:0.625rem;">
            <div style="width:36px;height:36px;border-radius:8px;background:#EFF6FF;display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-thermometer-half" style="color:#2563EB;font-size:1rem;"></i>
            </div>
            <div>
                <div class="aq-card-title">Grafik Suhu Air</div>
                <div style="font-size:0.75rem;color:var(--aq-text-muted);">Temperature (°C) over time</div>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:0.5rem;">
            <span style="display:inline-block;width:24px;height:3px;border-radius:2px;background:#2563EB;"></span>
            <span style="font-size:0.75rem;color:var(--aq-text-secondary);">Suhu °C</span>
        </div>
    </div>
    <div class="aq-card-body">
        <div class="aq-chart-container">
            <canvas id="tempChart"></canvas>
        </div>
    </div>
</div>

{{-- pH Chart --}}
<div class="aq-card" style="margin-bottom:1rem;">
    <div class="aq-card-header">
        <div style="display:flex;align-items:center;gap:0.625rem;">
            <div style="width:36px;height:36px;border-radius:8px;background:#F5F3FF;display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-droplet-half" style="color:#7C3AED;font-size:1rem;"></i>
            </div>
            <div>
                <div class="aq-card-title">Grafik pH Air</div>
                <div style="font-size:0.75rem;color:var(--aq-text-muted);">Acidity level over time</div>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:0.5rem;">
            <span style="display:inline-block;width:24px;height:3px;border-radius:2px;background:#7C3AED;"></span>
            <span style="font-size:0.75rem;color:var(--aq-text-secondary);">pH</span>
        </div>
    </div>
    <div class="aq-card-body">
        <div class="aq-chart-container">
            <canvas id="phChart"></canvas>
        </div>
    </div>
</div>

{{-- Kekeruhan Chart --}}
<div class="aq-card">
    <div class="aq-card-header">
        <div style="display:flex;align-items:center;gap:0.625rem;">
            <div style="width:36px;height:36px;border-radius:8px;background:#ECFEFF;display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-water" style="color:#0891B2;font-size:1rem;"></i>
            </div>
            <div>
                <div class="aq-card-title">Grafik Kekeruhan</div>
                <div style="font-size:0.75rem;color:var(--aq-text-muted);">Turbidity (NTU) over time</div>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:0.5rem;">
            <span style="display:inline-block;width:24px;height:3px;border-radius:2px;background:#0891B2;"></span>
            <span style="font-size:0.75rem;color:var(--aq-text-secondary);">NTU</span>
        </div>
    </div>
    <div class="aq-card-body">
        <div class="aq-chart-container">
            <canvas id="ntuChart"></canvas>
        </div>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.font.family = "'Inter', ui-sans-serif, system-ui, sans-serif";
    Chart.defaults.font.size   = 12;
    Chart.defaults.color       = '#64748B';

    const labels = [
        @foreach($history as $item)
        "{{ $item->created_at->format('H:i') }}",
        @endforeach
    ];

    const suhuData = [
        @foreach($history as $item)
        {{ $item->suhu }},
        @endforeach
    ];

    const phData = [
        @foreach($history as $item)
        {{ $item->ph }},
        @endforeach
    ];

    const ntuData = [
        @foreach($history as $item)
        {{ $item->kekeruhan }},
        @endforeach
    ];

    const sharedOptions = {
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
                ticks: { maxTicksLimit: 12 },
            },
            y: {
                grid: { color: '#F1F5F9' },
                border: { display: false, dash: [4, 4] },
            },
        },
    };

    new Chart(document.getElementById('tempChart'), {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Suhu (°C)',
                data: suhuData,
                borderColor: '#2563EB',
                backgroundColor: 'rgba(37,99,235,0.08)',
                borderWidth: 2.5,
                pointRadius: 2,
                pointHoverRadius: 5,
                pointBackgroundColor: '#2563EB',
                fill: true,
                tension: 0.4,
            }],
        },
        options: sharedOptions,
    });

    new Chart(document.getElementById('phChart'), {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'pH',
                data: phData,
                borderColor: '#7C3AED',
                backgroundColor: 'rgba(124,58,237,0.07)',
                borderWidth: 2.5,
                pointRadius: 2,
                pointHoverRadius: 5,
                pointBackgroundColor: '#7C3AED',
                fill: true,
                tension: 0.4,
            }],
        },
        options: sharedOptions,
    });

    new Chart(document.getElementById('ntuChart'), {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Kekeruhan (NTU)',
                data: ntuData,
                borderColor: '#0891B2',
                backgroundColor: 'rgba(8,145,178,0.07)',
                borderWidth: 2.5,
                pointRadius: 2,
                pointHoverRadius: 5,
                pointBackgroundColor: '#0891B2',
                fill: true,
                tension: 0.4,
            }],
        },
        options: sharedOptions,
    });
</script>

@endsection
