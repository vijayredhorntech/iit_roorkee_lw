@props(['value'])

<label {{ $attributes->merge(['class' => 'font-semibold text-primary']) }}>
    {{ $value ?? $slot }}
</label>
