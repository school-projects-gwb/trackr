@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'bg-primary text-darkgray w-11/12 block py-4 text-center text-2xl font-extrabold rounded-r-xl my-4'
                : 'text-primary w-11/12 block py-4 text-center text-2xl font-extrabold my-4';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
