<div class="px-sm-5">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <!-- Owner/Admin Card -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div>
                        <h2 class="text-2xl font-semibold text-electric-orange-800">Visual Data Overview</h2>
                    </div>
                    <div class="mt-4 md:mt-0 flex flex-col items-end gap-4">
                        <div class="bg-electric-orange-50 p-4 rounded-lg">
                            <p class="text-electric-orange-800"><span class="font-medium">Email:</span>
                                {{ $owner->email }}</p>
                            <p class="text-electric-orange-800"><span class="font-medium">Total Rooms:</span>
                                {{ $rooms->count() }}</p>
                        </div>
                        <a href="{{ route('visual-data.room', 0) }}"
                            class="inline-flex items-center justify-center px-4 py-2 bg-electric-orange-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-electric-orange-600 focus:bg-electric-orange-600 active:bg-electric-orange-700 focus:outline-none focus:ring-2 focus:ring-electric-orange-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            View Visual Data
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rooms Grid -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach ($rooms as $room)
                        <div
                            class="bg-white p-6 rounded-lg shadow-md border border-electric-orange-200 flex flex-col h-full">
                            <div class="flex-grow">
                                <h3 class="text-lg font-semibold text-electric-orange-800 mb-4">Room
                                    {{ $room->room_number }}</h3>
                                <div class="mb-4">
                                    <p class="text-gray-600"><span class="font-medium">Tenant:</span> <span
                                            class="text-electric-orange-800">{{ $room->tenant ?? 'Vacant' }}</span></p>
                                    <p class="text-gray-600"><span class="font-medium">Current Bill:</span> <span
                                            class="text-electric-orange-800">₱{{ number_format($room->consumed * Auth()->rate() ?? 0, 2) }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <a href="{{ route('visual-data.room', $room->id) }}"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-electric-orange-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-electric-orange-600 focus:bg-electric-orange-600 active:bg-electric-orange-700 focus:outline-none focus:ring-2 focus:ring-electric-orange-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    View Visual Data
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
