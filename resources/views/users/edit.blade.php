@extends('layouts.app')

@section('content')

<div class="aq-page-header">

    <div>

        <h2 class="aq-page-title">Edit User</h2>

        <p class="aq-page-subtitle">
            Perbarui data pengguna.
        </p>

    </div>

</div>

<div class="aq-card">

<form action="{{ route('users.update',$user) }}" method="POST">

    @csrf
    @method('PUT')

    <div class="mb-3">

        <label>Nama</label>

        <input
        type="text"
        name="name"
        class="form-control"
        value="{{ old('name',$user->name) }}"
        required>

    </div>

    <div class="mb-3">

        <label>Email</label>

        <input
        type="email"
        name="email"
        class="form-control"
        value="{{ old('email',$user->email) }}"
        required>

    </div>

    <div class="mb-3">

        <label>Role</label>

        <select
        name="role"
        class="form-control">

            <option value="admin"
            {{ $user->role=='admin' ? 'selected' : '' }}>

                Admin

            </option>

            <option value="user"
            {{ $user->role=='user' ? 'selected' : '' }}>

                Viewer

            </option>

        </select>

    </div>

    <button class="aq-btn-primary">

        <i class="bi bi-check-circle"></i>

        Simpan Perubahan

    </button>

    <a href="{{ route('users.index') }}"
       class="btn btn-secondary">

        Batal

    </a>

</form>

</div>

@endsection