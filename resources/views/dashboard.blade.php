@extends('layouts.app')

@section('content')
<div class="aq-content p-6">

  <!-- TOP HEADER / WELCOME -->
  <div class="aq-dashboard-welcome mb-6 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <!-- Ucapan & Subtitle -->
    <div>
        @php
            $hour = (int) now()->format('H');

            if ($hour >= 5 && $hour < 12) {
                $greeting = 'Good Morning';
            } elseif ($hour >= 12 && $hour < 17) {
                $greeting = 'Good Afternoon';
            } elseif ($hour >= 17 && $hour < 21) {
                $greeting = 'Good Evening';
            } else {
                $greeting = 'Good Night';
            }

            $userName = auth()->check() ? Str::words(auth()->user()->name, 1, '') : 'User';
        @endphp

        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
            {{ $greeting }}, {{ $userName }} 👋
        </h1>
        <p class="text-sm text-slate-500 mt-1">Monitoring all connected locations in real time.</p>
    </div>
    
    <!-- Filter Lokasi & Live Updates -->
    <div class="flex items-end gap-3">
      <!-- Location Filter Dropdown -->
      <form method="GET" id="deviceFilterForm" class="m-0">
          <div class="aq-device-filter flex flex-col justify-end">
              <label class="aq-filter-label text-xs font-semibold text-slate-500 mb-1 block">
                  Lokasi
              </label>

              <div class="aq-select-wrapper">
                  <i class="bi bi-geo-alt-fill"></i>

                  <select
                      name="device"
                      class="aq-select-device"
                      onchange="document.getElementById('deviceFilterForm').submit();"
                  >
                      <option value="">
                          Semua Lokasi
                      </option>

                      @foreach($devices as $device)
                          <option
                              value="{{ $device->id }}"
                              {{ $selectedDevice == $device->id ? 'selected' : '' }}
                          >
                              {{ $device->lokasi ?? 'Lokasi #'.$device->id }}
                          </option>
                      @endforeach
                  </select>
              </div>
          </div>
      </form>

      <!-- Live Updates Badge -->
      <div class="flex items-center gap-2 bg-white border border-slate-200 px-3.5 py-2 rounded-xl text-xs font-semibold text-blue-600 shadow-sm cursor-pointer hover:bg-slate-50 transition-all h-[42px] box-border">
        <i class="bi bi-broadcast text-blue-600"></i>
        <span>Live Updates</span>
      </div>
    </div>
  </div>

  <!-- STATS CARDS -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
    
    <!-- Card 1: Total Lokasi -->
    <div class="aq-saas-card p-5 flex flex-col justify-between">
      <div class="flex items-center justify-between">
        <span class="text-xs font-semibold text-slate-500">Total Lokasi</span>
        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
          <i class="bi bi-geo-alt-fill"></i>
        </div>
      </div>
      <div class="text-3xl font-extrabold text-slate-900 mt-3 mb-1">{{ $totalDevices }}</div>
      <span class="text-xs text-slate-400">Registered locations</span>
    </div>

    <!-- Card 2: Lokasi Online -->
    <div class="aq-saas-card p-5 flex flex-col justify-between">
      <div class="flex items-center justify-between">
        <span class="text-xs font-semibold text-slate-500">Lokasi Online</span>
        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-lg">
          <i class="bi bi-wifi"></i>
        </div>
      </div>
      <div class="text-3xl font-extrabold text-emerald-500 mt-3 mb-1">{{ $onlineDevices }}</div>
      <span class="text-xs text-slate-400">Active & transmitting</span>
    </div>

    <!-- Card 3: Lokasi Offline -->
    <div class="aq-saas-card p-5 flex flex-col justify-between">
      <div class="flex items-center justify-between">
        <span class="text-xs font-semibold text-slate-500">Lokasi Offline</span>
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

      {{-- ================= TEMPERATURE ================= --}}
      <div class="aq-saas-card aq-sensor-card aq-sensor-temp p-5">
          <div class="flex items-center gap-3 mb-3">
              <div class="w-9 h-9 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center text-base">
                  <i class="bi bi-thermometer-half"></i>
              </div>
              <span class="font-semibold text-slate-600 text-sm">
                  Temperature
              </span>
          </div>

          <div class="text-2xl font-bold text-slate-900 my-1">
              {{ number_format($latest?->suhu ?? 0, 1) }} °C
          </div>

          <div class="flex items-center justify-between mt-3 text-xs">
              @php
                  $tempClass = match($latest?->status_suhu) {
                      'Normal', 'Good'  => 'text-emerald-600',
                      'Warning'         => 'text-amber-500',
                      'Danger', 'Bad'   => 'text-red-600',
                      default           => 'text-slate-500'
                  };

                  $tempIcon = match($latest?->status_suhu) {
                      'Normal', 'Good'  => 'bi-check-circle-fill',
                      'Warning'         => 'bi-exclamation-triangle-fill',
                      'Danger', 'Bad'   => 'bi-x-circle-fill',
                      default           => 'bi-dash-circle-fill'
                  };
              @endphp

              <span class="{{ $tempClass }} font-semibold flex items-center gap-1">
                  <i class="bi {{ $tempIcon }}"></i>
                  {{ $latest?->status_suhu ?? '-' }}
              </span>

              <span class="text-slate-400">
                  Ideal: 25 – 30 °C
              </span>
          </div>
      </div>

      {{-- ================= PH ================= --}}
      <div class="aq-saas-card aq-sensor-card aq-sensor-ph p-5">
          <div class="flex items-center gap-3 mb-3">
              <div class="w-9 h-9 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center text-base">
                  <i class="bi bi-droplet-fill"></i>
              </div>
              <span class="font-semibold text-slate-600 text-sm">
                  pH Level
              </span>
          </div>

          <div class="text-2xl font-bold text-slate-900 my-1">
              {{ number_format($latest?->ph ?? 0, 1) }} pH
          </div>

          <div class="flex items-center justify-between mt-3 text-xs">
              @php
                  $phClass = match($latest?->status_ph) {
                      'Normal', 'Good'  => 'text-emerald-600',
                      'Warning'         => 'text-amber-500',
                      'Danger', 'Bad'   => 'text-red-600',
                      default           => 'text-slate-500'
                  };

                  $phIcon = match($latest?->status_ph) {
                      'Normal', 'Good'  => 'bi-check-circle-fill',
                      'Warning'         => 'bi-exclamation-triangle-fill',
                      'Danger', 'Bad'   => 'bi-x-circle-fill',
                      default           => 'bi-dash-circle-fill'
                  };
              @endphp

              <span class="{{ $phClass }} font-semibold flex items-center gap-1">
                  <i class="bi {{ $phIcon }}"></i>
                  {{ $latest?->status_ph ?? '-' }}
              </span>

              <span class="text-slate-400">
                  Ideal: 6.5 – 8.0
              </span>
          </div>
      </div>

      {{-- ================= TURBIDITY ================= --}}
      <div class="aq-saas-card aq-sensor-card aq-sensor-turb p-5">
          <div class="flex items-center gap-3 mb-3">
              <div class="w-9 h-9 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center text-base">
                  <i class="bi bi-water"></i>
              </div>
              <span class="font-semibold text-slate-600 text-sm">
                  Turbidity
              </span>
          </div>

          <div class="text-2xl font-bold text-slate-900 my-1">
              {{ number_format($latest?->kekeruhan ?? 0, 0) }} NTU
          </div>

          <div class="flex items-center justify-between mt-3 text-xs">
              @php
                  $turbClass = 'text-slate-500';
                  $turbIcon  = 'bi-dash-circle-fill';

                  switch($latest?->status_kekeruhan) {
                      case 'Normal':
                      case 'Very Clear':
                      case 'Sangat Jernih':
                          $turbClass = 'text-emerald-600';
                          $turbIcon  = 'bi-check-circle-fill';
                          break;

                      case 'Warning':
                      case 'Clear':
                      case 'Jernih':
                      case 'Turbid':
                      case 'Keruh':
                          $turbClass = 'text-amber-500';
                          $turbIcon  = 'bi-exclamation-triangle-fill';
                          break;

                      case 'Danger':
                      case 'Very Turbid':
                      case 'Sangat Keruh':
                          $turbClass = 'text-red-600';
                          $turbIcon  = 'bi-x-circle-fill';
                          break;
                  }
              @endphp

              <span class="{{ $turbClass }} font-semibold flex items-center gap-1">
                  <i class="bi {{ $turbIcon }}"></i>
                  {{ $latest?->status_kekeruhan ?? '-' }}
              </span>

              <span class="text-slate-400">
                  Ideal: 0 – 30 NTU
              </span>
          </div>
      </div>

  </div>

  <!-- MIDDLE SECTION: CHART, RECENT ACTIVITY, LOCATION STATUS -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 mb-6">
      
    <!-- 1. ANALYTICS & TRENDS CHART -->
    <div class="{{ auth()->check() && auth()->user()->role === 'admin' ? 'lg:col-span-6' : 'lg:col-span-12' }}">
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

    @if(auth()->check() && auth()->user()->role === 'admin')
        <!-- 2. RECENT ACTIVITY (KHUSUS ADMIN - SPAN 3) -->
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

        <!-- 3. LOCATION STATUS LIST (KHUSUS ADMIN - SPAN 3) -->
        <div class="lg:col-span-3">
          <div class="aq-saas-card p-5 h-full flex flex-col justify-between">
            <div>
              <h6 class="font-bold text-slate-800 text-sm mb-4">Status Lokasi</h6>
              <div class="space-y-3.5 text-xs">

                @forelse($devices as $dev)
                  <div class="flex items-center justify-between whitespace-nowrap gap-2">
                    <div class="flex items-center gap-2 min-w-0">
                      <span class="aq-dot {{ strtolower($dev->status ?? '') == 'online' ? 'aq-dot-success' : 'aq-dot-danger' }} shrink-0"></span>
                      <span class="font-medium text-slate-700 truncate">{{ $dev->lokasi ?? 'Lokasi #'.$dev->id }}</span>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                      <span class="font-semibold {{ strtolower($dev->status ?? '') == 'online' ? 'text-emerald-500' : 'text-rose-500' }}">
                        {{ ucfirst($dev->status ?? 'Offline') }}
                      </span>
                      <span class="text-slate-400 text-[11px]">{{ $dev->updated_at ? $dev->updated_at->diffForHumans(null, true) : '-' }}</span>
                    </div>
                  </div>
                @empty
                  <div class="text-slate-400 text-xs">No locations found</div>
                @endforelse

              </div>
            </div>

            <a href="{{ route('devices.index') }}" class="aq-card-footer-link flex items-center justify-between text-xs text-slate-400 font-semibold pt-3 mt-4 border-t border-slate-100 hover:text-blue-600">
              <span>View all locations</span>
              <i class="bi bi-chevron-right text-[10px]"></i>
            </a>
          </div>
        </div>
    @endif

  </div>

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

  <!-- MAP SECTION -->
  <div class="aq-saas-card p-5">

      <div class="flex justify-between items-center mb-3">

          <h6 class="font-bold text-slate-800 text-sm">
              Map Lokasi
          </h6>

          <a href="{{ route('map') }}"
             class="text-primary text-xs fw-semibold">
              View Full Map →
          </a>

      </div>

      <div id="dashboardMap"
           style="height:280px;border-radius:14px;overflow:hidden;">
      </div>

  </div>

  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  <script>
  document.addEventListener("DOMContentLoaded", function () {
      const map = L.map('dashboardMap').setView([-6.9175, 107.6191], 11);

      L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 19,
          attribution: '&copy; OpenStreetMap'
      }).addTo(map);

      // Icon Online
      const onlineIcon = new L.Icon({
          iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
          shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
          iconSize: [25, 41],
          iconAnchor: [12, 41],
          popupAnchor: [1, -34],
          shadowSize: [41, 41]
      });

      // Icon Offline
      const offlineIcon = new L.Icon({
          iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
          shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
          iconSize: [25, 41],
          iconAnchor: [12, 41],
          popupAnchor: [1, -34],
          shadowSize: [41, 41]
      });

      const markers = [];
      const selectedDeviceId = "{{ $selectedDevice }}";

      @foreach($devices as $device)
          @if(!empty($device->latitude) && !empty($device->longitude))
              
              if (!selectedDeviceId || selectedDeviceId == "{{ $device->id }}") {
                  
                  const marker{{ $device->id }} = L.marker(
                      [{{ $device->latitude }}, {{ $device->longitude }}],
                      {
                          icon: "{{ $device->status }}" === "online" ? onlineIcon : offlineIcon
                      }
                  ).addTo(map);

                  marker{{ $device->id }}.bindPopup(`
                      <div style="min-width:220px">
                          <h6 style="margin:0 0 8px;font-weight:700;">
                              {{ $device->lokasi ?? 'Lokasi #'.$device->id }}
                          </h6>
                          <p style="margin:0 0 5px;">
                              <strong>Status :</strong>
                              <span style="color:{{ $device->status=='online' ? '#16a34a' : '#dc2626' }}">
                                  {{ ucfirst($device->status) }}
                              </span>
                          </p>
                          <p style="margin:0;">
                              <strong>Last Seen :</strong><br>
                              {{ $device->last_seen ? \Carbon\Carbon::parse($device->last_seen)->format('d M Y H:i') : '-' }}
                          </p>
                      </div>
                  `);

                  marker{{ $device->id }}.on('click', function() {
                      map.setView(marker{{ $device->id }}.getLatLng(), 17, { animate: true });
                  });

                  markers.push(marker{{ $device->id }});
              }
          @endif
      @endforeach

      if (markers.length > 0) {
          const group = L.featureGroup(markers);
          if (markers.length === 1) {
              map.setView(markers[0].getLatLng(), 16);
              markers[0].openPopup();
          } else {
              map.fitBounds(group.getBounds().pad(0.2));
          }
      }
  });
  </script>

</div>
@endsection