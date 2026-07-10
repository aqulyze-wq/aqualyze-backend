<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle ?? 'Dashboard' }} — Aqualyze</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

{{-- Mobile Sidebar Overlay --}}
<div class="aq-sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<div class="aq-layout">

    {{-- ===================== SIDEBAR ===================== --}}
    <aside class="aq-sidebar" id="sidebar">

        {{-- Brand --}}
        <div class="aq-sidebar-brand">
            <div class="aq-sidebar-logo">
                <img src="{{ asset('images/logo-aqualyze.png') }}" alt="Aqualyze Logo">
            </div>
            <div>
                <div class="aq-brand-name">Aqualyze</div>
                <div class="aq-brand-sub">Smart Aquaculture</div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="aq-nav">

            <span class="aq-nav-label">Main Menu</span>

            <a href="{{ route('dashboard') }}"
               class="aq-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill nav-icon"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('monitoring') }}"
               class="aq-nav-item {{ request()->routeIs('monitoring') ? 'active' : '' }}">
                <i class="bi bi-activity nav-icon"></i>
                <span>Monitoring</span>
            </a>

            <a href="{{ route('charts') }}"
               class="aq-nav-item {{ request()->routeIs('charts') ? 'active' : '' }}">
                <i class="bi bi-graph-up-arrow nav-icon"></i>
                <span>Grafik</span>
            </a>

            <span class="aq-nav-label">Account</span>

            <a href="{{ route('profile.edit') }}"
               class="aq-nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="bi bi-person-circle nav-icon"></i>
                <span>Profil</span>
            </a>

        </nav>

        {{-- User Card --}}
        <div class="aq-sidebar-user">
            <div class="aq-sidebar-user-info">
                <div class="aq-user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div style="min-width:0;">
                    <div class="aq-user-name">{{ Auth::user()->name }}</div>
                    <div class="aq-user-role">Administrator</div>
                </div>
            </div>
            <div class="aq-online-dot" style="margin-bottom:0.625rem;">Online</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="aq-btn aq-btn-danger aq-btn-sm aq-btn-full">
                    <i class="bi bi-box-arrow-right"></i>
                    Logout
                </button>
            </form>
        </div>

    </aside>

    {{-- ===================== MAIN ===================== --}}
    <div class="aq-main">

        {{-- Top Bar --}}
        <header class="aq-topbar">
            <div class="aq-topbar-left">
                <button class="aq-mobile-menu-btn" id="mobileMenuBtn" onclick="openSidebar()" aria-label="Open menu">
                    <i class="bi bi-list"></i>
                </button>
                <div>
                    <div class="aq-page-title">
                        @if(request()->routeIs('dashboard'))       Dashboard
                        @elseif(request()->routeIs('monitoring'))   Monitoring Sensor
                        @elseif(request()->routeIs('charts'))       Grafik Data
                        @elseif(request()->routeIs('profile.*'))    Profil Akun
                        @else                                       Aqualyze
                        @endif
                    </div>
                    <div class="aq-breadcrumb">
                        Aqualyze &rsaquo;
                        @if(request()->routeIs('dashboard'))       Dashboard
                        @elseif(request()->routeIs('monitoring'))   Monitoring
                        @elseif(request()->routeIs('charts'))       Grafik
                        @elseif(request()->routeIs('profile.*'))    Profil
                        @else                                       Home
                        @endif
                    </div>
                </div>
            </div>

            <div class="aq-topbar-right">
                <span class="aq-topbar-badge">
                    <i class="bi bi-circle-fill" style="font-size:0.45rem;"></i>
                    System Online
                </span>
                <a href="{{ route('profile.edit') }}"
                   style="width:34px;height:34px;border-radius:50%;background:var(--aq-primary);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.8125rem;text-decoration:none;flex-shrink:0;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </a>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="aq-content">
            @yield('content')
        </main>

    </div>{{-- /.aq-main --}}

</div>{{-- /.aq-layout --}}

{{-- Sidebar JS (mobile) --}}
<script>
    function openSidebar() {
        document.getElementById('sidebar').classList.add('sidebar-open');
        document.getElementById('sidebarOverlay').classList.add('overlay-open');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('sidebar-open');
        document.getElementById('sidebarOverlay').classList.remove('overlay-open');
        document.body.style.overflow = '';
    }

    // Close sidebar on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeSidebar();
    });
</script>

</body>
</html>
