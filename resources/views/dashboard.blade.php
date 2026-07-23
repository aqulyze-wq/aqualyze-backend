@extends('layouts.app')

@section('content')
    <div class="aq-content p-6">

  <!-- TOP HEADER / WELCOME -->
  <div class="aq-dashboard-welcome mb-6 flex flex-wrap items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Good Morning, Refan 👋</h1>
      <p class="text-sm text-slate-500 mt-1">Monitoring all connected fish ponds in real time.</p>
    </div>
    
    <div class="flex items-center gap-3">
      <!-- Device Filter Dropdown -->
      <div class="bg-white px-3 py-2 rounded-xl border border-slate-200 flex items-center gap-2 text-xs shadow-sm">
        <span class="text-slate-400 font-medium">Device Filter</span>
        <select class="border-0 bg-transparent font-semibold text-slate-800 outline-none cursor-pointer p-0">
          <option>All Devices</option>
        </select>
      </div>

      <!-- Live Updates Badge -->
      <div class="flex items-center gap-2 bg-white border border-slate-200 px-3 py-2 rounded-xl text-xs font-semibold text-blue-600 shadow-sm cursor-pointer hover:bg-slate-50 transition-all">
        <i class="bi bi-broadcast text-blue-600"></i>
        <span>Live Updates</span>
      </div>
    </div>
  </div>

<!-- STATS CARDS -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
  
  <!-- Card 1: Total Device -->
  <div class="aq-saas-card p-5 flex flex-col justify-between">
    <div class="flex items-center justify-between">
      <span class="text-xs font-semibold text-slate-500">Total Device</span>
      <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
        <i class="bi bi-cpu-fill"></i>
      </div>
    </div>
    <div class="text-3xl font-extrabold text-slate-900 mt-3 mb-1">{{ $totalDevices }}</div>
    <span class="text-xs text-slate-400">Registered hardware units</span>
  </div>

  <!-- Card 2: Online Device -->
  <div class="aq-saas-card p-5 flex flex-col justify-between">
    <div class="flex items-center justify-between">
      <span class="text-xs font-semibold text-slate-500">Online Device</span>
      <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-lg">
        <i class="bi bi-wifi"></i>
      </div>
    </div>
    <div class="text-3xl font-extrabold text-emerald-500 mt-3 mb-1">{{ $onlineDevices }}</div>
    <span class="text-xs text-slate-400">Active & transmitting</span>
  </div>

  <!-- Card 3: Offline Device -->
  <div class="aq-saas-card p-5 flex flex-col justify-between">
    <div class="flex items-center justify-between">
      <span class="text-xs font-semibold text-slate-500">Offline Device</span>
      <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center text-lg">
        <i class="bi bi-wifi-off"></i>
      </div>
    </div>
    <div class="text-3xl font-extrabold text-rose-500 mt-3 mb-1">{{ $offlineDevices }}</div>
    <span class="text-xs text-slate-400">No connection detected</span>
  </div>

  <!-- Card 4: Last Update -->
  <div class="aq-saas-card p-5 flex flex-col justify-between">
    <div class="flex items-center justify-between">
      <span class="text-xs font-semibold text-slate-500">Last Update</span>
      <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg">
        <i class="bi bi-clock-fill"></i>
      </div>
    </div>
    <div class="text-2xl font-extrabold text-slate-900 mt-3 mb-1 tracking-tight">
      {{ $lastUpdate ? \Carbon\Carbon::parse($lastUpdate)->format('H:i:s') : '--:--:--' }}
    </div>
    <span class="text-xs text-slate-400">
      {{ $lastUpdate ? \Carbon\Carbon::parse($lastUpdate)->format('d M Y') : 'No updates yet' }}
    </span>
  </div>

