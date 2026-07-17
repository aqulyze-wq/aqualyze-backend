@extends('layouts.app')

@section('content')

<div class="aq-page-header">

    <div>

        <h2 class="aq-page-title">Tambah User</h2>

        <p class="aq-page-subtitle">
            Tambahkan akun administrator atau viewer.
        </p>

    </div>

</div>

<div class="aq-card">

<form action="{{ route('users.store') }}" method="POST">

    @csrf

    <div class="mb-3">

        <label>Nama</label>

        <input
        type="text"
        name="name"
        class="form-control"
        required>

    </div>

    <div class="mb-3">

        <label>Email</label>

        <input
        type="email"
        name="email"
        class="form-control"
        required>

    </div>

    <div class="mb-3">

        <label>Password</label>

        <input
        type="password"
        name="password"
        class="form-control"
        required>

    </div>

    <div class="mb-3">

        <label>Role</label>

        <select
        name="role"
        class="form-control">

            <option value="admin">Admin</option>

            <option value="user">Viewer</option>

        </select>

    </div>

    <button class="aq-btn-primary">

        <i class="bi bi-check-circle"></i>

        Simpan

    </button>

    <a href="{{ route('users.index') }}"
       class="btn btn-secondary">

        Batal

    </a>

</form>

</div>

@endsection