@extends('layouts.app')

@section('content')

{{-- Page Header --}}
<div class="aq-page-header" style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
    <div>
        <h1>Monitoring Sensor</h1>
        <p>Pembacaan sensor terkini dan riwayat 100 data terakhir.</p>
    </div>
    <span class="aq-badge aq-badge-live" style="font-size:0.75rem;padding:0.375rem 0.875rem;">
        <i class="bi bi-circle-fill" style="font-size:0.45rem;"></i>
        {{ $latest->created_at->format('d M Y, H:i') }}
    </span>
</div>

{{-- ── Sensor Cards ── --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1rem;margin-bottom:1.5rem;">

    {{-- Suhu --}}
    <div class="aq-card" style="border-top:3px solid #2563EB;">
        <div class="aq-card-body">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                <div style="display:flex;align-items:center;gap:0.625rem;">
                    <div style="width:40px;height:40px;border-radius:10px;background:#EFF6FF;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-thermometer-half" style="color:#2563EB;font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <div style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:var(--aq-text-muted);">Suhu Air</div>
                        <div style="font-size:0.75rem;color:var(--aq-text-secondary);">Water Temperature</div>
                    </div>
                </div>
                <span class="aq-badge {{ $latest->status_suhu === 'Normal' ? 'aq-badge-success' : ($latest->status_suhu === 'Warning' ? 'aq-badge-warning' : 'aq-badge-danger') }}">
                    <i class="bi bi-{{ $latest->status_suhu === 'Normal' ? 'check-circle-fill' : 'exclamation-triangle-fill' }}"></i>
                    {{ $latest->status_suhu }}
                </span>
            </div>
            <div style="font-size:3rem;font-weight:900;color:#2563EB;letter-spacing:-0.04em;line-height:1;margin-bottom:0.75rem;">
                {{ $latest->suhu }}<span style="font-size:1.25rem;font-weight:500;color:var(--aq-text-secondary);">°C</span>
            </div>
            <div style="background:#E2E8F0;border-radius:99px;height:5px;overflow:hidden;margin-bottom:0.75rem;">
                <div style="height:100%;border-radius:99px;background:#2563EB;width:{{ min(100, max(0, ($latest->suhu / 40) * 100)) }}%;transition:width 0.5s;"></div>
            </div>
            <div style="font-size:0.75rem;color:var(--aq-text-muted);display:flex;align-items:center;gap:0.25rem;">
                <i class="bi bi-clock"></i>
                {{ $latest->created_at->format('d M Y, H:i') }}
            </div>
        </div>
    </div>

    {{-- pH --}}
    <div class="aq-card" style="border-top:3px solid #7C3AED;">
        <div class="aq-card-body">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                <div style="display:flex;align-items:center;gap:0.625rem;">
                    <div style="width:40px;height:40px;border-radius:10px;background:#F5F3FF;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-droplet-half" style="color:#7C3AED;font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <div style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:var(--aq-text-muted);">pH Air</div>
                        <div style="font-size:0.75rem;color:var(--aq-text-secondary);">Water Acidity</div>
                    </div>
                </div>
                <span class="aq-badge {{ $latest->status_ph === 'Normal' ? 'aq-badge-success' : ($latest->status_ph === 'Warning' ? 'aq-badge-warning' : 'aq-badge-danger') }}">
                    <i class="bi bi-{{ $latest->status_ph === 'Normal' ? 'check-circle-fill' : 'exclamation-triangle-fill' }}"></i>
                    {{ $latest->status_ph }}
                </span>
            </div>
            <div style="font-size:3rem;font-weight:900;color:#7C3AED;letter-spacing:-0.04em;line-height:1;margin-bottom:0.75rem;">
                {{ $latest->ph }}<span style="font-size:1.25rem;font-weight:500;color:var(--aq-text-secondary);"> pH</span>
            </div>
            <div style="background:#E2E8F0;border-radius:99px;height:5px;overflow:hidden;margin-bottom:0.75rem;">
                <div style="height:100%;border-radius:99px;background:#7C3AED;width:{{ min(100, max(0, ($latest->ph / 14) * 100)) }}%;transition:width 0.5s;"></div>
            </div>
            <div style="font-size:0.75rem;color:var(--aq-text-muted);display:flex;align-items:center;gap:0.25rem;">
                <i class="bi bi-clock"></i>
                {{ $latest->created_at->format('d M Y, H:i') }}
            </div>
        </div>
    </div>

    {{-- Kekeruhan --}}
    <div class="aq-card" style="border-top:3px solid #0891B2;">
        <div class="aq-card-body">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                <div style="display:flex;align-items:center;gap:0.625rem;">
                    <div style="width:40px;height:40px;border-radius:10px;background:#ECFEFF;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-water" style="color:#0891B2;font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <div style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:var(--aq-text-muted);">Kekeruhan</div>
                        <div style="font-size:0.75rem;color:var(--aq-text-secondary);">Water Turbidity</div>
                    </div>
                </div>
                <span class="aq-badge {{ $latest->status_kekeruhan === 'Normal' ? 'aq-badge-success' : ($latest->status_kekeruhan === 'Warning' ? 'aq-badge-warning' : 'aq-badge-danger') }}">
                    <i class="bi bi-{{ $latest->status_kekeruhan === 'Normal' ? 'check-circle-fill' : 'exclamation-triangle-fill' }}"></i>
                    {{ $latest->status_kekeruhan }}
                </span>
            </div>
            <div style="font-size:3rem;font-weight:900;color:#0891B2;letter-spacing:-0.04em;line-height:1;margin-bottom:0.75rem;">
                {{ $latest->kekeruhan }}<span style="font-size:1.25rem;font-weight:500;color:var(--aq-text-secondary);"> NTU</span>
            </div>
            <div style="background:#E2E8F0;border-radius:99px;height:5px;overflow:hidden;margin-bottom:0.75rem;">
                <div style="height:100%;border-radius:99px;background:#0891B2;width:{{ min(100, max(0, ($latest->kekeruhan / 100) * 100)) }}%;transition:width 0.5s;"></div>
            </div>
            <div style="font-size:0.75rem;color:var(--aq-text-muted);display:flex;align-items:center;gap:0.25rem;">
                <i class="bi bi-clock"></i>
                {{ $latest->created_at->format('d M Y, H:i') }}
            </div>
        </div>
    </div>

</div>

{{-- ── History Table ── --}}
<div class="aq-card">

    <div class="aq-card-header">
        <div style="display:flex;align-items:center;gap:0.5rem;">
            <i class="bi bi-table" style="color:var(--aq-primary);"></i>
            <span class="aq-card-title">Riwayat Monitoring</span>
        </div>
        <span style="font-size:0.75rem;color:var(--aq-text-muted);">
            Menampilkan {{ count($history) }} data terakhir
        </span>
    </div>

    <div class="aq-table-wrap">
        <table class="aq-table">
            <thead>
                <tr>
                    <th class="text-center" style="width:52px;">#</th>
                    <th>Tanggal &amp; Waktu</th>
                    <th class="text-center">Suhu</th>
                    <th class="text-center">Status Suhu</th>
                    <th class="text-center">pH</th>
                    <th class="text-center">Status pH</th>
                    <th class="text-center">Kekeruhan</th>
                    <th class="text-center">Status NTU</th>
                </tr>
            </thead>
            <tbody>
                @forelse($history as $item)
                <tr>
                    <td class="text-center" style="color:var(--aq-text-muted);font-size:0.75rem;">
                        {{ $loop->iteration }}
                    </td>
                    <td>
                        <div style="font-weight:500;color:var(--aq-text-primary);font-size:0.8125rem;">
                            {{ $item->created_at->format('d M Y') }}
                        </div>
                        <div style="font-size:0.75rem;color:var(--aq-text-muted);margin-top:1px;">
                            {{ $item->created_at->format('H:i:s') }}
                        </div>
                    </td>
                    <td class="text-center" style="font-weight:700;color:#2563EB;">
                        {{ $item->suhu }}°C
                    </td>
                    <td class="text-center">
                        <span class="aq-badge {{ $item->status_suhu === 'Normal' ? 'aq-badge-success' : ($item->status_suhu === 'Warning' ? 'aq-badge-warning' : 'aq-badge-danger') }}">
                            {{ $item->status_suhu }}
                        </span>
                    </td>
                    <td class="text-center" style="font-weight:700;color:#7C3AED;">
                        {{ $item->ph }}
                    </td>
                    <td class="text-center">
                        <span class="aq-badge {{ $item->status_ph === 'Normal' ? 'aq-badge-success' : ($item->status_ph === 'Warning' ? 'aq-badge-warning' : 'aq-badge-danger') }}">
                            {{ $item->status_ph }}
                        </span>
                    </td>
                    <td class="text-center" style="font-weight:700;color:#0891B2;">
                        {{ $item->kekeruhan }} NTU
                    </td>
                    <td class="text-center">
                        <span class="aq-badge {{ $item->status_kekeruhan === 'Normal' ? 'aq-badge-success' : ($item->status_kekeruhan === 'Warning' ? 'aq-badge-warning' : 'aq-badge-danger') }}">
                            {{ $item->status_kekeruhan }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="aq-empty">
                            <i class="bi bi-inbox"></i>
                            <p>Belum ada data sensor.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
