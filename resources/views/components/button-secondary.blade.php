<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-4 py-2 border border-secondary hover:bg-secondary hover:text-primary text-secondary rounded-md']) }}>
    {{ $slot }}
</button>
