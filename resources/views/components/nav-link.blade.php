@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-electric-orange-400 text-sm font-medium leading-5 text-electric-orange-900 focus:outline-none focus:border-electric-orange-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-electric-orange-700 hover:border-electric-orange-300 focus:outline-none focus:text-electric-orange-700 focus:border-electric-orange-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
