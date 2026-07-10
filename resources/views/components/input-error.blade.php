@props(['messages'])

@if ($messages)
    @foreach ((array) $messages as $message)
        <div {{ $attributes->merge(['class' => 'aq-input-error']) }}>
            <i class="bi bi-exclamation-circle-fill"></i>
            {{ $message }}
        </div>
    @endforeach
@endif
