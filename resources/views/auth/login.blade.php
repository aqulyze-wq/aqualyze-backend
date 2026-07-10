<x-guest-layout>

    <div class="guest-form-header">
        <h2>Welcome back</h2>
        <p>Sign in to your Aqualyze account</p>
    </div>

    {{-- Session Status --}}
    @if (session('status'))
        <div class="aq-alert aq-alert-info" style="margin-bottom:1.25rem;">
            <i class="bi bi-info-circle-fill aq-alert-icon"></i>
            <span class="aq-alert-text">{{ session('status') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        {{-- Email --}}
        <div class="aq-form-group">
            <label for="email" class="aq-label">Email Address</label>
            <div style="position:relative;">
                <i class="bi bi-envelope" style="position:absolute;left:0.875rem;top:50%;transform:translateY(-50%);color:var(--aq-text-muted);font-size:0.9rem;pointer-events:none;"></i>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="admin@aqualyze.id"
                    class="aq-input {{ $errors->has('email') ? 'error' : '' }}"
                    style="padding-left:2.5rem;">
            </div>
            @error('email')
                <div class="aq-input-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="aq-form-group">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.375rem;">
                <label for="password" class="aq-label" style="margin-bottom:0;">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       style="font-size:0.75rem;color:var(--aq-primary);font-weight:500;text-decoration:none;">
                        Forgot password?
                    </a>
                @endif
            </div>
            <div style="position:relative;">
                <i class="bi bi-lock" style="position:absolute;left:0.875rem;top:50%;transform:translateY(-50%);color:var(--aq-text-muted);font-size:0.9rem;pointer-events:none;"></i>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Enter your password"
                    class="aq-input {{ $errors->has('password') ? 'error' : '' }}"
                    style="padding-left:2.5rem;">
            </div>
            @error('password')
                <div class="aq-input-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Remember Me --}}
        <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:1.5rem;">
            <input
                id="remember_me"
                type="checkbox"
                name="remember"
                style="width:16px;height:16px;border-radius:4px;accent-color:var(--aq-primary);cursor:pointer;">
            <label for="remember_me" style="font-size:0.8125rem;color:var(--aq-text-secondary);cursor:pointer;user-select:none;">
                Remember me for 30 days
            </label>
        </div>

        {{-- Submit --}}
        <button type="submit" class="aq-btn aq-btn-primary aq-btn-full aq-btn-lg">
            <i class="bi bi-box-arrow-in-right"></i>
            Sign In
        </button>

    </form>

    <p style="margin-top:1.75rem;text-align:center;font-size:0.8125rem;color:var(--aq-text-muted);">
        Aqualyze &mdash; Smart Aquaculture Monitoring System
    </p>

</x-guest-layout>
