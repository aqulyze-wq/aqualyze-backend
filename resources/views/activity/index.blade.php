@extends('layouts.app')

@section('content')

<div class="aq-page-header">

    <div>

        <h2 class="aq-page-title">
            Activity Log
        </h2>

        <p class="aq-page-subtitle">
            Riwayat seluruh aktivitas sistem Aqualyze.
        </p>

    </div>

</div>

<div class="aq-device-stats">

    <div class="aq-device-stat">

        <div class="aq-device-icon blue">
            <i class="bi bi-list-check"></i>
        </div>

        <div>

            <span>Total Activity</span>

            <h3>{{ $totalActivity }}</h3>

        </div>

    </div>

    <div class="aq-device-stat">

        <div class="aq-device-icon green">
            <i class="bi bi-person-check"></i>
        </div>

        <div>

            <span>User Active</span>

            <h3>{{ $userActive }}</h3>

        </div>

    </div>

    <div class="aq-device-stat">

        <div class="aq-device-icon orange">
            <i class="bi bi-router"></i>
        </div>

        <div>

            <span>Device Event</span>

            <h3>{{ $deviceEvent }}</h3>

        </div>

    </div>

    <div class="aq-device-stat">

        <div class="aq-device-icon red">
            <i class="bi bi-exclamation-triangle"></i>
        </div>

        <div>

            <span>Warning</span>

            <h3>{{ $warning }}</h3>

        </div>

    </div>

</div>

<div class="aq-card">

    <table class="aq-table">

        <thead>

            <tr>

                <th>Waktu</th>

                <th>User</th>

                <th>Module</th>

                <th>Aktivitas</th>

            </tr>

        </thead>

        <tbody>

            @forelse($logs as $log)

            <tr>

                <td>

                    {{ $log->created_at->format('d M Y H:i') }}

                </td>

                <td>

                    {{ $log->user->name }}

                </td>

                <td>

                    <span class="aq-badge aq-badge-success">

                        {{ $log->module }}

                    </span>

                </td>

                <td>

                    {{ $log->activity }}

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="4" class="text-center">

                    Belum ada aktivitas.

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection