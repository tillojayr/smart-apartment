<div>
    <div class="container mx-auto px-4 py-4">
        @if (session()->has('message'))
            <div class="alert bg-electric-orange-100 border-electric-orange-400 text-electric-orange-700 alert-dismissible fade show"
                role="alert">
                {{ __(session('message')) }}
                <button type="button" class="btn-close text-electric-orange-700" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert bg-red-100 border-red-400 text-red-700 px-4 py-3 alert-dismissible fade show"
                role="alert">
                {{ __(session('error')) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-electric-orange-200">
            <div class="p-6">
                <div class="bg-white shadow-sm rounded-lg border border-electric-orange-200">
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-electric-orange-200">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-6 py-3 bg-electric-orange-50 text-left text-xs font-medium text-electric-orange-800 uppercase tracking-wider">
                                            Room Number</th>
                                        <th
                                            class="px-6 py-3 bg-electric-orange-50 text-left text-xs font-medium text-electric-orange-800 uppercase tracking-wider">
                                            Name</th>
                                        <th
                                            class="px-6 py-3 bg-electric-orange-50 text-left text-xs font-medium text-electric-orange-800 uppercase tracking-wider">
                                            Start Date</th>
                                        <th
                                            class="px-6 py-3 bg-electric-orange-50 text-left text-xs font-medium text-electric-orange-800 uppercase tracking-wider">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-electric-orange-200">
                                    @foreach ($rooms as $room)
                                        <tr>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-900">
                                                {{ $room->room_number }}
                                            </td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-900">
                                                {{ $room->tenant }}</td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-900">
                                                {{ \Carbon\CarbonImmutable::createFromFormat('Y-m-d H:i:s', $room->joined_at)->format('F j, Y') }}
                                            </td>
                                            <td class="px-6 py-2 whitespace-nowrap text-sm">
                                                <button
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-electric-orange-500 hover:bg-electric-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-electric-orange-500"
                                                    wire:click="tenantDetails({{ $room->id }})">
                                                    View
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if ($tenantDetailsModal)
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-50">
                        <div class="fixed inset-0 z-10 overflow-y-auto">
                            <div class="flex min-h-full items-start justify-center p-4 text-start sm:p-0">
                                <div
                                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-4 sm:w-full sm:max-w-lg">
                                    <div
                                        class="bg-electric-orange-50 px-4 py-3 sm:px-6 border-b border-electric-orange-200">
                                        <h3 class="text-lg font-medium leading-6 text-electric-orange-900">Tenant
                                            Details</h3>
                                    </div>
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <form>
                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700">Room
                                                    Number</label>
                                                <input type="text"
                                                    class="mt-1 block w-full rounded-md border-electric-orange-300 shadow-sm focus:border-electric-orange-500 focus:ring-electric-orange-500"
                                                    wire:model="room_number">
                                            </div>
                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700">Name</label>
                                                <input type="text"
                                                    class="mt-1 block w-full rounded-md border-electric-orange-300 shadow-sm focus:border-electric-orange-500 focus:ring-electric-orange-500"
                                                    wire:model="tenant">
                                            </div>
                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700">Mobile app
                                                    password</label>
                                                <input type="text"
                                                    class="mt-1 block w-full rounded-md border-electric-orange-300 shadow-sm focus:border-electric-orange-500 focus:ring-electric-orange-500"
                                                    wire:model="password">
                                            </div>
                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700">Start
                                                    Date</label>
                                                <input type="date"
                                                    class="mt-1 block w-full rounded-md border-electric-orange-300 shadow-sm focus:border-electric-orange-500 focus:ring-electric-orange-500"
                                                    wire:model="joined_at">
                                            </div>
                                        </form>
                                    </div>
                                    <div
                                        class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-electric-orange-200">
                                        <button type="button"
                                            class="btn-sm inline-flex w-full justify-center rounded-md border border-transparent bg-electric-orange-500 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-electric-orange-600 focus:outline-none focus:ring-2 focus:ring-electric-orange-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                                            wire:click="save()">Save</button>
                                        <button type="button"
                                            class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-electric-orange-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                            wire:click="closeTenantDetailModal()">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
