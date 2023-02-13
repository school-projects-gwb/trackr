<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-4 py-2 border border-secondary hover:bg-secondary-light text-secondary rounded-md']) }}>
    {{ $slot }}
</button>
