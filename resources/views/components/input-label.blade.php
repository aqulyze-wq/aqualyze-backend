@props(['value'])

<label {{ $attributes->merge(['class' => 'aq-label']) }}>
    {{ $value ?? $slot }}
</label>
