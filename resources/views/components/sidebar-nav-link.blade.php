@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'flex justify-center items-center bg-primary text-darkgray lg:w-11/12 block py-2 lg:py-4 text-center text-2xl font-extrabold lg:rounded-r-xl my-2 lg:my-'
                : 'flex justify-center items-center text-primary lg:w-11/12 block py-2 lg:py-4 text-center text-2xl font-extrabold my-2 lg:my-4 hover:bg-primary hover:text-darkgray hover:rounded-r-xl';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <div class="w-3/4 text-left">
        {{ $slot }}
    </div>
</a>
