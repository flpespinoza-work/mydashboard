@props([
    'value' => ''
])

<th
scope="col"
{{ $attributes->merge(['class' => 'px-3 py-3 text-xs font-medium tracking-wider text-left capitalize text-gray-dark lg:py-3 lg:px-6']) }}>
    {{ $value ?? $slot }}
</th>
