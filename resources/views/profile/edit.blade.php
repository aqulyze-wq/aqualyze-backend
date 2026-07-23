@extends('layouts.app')

@section('content')

{{-- Page Header --}}
<div class="aq-page-header">
    <h1>Profil Akun</h1>
    <p>Kelola informasi akun dan keamanan akses Aqualyze.</p>
</div>

<div style="display:grid;grid-template-columns:300px 1fr;gap:1.25rem;align-items:start;" class="aq-profile-grid">

    {{-- ── Profile Overview Card ── --}}
    <div style="display:flex;flex-direction:column;gap:1rem;">

        <div class="aq-card">
            <div class="aq-card-body" style="text-align:center;padding:2rem 1.375rem;">

                {{-- Avatar --}}
                <div style="width:80px;height:80px;border-radius:50%;background:var(--aq-primary);color:#fff;display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:800;margin:0 auto 1rem;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>

                <div style="font-size:1.125rem;font-weight:700;color:var(--aq-text-primary);margin-bottom:0.25rem;">
                    {{ Auth::user()->name }}
                </div>
                <div style="font-size:0.875rem;color:var(--aq-text-secondary);margin-bottom:1rem;">
                    {{ Auth::user()->email }}
                </div>

                <span class="aq-badge aq-badge-info" style="margin-bottom:1.25rem;display:inline-flex;">
                    <i class="bi bi-shield-fill-check"></i>
                    Administrator
                </span>

                <hr class="aq-divider" style="margin:1rem 0;">

                <div style="display:flex;flex-direction:column;gap:0.625rem;text-align:left;">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:0.8125rem;color:var(--aq-text-secondary);">Status</span>
                        <span class="aq-badge aq-badge-live">
                            <i class="bi bi-circle-fill" style="font-size:0.4rem;"></i>
                            Online
                        </span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:0.8125rem;color:var(--aq-text-secondary);">Member Since</span>
                        <span style="font-size:0.8125rem;font-weight:500;color:var(--aq-text-primary);">
                            {{ Auth::user()->created_at->format('M Y') }}
                        </span>
                    </div>
                </div>

            </div>
        </div>

    </div>

    {{-- ── Forms Column ── --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">

        {{-- Update Profile --}}
        <div class="aq-card">
            <div class="aq-card-header">
                <div style="display:flex;align-items:center;gap:0.5rem;">
                    <i class="bi bi-person-fill" style="color:var(--aq-primary);"></i>
                    <span class="aq-card-title">Informasi Profil</span>
                </div>
            </div>
            <div class="aq-card-body">

                @if(session('status') === 'profile-updated')
                    <div class="aq-alert aq-alert-success">
                        <i class="bi bi-check-circle-fill aq-alert-icon"></i>
                        <span class="aq-alert-text">Profil berhasil diperbarui.</span>
                    </div>
                @endif

                @include('profile.partials.update-profile-information-form')

            </div>
        </div>

        {{-- Update Password --}}
        <div class="aq-card">
            <div class="aq-card-header">
                <div style="display:flex;align-items:center;gap:0.5rem;">
                    <i class="bi bi-lock-fill" style="color:#7C3AED;"></i>
                    <span class="aq-card-title">Ubah Password</span>
                </div>
            </div>
            <div class="aq-card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Delete Account --}}
        <div class="aq-card" style="border-color:#FECACA;">
            <div class="aq-card-header" style="background:#FEF2F2;border-bottom-color:#FECACA;">
                <div style="display:flex;align-items:center;gap:0.5rem;">
                    <i class="bi bi-exclamation-triangle-fill" style="color:var(--aq-danger);"></i>
                    <span class="aq-card-title" style="color:var(--aq-danger);">Hapus Akun</span>
                </div>
            </div>
            <div class="aq-card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>

</div>

{{-- Responsive stack on small screens --}}
<style>
    @media (max-width: 900px) {
        .aq-profile-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>

@endsection
