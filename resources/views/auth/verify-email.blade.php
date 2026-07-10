<x-guest-layout>

    <div class="guest-form-header">
        <h2>Verify Your Email</h2>
        <p>One more step before accessing your dashboard.</p>
    </div>

    <div class="aq-alert aq-alert-info" style="margin-bottom:1.5rem;">
        <i class="bi bi-envelope-fill aq-alert-icon"></i>
        <span class="aq-alert-text">
            Thanks for signing up! Please verify your email by clicking the link we sent you.
            If you didn't receive it, click the button below to resend.
        </span>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="aq-alert aq-alert-success" style="margin-bottom:1.5rem;">
            <i class="bi bi-check-circle-fill aq-alert-icon"></i>
            <span class="aq-alert-text">A new verification link has been sent to your email address.</span>
        </div>
    @endif

    <div style="display:flex;flex-direction:column;gap:0.75rem;">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="aq-btn aq-btn-primary aq-btn-full">
                <i class="bi bi-envelope-fill"></i>
                Resend Verification Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="aq-btn aq-btn-ghost aq-btn-full" style="width:100%;">
                <i class="bi bi-box-arrow-right"></i>
                Log Out
            </button>
        </form>
    </div>

</x-guest-layout>
