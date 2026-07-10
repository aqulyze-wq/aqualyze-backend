<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aqualyze — Smart Aquaculture Monitoring System</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        body {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            background: #0F172A;
            color: #fff;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        /* ---- Decorative background ---- */
        .welcome-bg {
            position: fixed;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        }

        .welcome-bg::before {
            content: '';
            position: absolute;
            width: 700px;
            height: 700px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(37,99,235,0.18) 0%, transparent 70%);
            top: -200px;
            right: -200px;
        }

        .welcome-bg::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(6,182,212,0.12) 0%, transparent 70%);
            bottom: -100px;
            left: -100px;
        }

        /* ---- Navbar ---- */
        .welcome-nav {
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.25rem 2.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        .welcome-nav-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .welcome-nav-logo {
            width: 38px;
            height: 38px;
            border-radius: 9px;
            overflow: hidden;
            background: rgba(255,255,255,0.08);
        }

        .welcome-nav-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 9px;
        }

        .welcome-nav-name {
            font-size: 1.125rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.02em;
        }

        .welcome-nav-actions { display: flex; align-items: center; gap: 0.75rem; }

        .welcome-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1.125rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            border: 1.5px solid transparent;
            text-decoration: none;
            transition: all 0.15s ease;
            line-height: 1;
        }

        .welcome-btn-ghost {
            color: rgba(255,255,255,0.7);
            border-color: rgba(255,255,255,0.12);
            background: transparent;
        }

        .welcome-btn-ghost:hover {
            background: rgba(255,255,255,0.06);
            color: #fff;
            text-decoration: none;
        }

        .welcome-btn-primary {
            background: #2563EB;
            color: #fff;
            border-color: #2563EB;
        }

        .welcome-btn-primary:hover {
            background: #1D4ED8;
            border-color: #1D4ED8;
            color: #fff;
            text-decoration: none;
        }

        /* ---- Hero ---- */
        .welcome-hero {
            position: relative;
            z-index: 1;
            max-width: 860px;
            margin: 0 auto;
            padding: 5rem 2rem 4rem;
            text-align: center;
        }

        .welcome-hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(37,99,235,0.15);
            border: 1px solid rgba(37,99,235,0.25);
            color: #93C5FD;
            padding: 0.375rem 1rem;
            border-radius: 99px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 1.75rem;
        }

        .welcome-hero h1 {
            font-size: clamp(2.25rem, 5vw, 3.5rem);
            font-weight: 900;
            line-height: 1.1;
            letter-spacing: -0.04em;
            margin-bottom: 1.25rem;
            color: #fff;
        }

        .welcome-hero h1 span {
            background: linear-gradient(135deg, #60A5FA 0%, #06B6D4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .welcome-hero p {
            font-size: 1.0625rem;
            color: rgba(255,255,255,0.5);
            line-height: 1.7;
            max-width: 560px;
            margin: 0 auto 2.5rem;
        }

        .welcome-hero-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.875rem;
            flex-wrap: wrap;
        }

        .welcome-cta {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 1.75rem;
            border-radius: 10px;
            font-size: 0.9375rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s ease;
            line-height: 1;
        }

        .welcome-cta-primary {
            background: #2563EB;
            color: #fff;
            border: 2px solid #2563EB;
            box-shadow: 0 4px 20px rgba(37,99,235,0.35);
        }

        .welcome-cta-primary:hover {
            background: #1D4ED8;
            border-color: #1D4ED8;
            color: #fff;
            text-decoration: none;
            transform: translateY(-1px);
            box-shadow: 0 6px 24px rgba(37,99,235,0.45);
        }

        .welcome-cta-outline {
            background: transparent;
            color: rgba(255,255,255,0.75);
            border: 2px solid rgba(255,255,255,0.15);
        }

        .welcome-cta-outline:hover {
            background: rgba(255,255,255,0.06);
            color: #fff;
            border-color: rgba(255,255,255,0.25);
            text-decoration: none;
        }

        /* ---- Stats row ---- */
        .welcome-stats {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            max-width: 700px;
            margin: 0 auto 4rem;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 14px;
            overflow: hidden;
        }

        .welcome-stat-item {
            flex: 1;
            padding: 1.25rem 1.5rem;
            text-align: center;
            border-right: 1px solid rgba(255,255,255,0.06);
        }

        .welcome-stat-item:last-child { border-right: none; }

        .welcome-stat-num {
            font-size: 1.625rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.03em;
            line-height: 1;
        }

        .welcome-stat-label {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.35);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 0.375rem;
        }

        /* ---- Feature Grid ---- */
        .welcome-features {
            position: relative;
            z-index: 1;
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 2rem 5rem;
        }

        .welcome-features-title {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .welcome-features-title h2 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.03em;
            margin-bottom: 0.5rem;
        }

        .welcome-features-title p {
            font-size: 0.9375rem;
            color: rgba(255,255,255,0.4);
        }

        .welcome-feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1rem;
        }

        .welcome-feature-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 14px;
            padding: 1.5rem;
            transition: background 0.2s, border-color 0.2s;
        }

        .welcome-feature-card:hover {
            background: rgba(255,255,255,0.07);
            border-color: rgba(255,255,255,0.14);
        }

        .welcome-feature-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.375rem;
            margin-bottom: 1rem;
        }

        .welcome-feature-card h3 {
            font-size: 0.9375rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 0.5rem;
            letter-spacing: -0.01em;
        }

        .welcome-feature-card p {
            font-size: 0.8125rem;
            color: rgba(255,255,255,0.45);
            line-height: 1.6;
        }

        /* ---- Footer ---- */
        .welcome-footer {
            position: relative;
            z-index: 1;
            border-top: 1px solid rgba(255,255,255,0.06);
            padding: 1.5rem 2.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .welcome-footer-left { font-size: 0.8125rem; color: rgba(255,255,255,0.3); }
        .welcome-footer-right { font-size: 0.8125rem; color: rgba(255,255,255,0.25); }

        @media (max-width: 600px) {
            .welcome-nav   { padding: 1rem 1.25rem; }
            .welcome-hero  { padding: 3rem 1.25rem 2.5rem; }
            .welcome-stats { flex-direction: column; }
            .welcome-stat-item { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.06); }
            .welcome-stat-item:last-child { border-bottom: none; }
            .welcome-features { padding: 0 1.25rem 3rem; }
            .welcome-footer   { flex-direction: column; align-items: flex-start; padding: 1.25rem; }
        }
    </style>
