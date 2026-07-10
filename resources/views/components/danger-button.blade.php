<button {{ $attributes->merge(['type' => 'submit', 'class' => 'aq-btn aq-btn-danger']) }}>
    {{ $slot }}
</button>
