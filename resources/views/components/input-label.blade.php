@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-electric-orange-500']) }}>
    {{ $value ?? $slot }}
</label>
