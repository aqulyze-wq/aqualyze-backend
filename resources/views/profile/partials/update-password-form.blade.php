<section>

    <p style="font-size:0.875rem;color:var(--aq-text-secondary);margin-bottom:1.25rem;line-height:1.5;">
        Gunakan password yang panjang dan acak untuk menjaga keamanan akun Anda.
    </p>

    <form method="post" action="{{ route('password.update') }}" style="display:flex;flex-direction:column;gap:1.125rem;">
        @csrf
        @method('put')

        <div class="aq-form-group" style="margin-bottom:0;">
            <label for="update_password_current_password" class="aq-label">Password Saat Ini</label>
            <div style="position:relative;">
                <i class="bi bi-lock" style="position:absolute;left:0.875rem;top:50%;transform:translateY(-50%);color:var(--aq-text-muted);font-size:0.9rem;pointer-events:none;"></i>
                <input
                    id="update_password_current_password"
                    name="current_password"
                    type="password"
                    class="aq-input {{ $errors->updatePassword->has('current_password') ? 'error' : '' }}"
                    style="padding-left:2.5rem;"
                    autocomplete="current-password"
                    placeholder="Password saat ini">
            </div>
            @if($errors->updatePassword->has('current_password'))
                <div class="aq-input-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ $errors->updatePassword->first('current_password') }}
                </div>
            @endif
        </div>

        <div class="aq-form-group" style="margin-bottom:0;">
            <label for="update_password_password" class="aq-label">Password Baru</label>
            <div style="position:relative;">
                <i class="bi bi-key" style="position:absolute;left:0.875rem;top:50%;transform:translateY(-50%);color:var(--aq-text-muted);font-size:0.9rem;pointer-events:none;"></i>
                <input
                    id="update_password_password"
                    name="password"
                    type="password"
                    class="aq-input {{ $errors->updatePassword->has('password') ? 'error' : '' }}"
                    style="padding-left:2.5rem;"
                    autocomplete="new-password"
                    placeholder="Minimal 8 karakter">
            </div>
            @if($errors->updatePassword->has('password'))
                <div class="aq-input-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ $errors->updatePassword->first('password') }}
                </div>
            @endif
        </div>

        <div class="aq-form-group" style="margin-bottom:0;">
            <label for="update_password_password_confirmation" class="aq-label">Konfirmasi Password Baru</label>
            <div style="position:relative;">
                <i class="bi bi-key-fill" style="position:absolute;left:0.875rem;top:50%;transform:translateY(-50%);color:var(--aq-text-muted);font-size:0.9rem;pointer-events:none;"></i>
                <input
                    id="update_password_password_confirmation"
                    name="password_confirmation"
                    type="password"
                    class="aq-input {{ $errors->updatePassword->has('password_confirmation') ? 'error' : '' }}"
                    style="padding-left:2.5rem;"
                    autocomplete="new-password"
                    placeholder="Ulangi password baru">
            </div>
            @if($errors->updatePassword->has('password_confirmation'))
                <div class="aq-input-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ $errors->updatePassword->first('password_confirmation') }}
                </div>
            @endif
        </div>

        <div style="display:flex;align-items:center;gap:0.75rem;padding-top:0.25rem;">
            <button type="submit" class="aq-btn aq-btn-primary">
                <i class="bi bi-lock-fill"></i>
                Ubah Password
            </button>
            @if (session('status') === 'password-updated')
                <span style="font-size:0.8125rem;color:var(--aq-success);display:flex;align-items:center;gap:0.25rem;">
                    <i class="bi bi-check-circle-fill"></i>
                    Password diperbarui
                </span>
            @endif
        </div>

    </form>

</section>