</div>

  <!-- SENSOR OVERVIEW -->
  <h6 class="text-sm font-bold text-slate-800 mb-3">Sensor Overview</h6>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
    
    <!-- Temperature -->
    <div class="aq-saas-card aq-sensor-card aq-sensor-temp p-5">
      <div class="flex items-center gap-3 mb-3">
        <div class="w-9 h-9 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center text-base">
          <i class="bi bi-thermometer-half"></i>
        </div>
        <span class="font-semibold text-slate-600 text-sm">Temperature</span>
      </div>
      <div class="text-2xl font-bold text-slate-900 my-1">28.79 °C</div>
      <div class="flex items-center justify-between mt-3 text-xs">
        <span class="text-emerald-600 font-semibold flex items-center gap-1">
          <i class="bi bi-check-circle-fill"></i> Normal
        </span>
        <span class="text-slate-400">Ideal: 25 – 30 °C</span>
      </div>
    </div>

    <!-- pH Level -->
    <div class="aq-saas-card aq-sensor-card aq-sensor-ph p-5">
      <div class="flex items-center gap-3 mb-3">
        <div class="w-9 h-9 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center text-base">
          <i class="bi bi-droplet-fill"></i>
        </div>
        <span class="font-semibold text-slate-600 text-sm">pH Level</span>
      </div>
      <div class="text-2xl font-bold text-slate-900 my-1">7.28 pH</div>
      <div class="flex items-center justify-between mt-3 text-xs">
        <span class="text-emerald-600 font-semibold flex items-center gap-1">
          <i class="bi bi-check-circle-fill"></i> Normal
        </span>
        <span class="text-slate-400">Ideal: 6.5 – 8.0</span>
      </div>
    </div>

    <!-- Turbidity -->
    <div class="aq-saas-card aq-sensor-card aq-sensor-turb p-5">
      <div class="flex items-center gap-3 mb-3">
        <div class="w-9 h-9 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center text-base">
          <i class="bi bi-water"></i>
        </div>
        <span class="font-semibold text-slate-600 text-sm">Turbidity</span>
      </div>
      <div class="text-2xl font-bold text-slate-900 my-1">15.35 NTU</div>
      <div class="flex items-center justify-between mt-3 text-xs">
        <span class="text-amber-500 font-semibold flex items-center gap-1">
          <i class="bi bi-exclamation-triangle-fill"></i> Warning
        </span>
        <span class="text-slate-400">Ideal: 0 – 30 NTU</span>
      </div>
    </div>

  </div>

