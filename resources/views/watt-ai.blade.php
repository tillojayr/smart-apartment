<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-electric-orange-800 leading-tight">
            {{ __('Watt AI') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <livewire:watt-ai />
        </div>
    </div>

</x-app-layout>
