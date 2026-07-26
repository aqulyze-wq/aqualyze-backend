@extends('layouts.app')

@section('content')

<!-- HEADER HALAMAN -->
<div class="aq-page-header">
    <div>
        <h1 class="aq-page-title">Account Management</h1>
        <p class="aq-page-subtitle">
            Kelola akun administrator dan viewer yang terhubung di sistem.
        </p>
    </div>
    <a href="{{ route('users.create') }}" class="aq-btn aq-btn-primary">
        <i class="bi bi-person-plus-fill"></i> Tambah User
    </a>
</div>

<!-- STATISTIK RINGKASAN USER -->
<div class="aq-device-stats">
    <div class="aq-device-stat">
        <div class="aq-device-icon blue">
            <i class="bi bi-people-fill"></i>
        </div>
        <div>
            <span>Total User</span>
            <h3>{{ $users->total() ?? $users->count() }}</h3>
        </div>
    </div>

    <div class="aq-device-stat">
        <div class="aq-device-icon green">
            <i class="bi bi-shield-lock-fill"></i>
        </div>
        <div>
            <span>Admin</span>
            <h3>{{ $users->where('role', 'admin')->count() }}</h3>
        </div>
    </div>

    <div class="aq-device-stat">
        <div class="aq-device-icon red" style="background: #fef3c7; color: #d97706;">
            <i class="bi bi-person-badge-fill"></i>
        </div>
        <div>
            <span>Viewer</span>
            <h3>{{ $users->where('role', 'user')->count() }}</h3>
        </div>
    </div>
</div>

<!-- CONTAINER UTAMA -->
<div class="aq-card">

    <!-- FORM FILTER & SEARCH (SEJAJAR BERSAMPINGAN) -->
    <form method="GET" action="{{ url()->current() }}" style="display: flex !important; flex-direction: row !important; align-items: center !important; gap: 12px !important; margin-bottom: 1.5rem !important; flex-wrap: nowrap !important;">
        
        <!-- Input Search dengan Ikon -->
        <div style="position: relative; width: 320px; flex-shrink: 0;">
            <i class="bi bi-search" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 14px; pointer-events: none; z-index: 2;"></i>
            <input 
                type="search" 
                name="search" 
                class="aq-input" 
                style="padding-left: 42px !important; border-radius: 12px !important; height: 44px !important; font-size: 13px !important; border: 1px solid #e2e8f0 !important; color: #334155 !important; width: 100% !important; margin: 0 !important;" 
                placeholder="Cari nama atau email..." 
                value="{{ request('search') }}"
                onchange="this.form.submit()"
            >
        </div>

        <!-- Filter Role (Semua Role / Admin / Viewer) -->
        <div style="width: 180px; flex-shrink: 0;">
            <select 
                name="role" 
                class="aq-input aq-select" 
                style="border-radius: 12px !important; height: 44px !important; font-size: 13px !important; border: 1px solid #e2e8f0 !important; color: #334155 !important; width: 100% !important; cursor: pointer !important; margin: 0 !important;" 
                onchange="this.form.submit()"
            >
                <option value="">Semua Role</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>Viewer</option>
            </select>
        </div>

        <!-- Tombol Reset Filter -->
        @if(request('search') || request('role'))
            <a href="{{ url()->current() }}" style="font-size: 13px; color: #ef4444; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; font-weight: 500; white-space: nowrap;">
                <i class="bi bi-x-circle"></i> Reset Filter
            </a>
        @endif

    </form>

    <!-- TABEL DATA USER -->
    <div class="aq-table-wrap">
        <table class="aq-table">
            <thead>
                <tr>
                    <th>PENGGUNA</th>
                    <th>EMAIL</th>
                    <th class="text-center">ROLE</th>
                    <th class="text-center">STATUS</th>
                    <th class="text-center" style="width: 100px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <!-- Name & Avatar -->
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="aq-user-avatar" style="width: 38px; height: 38px; font-size: 0.875rem; background: var(--aq-primary); color: #fff; font-weight: 700;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <strong style="color: #0f172a; font-size: 0.875rem;">{{ $user->name }}</strong>
                                </div>
                            </div>
                        </td>

                        <!-- Email -->
                        <td style="color: #475569; font-weight: 500;">
                            {{ $user->email }}
                        </td>

                        <!-- Role -->
                        <td class="text-center">
                            @if($user->role === 'admin')
                                <span class="aq-badge aq-badge-info">
                                    <i class="bi bi-shield-check"></i> Admin
                                </span>
                            @else
                                <span class="aq-badge" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;">
                                    <i class="bi bi-person"></i> Viewer
                                </span>
                            @endif
                        </td>

                        <!-- Status -->
                        <td class="text-center">
                            <span class="aq-badge aq-badge-success">
                                <span class="aq-dot aq-dot-success"></span> Aktif
                            </span>
                        </td>

                        <!-- Action -->
                        <td class="text-center">
                            <div class="d-flex align-items-center justify-content-center gap-1">
                                {{-- Edit Button --}}
                                <a href="{{ route('users.edit', $user->id) }}" class="aq-btn-icon" title="Edit User">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>

                                {{-- Delete Button --}}
                                @if(auth()->id() != $user->id)
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="aq-btn-icon text-danger" 
                                            title="Hapus User"
                                            onclick="return confirm('Yakin ingin menghapus user ini?')"
                                        >
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="aq-empty">
                                <i class="bi bi-people"></i>
                                <p>Belum ada akun pengguna yang ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection