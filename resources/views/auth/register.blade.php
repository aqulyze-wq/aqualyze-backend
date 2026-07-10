<x-guest-layout>

    <div class="guest-form-header">
        <h2>Create Account</h2>
        <p>Register a new Aqualyze administrator account.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" style="display:flex;flex-direction:column;gap:1.125rem;">
        @csrf

        {{-- Name --}}
        <div class="aq-form-group" style="margin-bottom:0;">
            <label for="name" class="aq-label">Full Name</label>
            <div style="position:relative;">
                <i class="bi bi-person" style="position:absolute;left:0.875rem;top:50%;transform:translateY(-50%);color:var(--aq-text-muted);font-size:0.9rem;pointer-events:none;"></i>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Your full name"
                    class="aq-input {{ $errors->has('name') ? 'error' : '' }}"
                    style="padding-left:2.5rem;">
            </div>
            @error('name')
                <div class="aq-input-error"><i class="bi bi-exclamation-circle-fill"></i>{{ $message }}</div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="aq-form-group" style="margin-bottom:0;">
            <label for="email" class="aq-label">Email Address</label>
            <div style="position:relative;">
                <i class="bi bi-envelope" style="position:absolute;left:0.875rem;top:50%;transform:translateY(-50%);color:var(--aq-text-muted);font-size:0.9rem;pointer-events:none;"></i>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="username"
                    placeholder="admin@aqualyze.id"
                    class="aq-input {{ $errors->has('email') ? 'error' : '' }}"
                    style="padding-left:2.5rem;">
            </div>
            @error('email')
                <div class="aq-input-error"><i class="bi bi-exclamation-circle-fill"></i>{{ $message }}</div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="aq-form-group" style="margin-bottom:0;">
            <label for="password" class="aq-label">Password</label>
            <div style="position:relative;">
                <i class="bi bi-lock" style="position:absolute;left:0.875rem;top:50%;transform:translateY(-50%);color:var(--aq-text-muted);font-size:0.9rem;pointer-events:none;"></i>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="Minimal 8 karakter"
                    class="aq-input {{ $errors->has('password') ? 'error' : '' }}"
                    style="padding-left:2.5rem;">
            </div>
            @error('password')
                <div class="aq-input-error"><i class="bi bi-exclamation-circle-fill"></i>{{ $message }}</div>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="aq-form-group" style="margin-bottom:0;">
            <label for="password_confirmation" class="aq-label">Confirm Password</label>
            <div style="position:relative;">
                <i class="bi bi-key-fill" style="position:absolute;left:0.875rem;top:50%;transform:translateY(-50%);color:var(--aq-text-muted);font-size:0.9rem;pointer-events:none;"></i>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Ulangi password"
                    class="aq-input {{ $errors->has('password_confirmation') ? 'error' : '' }}"
                    style="padding-left:2.5rem;">
            </div>
            @error('password_confirmation')
                <div class="aq-input-error"><i class="bi bi-exclamation-circle-fill"></i>{{ $message }}</div>
            @enderror
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.75rem;padding-top:0.25rem;">
            <a href="{{ route('login') }}"
               style="font-size:0.8125rem;color:var(--aq-primary);text-decoration:none;">
                Already have an account?
            </a>
            <button type="submit" class="aq-btn aq-btn-primary">
                <i class="bi bi-person-plus-fill"></i>
                Create Account
            </button>
        </div>

    </form>

</x-guest-layout>
