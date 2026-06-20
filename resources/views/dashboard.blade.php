@extends('layouts.app')

@section('content')

<h1 class="text-4xl font-bold mb-8 text-gray-800">
    Dashboard Aqualyze
</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- Suhu -->
    <div class="bg-white rounded-2xl shadow-lg p-6">

        <h2 class="text-gray-500 text-lg">
            🌡 Suhu Air
        </h2>

        <p class="text-5xl font-bold mt-3 text-blue-600">
            {{ $latest->suhu ?? '-' }} °C
        </p>


         @php
            $warnaSuhu = match($latest->status_suhu ?? '') {
                'Normal' => 'bg-green-100 text-green-700',
                'Warning' => 'bg-yellow-100 text-yellow-700',
                'Bahaya' => 'bg-red-100 text-red-700',
                default => 'bg-gray-100 text-gray-700'
        };
        @endphp
        <span class="inline-block mt-4 px-4 py-2 rounded-full {{ $warnaSuhu }}">
              {{ $latest->status_suhu ?? 'Tidak Diketahui' }}  
        </span>

    </div>

    <!-- PH -->

    <div class="bg-white rounded-2xl shadow-lg p-6">

        <h2 class="text-gray-500 text-lg">
            🧪 pH Air
        </h2>

        <p class="text-5xl font-bold mt-3 text-purple-600">
            {{ $latest->ph ?? '-' }}
        </p>

        <span class="inline-block mt-4 px-4 py-2 rounded-full bg-green-100 text-green-700">
            {{ $latest->status_ph ?? '-' }}
        </span>

    </div>

    <!-- Kekeruhan -->

    <div class="bg-white rounded-2xl shadow-lg p-6">

        <h2 class="text-gray-500 text-lg">
            💧 Kekeruhan
        </h2>

        <p class="text-5xl font-bold mt-3 text-cyan-600">
            {{ $latest->kekeruhan ?? '-' }} NTU
        </p>

        <span class="inline-block mt-4 px-4 py-2 rounded-full bg-green-100 text-green-700">
            {{ $latest->status_kekeruhan ?? '-' }}
        </span>

    </div>

</div>

<div class="bg-white rounded-2xl shadow-lg p-6 mt-8">

    <h2 class="text-xl font-semibold mb-4">
        📅 Data Terakhir
    </h2>

    <p class="text-gray-700 text-lg">
        {{ $latest->created_at ?? 'Belum ada data' }}
    </p>

</div>

<div class="bg-white rounded-2xl shadow-lg p-6 mt-8">

    <h2 class="text-xl font-semibold mb-6">
        📈 Grafik Monitoring Sensor
    </h2>

    <canvas id="sensorChart"></canvas>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const labels = @json($history->pluck('id'));

const suhu = @json($history->pluck('suhu'));

const ph = @json($history->pluck('ph'));

const kekeruhan = @json($history->pluck('kekeruhan'));

const ctx = document.getElementById('sensorChart');

new Chart(ctx, {

    type: 'line',

    data: {

        labels: labels,

        datasets: [

            {
                label: 'Suhu (°C)',
                data: suhu,
                borderWidth: 2,
                tension: 0.4
            },

            {
                label: 'pH',
                data: ph,
                borderWidth: 2,
                tension: 0.4
            },

            {
                label: 'Kekeruhan (NTU)',
                data: kekeruhan,
                borderWidth: 2,
                tension: 0.4
            }

        ]

    },

    options: {

        responsive: true,

        plugins: {

            legend: {

                position: 'top'

            }

        }

    }

});

</script>
<script>

setInterval(function(){

    location.reload();

},5000);

</script>
@endsection