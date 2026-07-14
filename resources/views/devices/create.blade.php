@extends('layouts.app')

@section('content')

<div class="aq-page-header">

    <div>

        <h2 class="aq-page-title">

            Tambah Perangkat

        </h2>

        <p class="aq-page-subtitle">

            Tambahkan perangkat monitoring baru.

        </p>

    </div>

</div>

<div class="aq-card">

<form method="POST"
      action="{{ route('devices.store') }}">

@csrf

<div class="mb-3">

<label>Device ID</label>

<input
type="text"
name="device_id"
class="form-control">

</div>

<div class="mb-3">

<label>Nama Device</label>

<input
type="text"
name="nama_device"
class="form-control">

</div>

<div class="mb-3">

<label>Jenis Ikan</label>

<select
name="jenis_ikan"
class="form-control">

<option>Nila</option>

<option>Lele</option>

<option>Mas</option>

<option>Patin</option>

</select>

</div>

<div class="mb-3">

<label>Lokasi</label>

<input
type="text"
name="lokasi"
class="form-control">

</div>

<button class="aq-btn-primary">

Simpan

</button>

</form>

</div>

@endsection