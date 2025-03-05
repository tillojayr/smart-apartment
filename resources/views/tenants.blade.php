<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-electric-orange-800 leading-tight">
            {{ __('Tenants') }}
        </h2>
    </x-slot>
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-electric-orange-200">
            <div class="p-6">
                <livewire:tenants />
            </div>
        </div>
    </div>
</x-app-layout>
