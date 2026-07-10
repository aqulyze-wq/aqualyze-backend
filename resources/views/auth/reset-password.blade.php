<x-guest-layout>

    <div class="guest-form-header">
        <h2>Set New Password</h2>
        <p>Choose a strong password for your account.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" style="display:flex;flex-direction:column;gap:1.125rem;">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        {{-- Email --}}
        <div class="aq-form-group" style="margin-bottom:0;">
            <label for="email" class="aq-label">Email Address</label>
            <div style="position:relative;">
                <i class="bi bi-envelope" style="position:absolute;left:0.875rem;top:50%;transform:translateY(-50%);color:var(--aq-text-muted);font-size:0.9rem;pointer-events:none;"></i>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', $request->email) }}"
                    required
                    autofocus
                    autocomplete="username"
                    class="aq-input {{ $errors->has('email') ? 'error' : '' }}"
                    style="padding-left:2.5rem;">
            </div>
            @error('email')
                <div class="aq-input-error"><i class="bi bi-exclamation-circle-fill"></i>{{ $message }}</div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="aq-form-group" style="margin-bottom:0;">
            <label for="password" class="aq-label">New Password</label>
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
                    placeholder="Ulangi password baru"
                    class="aq-input {{ $errors->has('password_confirmation') ? 'error' : '' }}"
                    style="padding-left:2.5rem;">
            </div>
            @error('password_confirmation')
                <div class="aq-input-error"><i class="bi bi-exclamation-circle-fill"></i>{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="aq-btn aq-btn-primary aq-btn-full aq-btn-lg" style="margin-top:0.375rem;">
            <i class="bi bi-lock-fill"></i>
            Reset Password
        </button>

    </form>

</x-guest-layout>
