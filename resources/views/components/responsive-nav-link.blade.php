@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-electric-orange-400 text-left text-base font-medium text-electric-orange-700 bg-electric-orange-50 focus:outline-none focus:text-electric-orange-800 focus:bg-electric-orange-100 focus:border-electric-orange-700 transition duration-150 ease-in-out'
            : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-electric-orange-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-electric-orange-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
