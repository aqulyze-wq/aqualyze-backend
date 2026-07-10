<section>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" style="display:flex;flex-direction:column;gap:1.125rem;">
        @csrf
        @method('patch')

        <div class="aq-form-group" style="margin-bottom:0;">
            <label for="name" class="aq-label">Nama Lengkap</label>
            <div style="position:relative;">
                <i class="bi bi-person" style="position:absolute;left:0.875rem;top:50%;transform:translateY(-50%);color:var(--aq-text-muted);font-size:0.9rem;pointer-events:none;"></i>
                <input
                    id="name"
                    name="name"
                    type="text"
                    class="aq-input {{ $errors->has('name') ? 'error' : '' }}"
                    style="padding-left:2.5rem;"
                    value="{{ old('name', $user->name) }}"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Masukkan nama lengkap">
            </div>
            @error('name')
                <div class="aq-input-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="aq-form-group" style="margin-bottom:0;">
            <label for="email" class="aq-label">Alamat Email</label>
            <div style="position:relative;">
                <i class="bi bi-envelope" style="position:absolute;left:0.875rem;top:50%;transform:translateY(-50%);color:var(--aq-text-muted);font-size:0.9rem;pointer-events:none;"></i>
                <input
                    id="email"
                    name="email"
                    type="email"
                    class="aq-input {{ $errors->has('email') ? 'error' : '' }}"
                    style="padding-left:2.5rem;"
                    value="{{ old('email', $user->email) }}"
                    required
                    autocomplete="username"
                    placeholder="admin@aqualyze.id">
            </div>
            @error('email')
                <div class="aq-input-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ $message }}
                </div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="aq-alert aq-alert-warning" style="margin-top:0.75rem;">
                    <i class="bi bi-exclamation-triangle-fill aq-alert-icon"></i>
                    <div class="aq-alert-text">
                        Email belum terverifikasi.
                        <button form="send-verification"
                                style="background:none;border:none;color:#B45309;font-weight:600;cursor:pointer;padding:0;font-size:inherit;text-decoration:underline;">
                            Kirim ulang email verifikasi.
                        </button>
                        @if (session('status') === 'verification-link-sent')
                            <div style="margin-top:0.25rem;color:#15803D;font-size:0.8125rem;font-weight:500;">
                                Link verifikasi baru telah dikirim.
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <div style="display:flex;align-items:center;gap:0.75rem;padding-top:0.25rem;">
            <button type="submit" class="aq-btn aq-btn-primary">
                <i class="bi bi-check2"></i>
                Simpan Perubahan
            </button>
            @if (session('status') === 'profile-updated')
                <span style="font-size:0.8125rem;color:var(--aq-success);display:flex;align-items:center;gap:0.25rem;">
                    <i class="bi bi-check-circle-fill"></i>
                    Tersimpan
                </span>
            @endif
        </div>

    </form>

</section>
