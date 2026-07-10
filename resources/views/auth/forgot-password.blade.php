<x-guest-layout>

    <div class="guest-form-header">
        <h2>Reset Password</h2>
        <p>Enter your email address and we'll send you a reset link.</p>
    </div>

    @if (session('status'))
        <div class="aq-alert aq-alert-success" style="margin-bottom:1.25rem;">
            <i class="bi bi-check-circle-fill aq-alert-icon"></i>
            <span class="aq-alert-text">{{ session('status') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

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

        <button type="submit" class="aq-btn aq-btn-primary aq-btn-full">
            <i class="bi bi-envelope-fill"></i>
            Send Reset Link
        </button>

        <div style="margin-top:1.25rem;text-align:center;">
            <a href="{{ route('login') }}"
               style="font-size:0.8125rem;color:var(--aq-primary);text-decoration:none;display:inline-flex;align-items:center;gap:0.375rem;">
                <i class="bi bi-arrow-left"></i>
                Back to Sign In
            </a>
        </div>
    </form>

</x-guest-layout>
