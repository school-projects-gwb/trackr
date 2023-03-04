@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'flex justify-center items-center bg-primary text-darkgray lg:w-11/12 block py-2 lg:py-4 text-center text-xl font-extrabold lg:rounded-r-xl my-1 lg:my-'
                : 'flex justify-center items-center text-primary lg:w-11/12 block py-2 lg:py-4 text-center text-xl font-extrabold my-1 hover:bg-primary hover:text-darkgray hover:rounded-r-xl';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <div class="w-3/4 text-left">
        {{ $slot }}
    </div>
</a>
