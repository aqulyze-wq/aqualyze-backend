@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'aq-alert aq-alert-success']) }}>
        <i class="bi bi-check-circle-fill aq-alert-icon"></i>
        <span class="aq-alert-text">{{ $status }}</span>
    </div>
@endif
