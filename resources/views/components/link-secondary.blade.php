<a {{ $attributes->merge(['type' => 'submit', 'class' => 'px-4 py-2 border border-secondary hover:bg-secondary text-secondary hover:text-primary rounded-md cursor-pointer']) }}>
    {{ $slot }}
</a>
