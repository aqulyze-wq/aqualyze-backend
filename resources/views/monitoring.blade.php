@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-8">

    <h1 class="text-4xl font-bold text-slate-800 mb-8">
        Monitoring Sensor
    </h1>

    <!-- Card Sensor -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 border-t-4 border-blue-500 p-6">
            <p class="text-gray-500 mb-2">🌡 Suhu Air</p>

            <h2 class="text-5xl font-bold text-blue-600">
                {{ $latest->suhu }} °C
            </h2>

            <span class="inline-block mt-4 px-4 py-2 rounded-full
                {{ $latest->status_suhu == 'Normal'
                    ? 'bg-green-100 text-green-700'
                    : ($latest->status_suhu == 'Warning'
                        ? 'bg-yellow-100 text-yellow-700'
                        : 'bg-red-100 text-red-700') }}">
                {{ $latest->status_suhu }}
            </span>
            <p class="text-xs text-gray-500 mt-3">
                Update:
                {{ $latest->created_at->format('d M Y H:i') }}
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 border-t-4 border-purple-500 p-6">
            <p class="text-gray-500 mb-2">🧪 pH Air</p>

            <h2 class="text-5xl font-bold text-purple-600">
                {{ $latest->ph }}
            </h2>

            <span class="inline-block mt-4 px-4 py-2 rounded-full
                {{ $latest->status_ph == 'Normal'
                    ? 'bg-green-100 text-green-700'
                    : ($latest->status_ph == 'Warning'
                        ? 'bg-yellow-100 text-yellow-700'
                        : 'bg-red-100 text-red-700') }}">
                {{ $latest->status_ph }}
            </span>
            <p class="text-xs text-gray-500 mt-3">
                Update:
                {{ $latest->created_at->format('d M Y H:i') }}
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 border-t-4 border-cyan-500 p-6">
            <p class="text-gray-500 mb-2">💧 Kekeruhan</p>

            <h2 class="text-5xl font-bold text-cyan-600">
                {{ $latest->kekeruhan }} NTU
            </h2>

            <span class="inline-block mt-4 px-4 py-2 rounded-full
                {{ $latest->status_kekeruhan == 'Normal'
                    ? 'bg-green-100 text-green-700'
                    : ($latest->status_kekeruhan == 'Warning'
                        ? 'bg-yellow-100 text-yellow-700'
                        : 'bg-red-100 text-red-700') }}">
                {{ $latest->status_kekeruhan }}
            </span>
            <p class="text-xs text-gray-500 mt-3">
                Update:
                {{ $latest->created_at->format('d M Y H:i') }}
            </p>
        </div>

    </div>

    <!-- Riwayat Sensor -->

    <div class="bg-white rounded-2xl shadow p-6">

        <h2 class="text-2xl font-bold mb-6">
            Riwayat Monitoring
        </h2>

        <table class="min-w-full">

            <thead>

                <tr class="border-b">

                    <th class="text-center">No</th>

                    <th class="text-left py-3">Tanggal</th>

                    <th class="text-center">Suhu</th>

                    <th class="text-center">Status Suhu</th>

                    <th class="text-center">pH</th>

                    <th class="text-center">Status pH</th>

                    <th class="text-center">NTU</th>

                    <th class="text-center">Status NTU</th>

                </tr>

            </thead>

            <tbody>
                @foreach($history as $item)
                <tr class="border-b hover:bg-blue-50 transition">
                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>
                    <td class="py-3">
                        <div>{{ $item->created_at->format('d M Y') }}</div>
                        <div class="text-sm text-gray-500">
                            {{ $item->created_at->format('H:i') }}
                        </div>
                    </td>
                    <td class="text-center">
                        {{ $item->suhu }} °C
                    </td>
                    <td class="text-center">
                        <span class="px-3 py-1 rounded-full
                            {{ $item->status_suhu == 'Normal'
                                ? 'bg-green-100 text-green-700'
                                : ($item->status_suhu == 'Warning'
                                    ? 'bg-yellow-100 text-yellow-700'
                                    : 'bg-red-100 text-red-700') }}">
                            {{ $item->status_suhu }}
                        </span>
                    </td>
                    <td class="text-center">
                        {{ $item->ph }}
                    </td>
                    <td class="text-center">
                        <span class="px-3 py-1 rounded-full
                            {{ $item->status_ph == 'Normal'
                                ? 'bg-green-100 text-green-700'
                                : ($item->status_ph == 'Warning'
                                    ? 'bg-yellow-100 text-yellow-700'
                                    : 'bg-red-100 text-red-700') }}">
                            {{ $item->status_ph }}
                        </span>
                    </td>
                    <td class="text-center">
                        {{ $item->kekeruhan }} NTU
                    </td>
                    <td class="text-center">
                        <span class="px-3 py-1 rounded-full
                            {{ $item->status_kekeruhan == 'Normal'
                                ? 'bg-green-100 text-green-700'
                                : ($item->status_kekeruhan == 'Warning'
                                    ? 'bg-yellow-100 text-yellow-700'
                                    : 'bg-red-100 text-red-700') }}">
                            {{ $item->status_kekeruhan }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>

@endsection