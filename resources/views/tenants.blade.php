<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-electric-orange-800 leading-tight">
            {{ __('Tenants') }}
        </h2>
    </x-slot>

    <div>
        <livewire:tenants />
    </div>

</x-app-layout>
