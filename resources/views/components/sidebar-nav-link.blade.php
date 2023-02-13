@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'bg-primary text-darkgray lg:w-11/12 block py-2 lg:py-4 text-center text-2xl font-extrabold lg:rounded-r-xl my-2 lg:my-4'
                : 'text-primary lg:w-11/12 block py-2 lg:py-4 text-center text-2xl font-extrabold my-2 lg:my-4';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
