@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'bg-white border-0 rounded-xl py-2 pl-4']) !!}>
