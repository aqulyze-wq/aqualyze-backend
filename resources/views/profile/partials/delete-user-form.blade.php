<section>

    <p style="font-size:0.875rem;color:var(--aq-text-secondary);margin-bottom:1.25rem;line-height:1.5;">
        Setelah akun dihapus, semua data dan sumber daya akan dihapus permanen.
        Pastikan Anda telah menyimpan data penting sebelum melanjutkan.
    </p>

    <button
        type="button"
        class="aq-btn aq-btn-danger"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        <i class="bi bi-trash3-fill"></i>
        Hapus Akun Saya
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" style="padding:1.75rem;">
            @csrf
            @method('delete')

            <div style="display:flex;align-items:flex-start;gap:1rem;margin-bottom:1.25rem;">
                <div style="width:44px;height:44px;border-radius:10px;background:#FEF2F2;border:1px solid #FECACA;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bi bi-exclamation-triangle-fill" style="color:var(--aq-danger);font-size:1.1rem;"></i>
                </div>
                <div>
                    <div style="font-size:1rem;font-weight:700;color:var(--aq-text-primary);margin-bottom:0.375rem;">
                        Hapus akun ini?
                    </div>
                    <p style="font-size:0.8125rem;color:var(--aq-text-secondary);line-height:1.5;margin:0;">
                        Tindakan ini tidak dapat dibatalkan. Semua data akan dihapus secara permanen.
                        Masukkan password untuk konfirmasi.
                    </p>
                </div>
            </div>

            <div class="aq-form-group">
                <label for="delete_password" class="aq-label">Konfirmasi Password</label>
                <div style="position:relative;">
                    <i class="bi bi-lock" style="position:absolute;left:0.875rem;top:50%;transform:translateY(-50%);color:var(--aq-text-muted);font-size:0.9rem;pointer-events:none;"></i>
                    <input
                        id="delete_password"
                        name="password"
                        type="password"
                        class="aq-input {{ $errors->userDeletion->has('password') ? 'error' : '' }}"
                        style="padding-left:2.5rem;"
                        placeholder="Masukkan password Anda">
                </div>
                @if($errors->userDeletion->has('password'))
                    <div class="aq-input-error">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        {{ $errors->userDeletion->first('password') }}
                    </div>
                @endif
            </div>

            <div style="display:flex;justify-content:flex-end;gap:0.75rem;margin-top:1.25rem;">
                <button type="button" class="aq-btn aq-btn-outline" x-on:click="$dispatch('close')">
                    Batal
                </button>
                <button type="submit" class="aq-btn aq-btn-danger">
                    <i class="bi bi-trash3-fill"></i>
                    Ya, Hapus Akun
                </button>
            </div>

        </form>
    </x-modal>

</section>
