@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'bg-electric-orange-100 border-l-4 border-electric-orange-500 text-electric-orange-700 p-4']) }}>
        {{ $status }}
    </div>
@endif