</head>
<body>

<div class="welcome-bg"></div>

{{-- Navbar --}}
<nav class="welcome-nav">
    <a href="/" class="welcome-nav-brand">
        <div class="welcome-nav-logo">
            <img src="{{ asset('images/logo-aqualyze.png') }}" alt="Aqualyze">
        </div>
        <span class="welcome-nav-name">Aqualyze</span>
    </a>

    @if (Route::has('login'))
        <div class="welcome-nav-actions">
            @auth
                <a href="{{ url('/dashboard') }}" class="welcome-btn welcome-btn-primary">
                    <i class="bi bi-grid-1x2-fill"></i>
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="welcome-btn welcome-btn-ghost">
                    Sign In
                </a>
            @endauth
        </div>
    @endif
</nav>

{{-- Hero --}}
<section class="welcome-hero">
    <div class="welcome-hero-tag">
        <i class="bi bi-wifi"></i>
        IoT Aquaculture Monitoring
    </div>

    <h1>
        Smart Water Quality<br>
        <span>Monitoring System</span>
    </h1>

    <p>
        Real-time sensor data for fish farmers and researchers.
        Track temperature, pH, and turbidity from a single, reliable dashboard.
    </p>

    <div class="welcome-hero-actions">
        @auth
            <a href="{{ url('/dashboard') }}" class="welcome-cta welcome-cta-primary">
                <i class="bi bi-grid-1x2-fill"></i>
                Go to Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="welcome-cta welcome-cta-primary">
                <i class="bi bi-box-arrow-in-right"></i>
                Sign In to Dashboard
            </a>
            <a href="#features" class="welcome-cta welcome-cta-outline">
                <i class="bi bi-info-circle"></i>
                Learn More
            </a>
        @endauth
    </div>
