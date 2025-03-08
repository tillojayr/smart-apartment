<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-electric-orange-800 leading-tight">
            {{ __('Control Panel') }}
        </h2>
    </x-slot>

    <div>
        <livewire:control-panel />
    </div>

</x-app-layout>
