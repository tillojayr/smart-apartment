<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-electric-orange-800 leading-tight">
            {{ __('Room Visual Data') }}
        </h2>
    </x-slot>

    <livewire:visual-data-room :roomId="$roomId" />
</x-app-layout>
