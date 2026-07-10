<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle ?? 'Login' }} — Aqualyze</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .guest-layout {
            min-height: 100vh;
            display: flex;
            background: var(--aq-surface);
        }

        /* Left panel — branding */
        .guest-panel-left {
            display: none;
            width: 44%;
            background: var(--aq-sidebar-bg);
            position: relative;
            overflow: hidden;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem;
        }

        @media (min-width: 1024px) {
            .guest-panel-left { display: flex; }
        }

        /* Decorative background circles */
        .guest-panel-left::before {
            content: '';
            position: absolute;
            width: 480px;
            height: 480px;
            border-radius: 50%;
            background: rgba(37, 99, 235, 0.12);
            top: -120px;
            right: -100px;
            pointer-events: none;
        }

        .guest-panel-left::after {
            content: '';
            position: absolute;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: rgba(6, 182, 212, 0.08);
            bottom: -80px;
            left: -60px;
            pointer-events: none;
        }

        .guest-brand {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            position: relative;
            z-index: 1;
        }

        .guest-brand-logo {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            overflow: hidden;
            background: rgba(255,255,255,0.1);
            flex-shrink: 0;
        }

        .guest-brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
        }

        .guest-brand-name {
            font-size: 1.375rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.02em;
        }

        .guest-brand-sub {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.45);
            font-weight: 500;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .guest-hero {
            position: relative;
            z-index: 1;
        }

        .guest-hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            background: rgba(37, 99, 235, 0.2);
            border: 1px solid rgba(37, 99, 235, 0.3);
            color: #93C5FD;
            padding: 0.3rem 0.75rem;
            border-radius: 99px;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 1.25rem;
        }

        .guest-hero h1 {
            font-size: 2.25rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
            letter-spacing: -0.03em;
            margin-bottom: 1rem;
        }

        .guest-hero h1 span {
            color: #60A5FA;
        }

        .guest-hero p {
            font-size: 0.9375rem;
            color: rgba(255,255,255,0.5);
            line-height: 1.6;
            max-width: 340px;
        }

        .guest-features {
            display: flex;
            flex-direction: column;
            gap: 0.875rem;
            margin-top: 2.5rem;
        }

        .guest-feature-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .guest-feature-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: rgba(37, 99, 235, 0.15);
            border: 1px solid rgba(37, 99, 235, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #60A5FA;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .guest-feature-text {
            font-size: 0.8125rem;
            color: rgba(255,255,255,0.65);
            line-height: 1.4;
        }

        .guest-footer {
            position: relative;
            z-index: 1;
            font-size: 0.75rem;
            color: rgba(255,255,255,0.25);
        }

        /* Right panel — form */
        .guest-panel-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
        }

        .guest-form-box {
            width: 100%;
            max-width: 420px;
        }

        .guest-form-header {
            margin-bottom: 2rem;
        }

        .guest-form-logo-mobile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.75rem;
        }

        @media (min-width: 1024px) {
            .guest-form-logo-mobile { display: none; }
        }

        .guest-form-logo-mobile img {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            object-fit: cover;
        }

        .guest-form-logo-mobile span {
            font-size: 1.125rem;
            font-weight: 800;
            color: var(--aq-text-primary);
            letter-spacing: -0.02em;
        }

        .guest-form-header h2 {
            font-size: 1.625rem;
            font-weight: 800;
            color: var(--aq-text-primary);
            letter-spacing: -0.025em;
            line-height: 1.2;
        }

        .guest-form-header p {
            font-size: 0.875rem;
            color: var(--aq-text-secondary);
            margin-top: 0.375rem;
        }
    </style>
</head>
<body>

<div class="guest-layout">

    {{-- Left Panel --}}
    <div class="guest-panel-left">

        {{-- Brand --}}
        <div class="guest-brand">
            <div class="guest-brand-logo">
                <img src="{{ asset('images/logo-aqualyze.png') }}" alt="Aqualyze">
            </div>
            <div>
                <div class="guest-brand-name">Aqualyze</div>
                <div class="guest-brand-sub">Smart Aquaculture</div>
            </div>
        </div>

        {{-- Hero --}}
        <div class="guest-hero">
            <div class="guest-hero-tag">
                <i class="bi bi-wifi"></i>
                IoT Monitoring Platform
            </div>
            <h1>Monitor Your<br><span>Water Quality</span><br>in Real Time</h1>
            <p>
                Aqualyze gives fish farmers and researchers precise,
                real-time insight into water temperature, pH levels,
                and turbidity — all from a single dashboard.
            </p>

            <div class="guest-features">
                <div class="guest-feature-item">
                    <div class="guest-feature-icon">
                        <i class="bi bi-thermometer-half"></i>
                    </div>
                    <span class="guest-feature-text">Live temperature, pH &amp; turbidity readings</span>
                </div>
                <div class="guest-feature-item">
                    <div class="guest-feature-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <span class="guest-feature-text">Historical trend charts and data export</span>
                </div>
                <div class="guest-feature-item">
                    <div class="guest-feature-icon">
                        <i class="bi bi-bell-fill"></i>
                    </div>
                    <span class="guest-feature-text">Automated status alerts for out-of-range values</span>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="guest-footer">
            &copy; {{ date('Y') }} Aqualyze &mdash; Capstone Project
        </div>

    </div>

    {{-- Right Panel (form slot) --}}
    <div class="guest-panel-right">
        <div class="guest-form-box">

            {{-- Mobile logo --}}
            <div class="guest-form-logo-mobile">
                <img src="{{ asset('images/logo-aqualyze.png') }}" alt="Aqualyze">
                <span>Aqualyze</span>
            </div>

            {{ $slot }}

        </div>
    </div>

</div>

</body>
</html>
