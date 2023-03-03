@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'bg-white border border-gray-300 rounded-xl py-2 pl-4']) !!}>
