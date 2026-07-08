@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-8">

    <h1 class="text-4xl font-bold text-slate-800 mb-8">
        Grafik Monitoring
    </h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <div class="bg-white rounded-2xl shadow-lg border-t-4 border-blue-500 p-6">
            <p class="text-gray-500">🌡 Suhu Air</p>
            <h2 class="text-4xl font-bold text-blue-600 mt-2">
                {{ $latest->suhu }} °C
            </h2>
            <p class="mt-3 font-semibold text-green-600">
                {{ $latest->status_suhu }}
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border-t-4 border-purple-500 p-6">
            <p class="text-gray-500">🧪 pH Air</p>
            <h2 class="text-4xl font-bold text-purple-600 mt-2">
                {{ $latest->ph }}
            </h2>
            <p class="mt-3 font-semibold text-green-600">
                {{ $latest->status_ph }}
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border-t-4 border-cyan-500 p-6">
            <p class="text-gray-500">💧 Kekeruhan</p>
            <h2 class="text-4xl font-bold text-cyan-600 mt-2">
                {{ $latest->kekeruhan }}
</h2>
            <p class="mt-3 font-semibold text-green-600">
                {{ $latest->status_kekeruhan }}
            </p>
        </div>

    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6">

    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
        <h2 class="text-2xl font-semibold text-slate-800 mb-4">
        🌡 Grafik Suhu
        </h2>

    <canvas id="tempChart"></canvas>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
        <h2 class="text-2xl font-semibold text-slate-800 mb-4">
        🧪 Grafik pH
        </h2>

        <canvas id="phChart"></canvas>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h2 class="text-2xl font-semibold text-slate-800 mb-4">
            💧 Grafik Kekeruhan
        </h2>

        <canvas id="ntuChart"></canvas>
    </div>

    

    </div>

</div>

    

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    const labels = [
    @foreach($history as $item)
    "{{ $item->created_at->format('H:i') }}",
    @endforeach
    ];

    const suhu = [
    @foreach($history as $item)
    {{ $item->suhu }},
    @endforeach
    ];

    const ph = [
    @foreach($history as $item)
    {{ $item->ph }},
    @endforeach
    ];

    const ntu = [
    @foreach($history as $item)
    {{ $item->kekeruhan }},
    @endforeach
    ];
    console.log(ntu);

    new Chart(document.getElementById('tempChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Suhu (°C)',
            data: suhu,
            borderColor: '#2563eb',
            backgroundColor: 'rgba(37,99,235,.15)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        }
    }
    });

    new Chart(document.getElementById('phChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'pH',
            data: ph,
            borderColor: '#9333ea',
            backgroundColor: 'rgba(147,51,234,.15)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        }
    }
    });

    new Chart(document.getElementById('ntuChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Kekeruhan',
            data: ntu,
            borderColor: '#0891b2',
            backgroundColor: 'rgba(8,145,178,.15)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        }
    }
    });

</script>

@endsection