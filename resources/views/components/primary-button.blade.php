<button {{ $attributes->merge(['type' => 'submit', 'class' => 'aq-btn aq-btn-primary']) }}>
    {{ $slot }}
</button>
