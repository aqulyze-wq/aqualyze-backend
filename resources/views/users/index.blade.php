@extends('layouts.app')

@section('content')

<div class="aq-page-header">

    <div>

        <h2 class="aq-page-title">
            Account Management
        </h2>

        <p class="aq-page-subtitle">
            Kelola akun administrator dan viewer.
        </p>

    </div>

    <a href="{{ route('users.create') }}" class="aq-btn-primary">

        <i class="bi bi-plus-circle"></i>

        Tambah User

    </a>

</div>

<div class="aq-device-stats">

    <div class="aq-device-stat">

        <div class="aq-device-icon blue">

            <i class="bi bi-people-fill"></i>

        </div>

        <div>

            <span>Total User</span>

            <h3>{{ $users->count() }}</h3>

        </div>

    </div>

    <div class="aq-device-stat">

        <div class="aq-device-icon green">

            <i class="bi bi-person-check-fill"></i>

        </div>

        <div>

            <span>Admin</span>

            <h3>{{ $users->where('role','admin')->count() }}</h3>

        </div>

    </div>

    <div class="aq-device-stat">

        <div class="aq-device-icon orange">

            <i class="bi bi-person-fill"></i>

        </div>

        <div>

            <span>Viewer</span>

            <h3>{{ $users->where('role','user')->count() }}</h3>

        </div>

    </div>

</div>

<div class="aq-card">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <input
            type="text"
            class="form-control"
            placeholder="Cari nama atau email..."
            style="max-width:320px;">

    </div>

    <table class="aq-table">

        <thead>

        <tr>

            <th>Pengguna</th>

            <th>Email</th>

            <th>Role</th>

            <th>Status</th>

            <th>Aksi</th>

        </tr>

        </thead>

        <tbody>

        @forelse($users as $user)

        <tr>

            <td>

                <div class="d-flex align-items-center gap-2">

                    <div class="aq-user-avatar">

                        {{ strtoupper(substr($user->name,0,1)) }}

                    </div>

                    <strong>{{ $user->name }}</strong>

                </div>

            </td>

            <td>

                {{ $user->email }}

            </td>

            <td>

                @if($user->role=='admin')

                    <span class="aq-badge aq-badge-success">
                        Admin
                    </span>

                @else

                    <span class="aq-badge">
                        Viewer
                    </span>

                @endif

            </td>

            <td>

                <span class="aq-badge aq-badge-success">
                    Aktif
                </span>

            </td>

            <td>

                {{-- Edit --}}
                <a href="{{ route('users.edit',$user->id) }}"
                   class="aq-btn-icon">

                    <i class="bi bi-pencil"></i>

                </a>

                {{-- Delete --}}
                @if(auth()->id() != $user->id)

                <form
                    action="{{ route('users.destroy',$user->id) }}"
                    method="POST"
                    style="display:inline;">

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="aq-btn-icon text-danger"
                        onclick="return confirm('Yakin ingin menghapus user ini?')">

                        <i class="bi bi-trash"></i>

                    </button>

                </form>

                @endif

            </td>

        </tr>

        @empty

        <tr>

            <td colspan="5" class="text-center">

                Belum ada pengguna.

            </td>

        </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection