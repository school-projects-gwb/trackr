<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-4 py-2 bg-secondary hover:bg-secondary-light text-primary rounded-md']) }}>
    {{ $slot }}
</button>
