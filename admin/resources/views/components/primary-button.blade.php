<button {{ $attributes->merge(['type' => 'submit', 'class' => 'cpt-button']) }}>
    {{ $slot }}
</button>
