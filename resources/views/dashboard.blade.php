<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-electric-orange-600 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-16 mt-5 bg-gradient-to-br from-electric-orange-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 min-h-[200px] p-10">
                    <div class="transform transition-all hover:scale-105 duration-300">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl border-t-4 border-electric-orange-500 h-full">
                            <div class="p-8">
                                <h3 class="text-xl font-bold text-electric-orange-600 mb-3">Feedback Report</h3>
                                <p class="text-gray-600 mb-2">User's feedback</p>
                                <p class="text-gray-500">View the feedback by customers</p>
                            </div>
                        </div>
                    </div>

                    <div class="transform transition-all hover:scale-105 duration-300">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl border-t-4 border-electric-orange-500 h-full">
                            <div class="p-8">
                                <h3 class="text-xl font-bold text-electric-orange-600 mb-3">Smart Controls</h3>
                                <p class="text-gray-600 mb-2">Device Management</p>
                                <p class="text-gray-500">Control your smart devices</p>
                            </div>
                        </div>
                    </div>

                    <div class="transform transition-all hover:scale-105 duration-300">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl border-t-4 border-electric-orange-500 h-full">
                            <div class="p-8">
                                <h3 class="text-xl font-bold text-electric-orange-600 mb-3">Energy Usage</h3>
                                <p class="text-gray-600 mb-2">Consumption Statistics</p>
                                <p class="text-gray-500">Monitor your energy usage</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