</section>

{{-- Stats --}}
<div class="welcome-stats">
    <div class="welcome-stat-item">
        <div class="welcome-stat-num">3</div>
        <div class="welcome-stat-label">Sensor Parameters</div>
    </div>
    <div class="welcome-stat-item">
        <div class="welcome-stat-num">5s</div>
        <div class="welcome-stat-label">Refresh Interval</div>
    </div>
    <div class="welcome-stat-item">
        <div class="welcome-stat-num">24/7</div>
        <div class="welcome-stat-label">Continuous Monitoring</div>
    </div>
    <div class="welcome-stat-item">
        <div class="welcome-stat-num">IoT</div>
        <div class="welcome-stat-label">Sensor-Connected</div>
    </div>
</div>

{{-- Features --}}
<section class="welcome-features" id="features">
    <div class="welcome-features-title">
        <h2>Built for Aquaculture Professionals</h2>
        <p>Everything you need to monitor and manage water quality</p>
    </div>

    <div class="welcome-feature-grid">
        <div class="welcome-feature-card">
            <div class="welcome-feature-icon" style="background:rgba(37,99,235,0.15);color:#60A5FA;">
                <i class="bi bi-thermometer-half"></i>
            </div>
            <h3>Temperature Monitoring</h3>
            <p>Track water temperature in real time. Instant alerts when values go outside the optimal 28–30°C range.</p>
        </div>
        <div class="welcome-feature-card">
            <div class="welcome-feature-icon" style="background:rgba(124,58,237,0.15);color:#A78BFA;">
                <i class="bi bi-droplet-half"></i>
            </div>
            <h3>pH Level Analysis</h3>
            <p>Monitor water acidity continuously. Optimal pH range of 6.5–8.0 maintained for healthy aquaculture.</p>
        </div>
        <div class="welcome-feature-card">
            <div class="welcome-feature-icon" style="background:rgba(6,182,212,0.15);color:#22D3EE;">
                <i class="bi bi-water"></i>
            </div>
            <h3>Turbidity Sensing</h3>
            <p>Measure water clarity in NTU. Detect suspended particles early before they affect fish health.</p>
        </div>
        <div class="welcome-feature-card">
            <div class="welcome-feature-icon" style="background:rgba(22,163,74,0.15);color:#4ADE80;">
                <i class="bi bi-graph-up-arrow"></i>
            </div>
            <h3>Historical Charts</h3>
            <p>Visualize trends across all three parameters. Up to 100 historical readings rendered as smooth line charts.</p>
        </div>
        <div class="welcome-feature-card">
            <div class="welcome-feature-icon" style="background:rgba(245,158,11,0.15);color:#FCD34D;">
                <i class="bi bi-bell-fill"></i>
            </div>
            <h3>Status Alerts</h3>
            <p>Automated Normal / Warning classification on every reading so you always know the health of your water.</p>
        </div>
        <div class="welcome-feature-card">
            <div class="welcome-feature-icon" style="background:rgba(37,99,235,0.12);color:#93C5FD;">
                <i class="bi bi-hdd-network-fill"></i>
            </div>
            <h3>REST API</h3>
            <p>Full JSON API for IoT device integration. POST sensor readings directly from microcontrollers.</p>
        </div>
    </div>
</section>

{{-- Footer --}}
<footer class="welcome-footer">
    <div class="welcome-footer-left">
        &copy; {{ date('Y') }} Aqualyze &mdash; Smart Aquaculture Monitoring System
    </div>
    <div class="welcome-footer-right">
        Capstone Project &mdash; Universitas &middot; v1.3.0
    </div>
</footer>

</body>
</html>
