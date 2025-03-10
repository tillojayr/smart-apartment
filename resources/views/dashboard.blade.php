<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-electric-orange-600 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="pt-1 pb-10 mt-1 bg-gradient-to-br from-electric-orange-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <!-- Welcome Card -->
                <div class="mb-5 m-5">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl border-t-4 border-electric-orange-500">
                        <div class="p-8">
                            <h3 class="text-2xl font-bold text-electric-orange-600 mb-3">Welcome to SmartWatt</h3>
                            <p class="text-gray-600 mb-2">Hello <span class="text-electric-orange-500">{{ Auth::user()->name }},</span></p>
                            <p class="text-gray-500">Manage your smart apartment features and monitor your energy consumption all in one place.</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 min-h-[200px] p-10">
                    <a href="{{ route('tenants') }}" class="transform transition-all hover:scale-105 duration-300">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl border-t-4 border-electric-orange-500 h-full">
                            <div class="p-8">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h3 class="text-xl font-bold text-electric-orange-600 mb-3">Tenants</h3>
                                        <p class="text-gray-600 mb-2">Users management</p>
                                        <p class="text-gray-500">View all tenant's information</p>
                                    </div>
                                    <img src="{{ asset('illustrations/tenant.svg') }}" alt="Tenants" class="w-28 h-28">
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('control-panel') }}" class="transform transition-all hover:scale-105 duration-300">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl border-t-4 border-electric-orange-500 h-full">
                            <div class="p-8">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h3 class="text-xl font-bold text-electric-orange-600 mb-3">Control Panel</h3>
                                        <p class="text-gray-600 mb-2">Device Management</p>
                                        <p class="text-gray-500">Control your smart devices</p>
                                    </div>
                                    <img src="{{ asset('illustrations/control-panel.svg') }}" alt="Tenants" class="w-28 h-28">
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('visual-data') }}" class="transform transition-all hover:scale-105 duration-300">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl border-t-4 border-electric-orange-500 h-full">
                            <div class="p-8">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h3 class="text-xl font-bold text-electric-orange-600 mb-3">Data Visualization</h3>
                                        <p class="text-gray-600 mb-2">Consumption Statistics</p>
                                        <p class="text-gray-500">Monitor your energy usage</p>
                                    </div>
                                    <img src="{{ asset('illustrations/visual-data.svg') }}" alt="Tenants" class="w-28 h-28">
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
