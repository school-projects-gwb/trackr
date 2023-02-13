@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-black text-xl font-bold']) }}>
    {{ $value ?? $slot }}
</label>