<!-- MIDDLE SECTION: CHART, RECENT ACTIVITY, DEVICE STATUS -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-5 mb-6">
    
  <!-- 1. ANALYTICS & TRENDS CHART (SPAN 6) -->
  <div class="lg:col-span-6">
    <div class="aq-saas-card p-5 h-full flex flex-col justify-between">
      <div>
        <div class="flex items-center justify-between mb-4">
          <div>
            <h6 class="font-bold text-slate-800 text-sm">Analytics & Trends</h6>
            <span class="text-xs text-slate-400">Suhu, pH & Kekeruhan</span>
          </div>
          <span class="text-xs bg-slate-100 text-slate-600 font-semibold px-2.5 py-1 rounded-lg">Last 20 Data</span>
        </div>
        
        <!-- Canvas Chart -->
        <div class="aq-chart-container h-60 w-full relative">
          <canvas id="sensorChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- 2. RECENT ACTIVITY (SPAN 3) -->
  <div class="lg:col-span-3">
    <div class="aq-saas-card p-5 h-full flex flex-col justify-between">
      <div>
        <h6 class="font-bold text-slate-800 text-sm mb-4">Recent Activity</h6>
        <div class="space-y-4 text-xs">
          
          @forelse($recentActivities as $act)
            <div class="flex items-start gap-2.5">
              <span class="text-slate-400 font-medium shrink-0">
                {{ $act->created_at ? $act->created_at->format('H:i') : '--:--' }}
              </span>
              <span class="aq-dot aq-dot-success mt-1.5 shrink-0"></span>
              <div class="min-w-0 flex-1">
                <div class="font-bold text-slate-800 truncate">{{ $act->activity }}</div>
                <div class="text-slate-400 font-medium">{{ $act->user->name ?? $act->user ?? 'Admin' }}</div>
              </div>
            </div>
          @empty
            <div class="text-slate-400 text-xs">Belum ada aktivitas terbaru</div>
          @endforelse

        </div>
      </div>

      <a href="{{ route('activity.index') }}" class="aq-card-footer-link flex items-center justify-between text-xs text-slate-400 font-semibold pt-3 mt-4 border-t border-slate-100 hover:text-blue-600">
        <span>View all activities</span>
        <i class="bi bi-chevron-right text-[10px]"></i>
      </a>
    </div>
  </div>

  <!-- 3. DEVICE STATUS LIST (SPAN 3) -->
  <div class="lg:col-span-3">
    <div class="aq-saas-card p-5 h-full flex flex-col justify-between">
      <div>
        <h6 class="font-bold text-slate-800 text-sm mb-4">Device Status</h6>
        <div class="space-y-3.5 text-xs">

          @forelse($devices as $dev)
            <div class="flex items-center justify-between whitespace-nowrap gap-2">
              <div class="flex items-center gap-2 min-w-0">
                <span class="aq-dot {{ strtolower($dev->status ?? '') == 'online' ? 'aq-dot-success' : 'aq-dot-danger' }} shrink-0"></span>
                <span class="font-medium text-slate-700 truncate">{{ $dev->nama_device ?? $dev->name }}</span>
              </div>
              <div class="flex items-center gap-2 shrink-0">
                <span class="font-semibold {{ strtolower($dev->status ?? '') == 'online' ? 'text-emerald-500' : 'text-rose-500' }}">
                  {{ ucfirst($dev->status ?? 'Offline') }}
                </span>
                <span class="text-slate-400 text-[11px]">{{ $dev->updated_at ? $dev->updated_at->diffForHumans(null, true) : '-' }}</span>
              </div>
            </div>
          @empty
            <div class="text-slate-400 text-xs">No devices found</div>
          @endforelse

        </div>
      </div>

      <a href="{{ route('devices.index') }}" class="aq-card-footer-link flex items-center justify-between text-xs text-slate-400 font-semibold pt-3 mt-4 border-t border-slate-100 hover:text-blue-600">
        <span>View all devices</span>
        <i class="bi bi-chevron-right text-[10px]"></i>
      </a>
    </div>
  </div>

</div>
<!-- AKHIR GRID 12 COLUMNS -->

<!-- SCRIPT GRAFIK CHART.JS -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('sensorChart');
    if (!ctx) return;

    const historyData = @json($history);

    const labels = historyData.map(item => {
      if(!item.created_at) return '';
      const date = new Date(item.created_at);
      return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    });

    const temps = historyData.map(item => item.suhu ?? item.temperature ?? 0);
    const phs = historyData.map(item => item.ph ?? 0);
    const turbidities = historyData.map(item => item.kekeruhan ?? item.turbidity ?? 0);

    new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [
          {
            label: 'Suhu (°C)',
            data: temps,
            borderColor: '#2563eb',
            backgroundColor: 'transparent',
            tension: 0.3,
            borderWidth: 2,
            pointRadius: 2
          },
          {
            label: 'pH Level',
            data: phs,
            borderColor: '#a855f7',
            backgroundColor: 'transparent',
            tension: 0.3,
            borderWidth: 2,
            pointRadius: 2
          },
          {
            label: 'Kekeruhan (NTU)',
            data: turbidities,
            borderColor: '#f59e0b',
            backgroundColor: 'transparent',
            tension: 0.3,
            borderWidth: 2,
            pointRadius: 2
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { 
            display: true, 
            position: 'top',
            labels: { boxWidth: 10, font: { size: 10 } } 
          }
        },
        scales: {
          x: { grid: { display: false } },
          y: { grid: { color: '#f1f5f9' }, beginAtZero: false }
        }
      }
    });
  });
</script>

  <!-- DEVICE LOCATION (MAP) -->
  <div class="aq-saas-card p-5">
    <h6 class="font-bold text-slate-800 text-sm mb-3">Device Location</h6>
    <div class="aq-map-container">
      <i class="bi bi-geo-alt-fill text-blue-600 text-3xl mb-1"></i>
      <span class="font-semibold text-slate-500 text-sm">Google Maps Integration</span>
    </div>
  </div>

</div>
@endsection

