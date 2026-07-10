<x-guest-layout>

    <div class="guest-form-header">
        <h2>Confirm Password</h2>
        <p>This is a secure area. Please confirm your password before continuing.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" style="display:flex;flex-direction:column;gap:1.25rem;">
        @csrf

        <div class="aq-form-group" style="margin-bottom:0;">
            <label for="password" class="aq-label">Password</label>
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
                <div class="aq-input-error"><i class="bi bi-exclamation-circle-fill"></i>{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="aq-btn aq-btn-primary aq-btn-full">
            <i class="bi bi-shield-lock-fill"></i>
            Confirm
        </button>

    </form>

</x-guest-layout>
