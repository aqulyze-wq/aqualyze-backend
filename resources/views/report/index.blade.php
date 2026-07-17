@extends('layouts.app')

@section('content')

<div class="aq-page-header">

    <div>

        <h2 class="aq-page-title">
            Report Monitoring
        </h2>

        <p class="aq-page-subtitle">
            Ringkasan monitoring kualitas air Aqualyze.
        </p>

    </div>

</div>

<div class="aq-device-stats">

    <div class="aq-device-stat">

        <div class="aq-device-icon blue">
            <i class="bi bi-hdd-network"></i>
        </div>

        <div>

            <span>Total Device</span>

            <h3>{{ $totalDevice }}</h3>

        </div>

    </div>

    <div class="aq-device-stat">

        <div class="aq-device-icon green">
            <i class="bi bi-wifi"></i>
        </div>

        <div>

            <span>Online</span>

            <h3>{{ $online }}</h3>

        </div>

    </div>

    <div class="aq-device-stat">

        <div class="aq-device-icon red">
            <i class="bi bi-wifi-off"></i>
        </div>

        <div>

            <span>Offline</span>

            <h3>{{ $offline }}</h3>

        </div>

    </div>

    <div class="aq-device-stat">

        <div class="aq-device-icon orange">
            <i class="bi bi-exclamation-triangle"></i>
        </div>

        <div>

            <span>Warning Hari Ini</span>

            <h3>{{ $warning }}</h3>

        </div>

    </div>

</div>

<div class="aq-card mb-4">

<form method="GET">

<div class="row">

<div class="col-md-3">

<label>Tanggal Awal</label>

<input
type="date"
name="start"
class="form-control"
value="{{ request('start') }}">

</div>

<div class="col-md-3">

<label>Tanggal Akhir</label>

<input
type="date"
name="end"
class="form-control"
value="{{ request('end') }}">

</div>

<div class="col-md-3">

<label>Device</label>

<select
name="device"
class="form-control">

<option value="">Semua Device</option>

@foreach($devices as $device)

<option
value="{{ $device->id }}"
{{ request('device')==$device->id ? 'selected' : '' }}>

{{ $device->nama_device }}

</option>

@endforeach

</select>

</div>

<div class="col-md-3 d-flex align-items-end">

<button
class="aq-btn-primary w-100">

<i class="bi bi-search"></i>

Filter

</button>

</div>

</div>

</form>

</div>

<div class="aq-card">

<table class="aq-table">

<thead>

<tr>

<th>Tanggal</th>

<th>Device</th>

<th>Suhu</th>

<th>pH</th>

<th>Kekeruhan</th>

<th>Status</th>

</tr>

</thead>

<tbody>

@forelse($data as $item)

<tr>

<td>

{{ $item->created_at->format('d M Y H:i') }}

</td>

<td>

{{ optional($item->device)->nama_device ?? '-' }}

</td>

<td>

{{ $item->suhu }} °C

</td>

<td>

{{ $item->ph }}

</td>

<td>

{{ $item->kekeruhan }}

</td>

<td>

@if(

$item->status_suhu=="Warning" ||

$item->status_ph=="Warning" ||

$item->status_kekeruhan=="Warning"

)

<span class="aq-badge aq-badge-warning">

Warning

</span>

@else

<span class="aq-badge aq-badge-success">

Normal

</span>

@endif

</td>

</tr>

@empty

<tr>

<td colspan="6">

Belum ada data.

</td>

</tr>

@endforelse

</tbody>

</table>

<div class="mt-3">

{{ $data->withQueryString()->links() }}

</div>

</div>

@endsection