@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-sm text-black-700']) }}>
    {{ $value ?? $slot }}
</label>
