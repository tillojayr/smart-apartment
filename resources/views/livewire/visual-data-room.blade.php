<div class="py-1" x-data="{ roomId: @json($roomId), ownerId: @json($ownerId) }">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <!-- Back Button -->
        <div class="mt-2">
            <a href="{{ route('visual-data') }}"
               class="inline-flex items-center px-4 py-2 bg-electric-orange-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-electric-orange-600 focus:bg-electric-orange-600 active:bg-electric-orange-700 focus:outline-none focus:ring-2 focus:ring-electric-orange-500 focus:ring-offset-2 transition ease-in-out duration-150">
                ← Back to Rooms
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                @if($isAdmin)
                    <div class="mb-6">
                        <h2 class="text-2xl font-semibold text-electric-orange-800">Overall Consumption Data</h2>
                        <p class="text-gray-600">Summary of all rooms</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Total Bill Card -->
                        <div class="bg-white p-6 rounded-lg shadow-md border border-electric-orange-200">
                            <h3 class="text-lg font-semibold text-electric-orange-700 mb-2">Total Bill</h3>
                            <p class="text-3xl font-bold text-electric-orange-600">₱{{ number_format($totalBill ?? 0, 2) }}</p>
                        </div>

                        <!-- Total Consumption Card -->
                        <div class="bg-white p-6 rounded-lg shadow-md border border-electric-orange-200">
                            <h3 class="text-lg font-semibold text-electric-orange-700 mb-2">Total Consumption</h3>
                            <p class="text-3xl font-bold text-electric-orange-600">{{ number_format($totalConsumption ?? 0, 2) }} kWh</p>
                        </div>

                        <!-- Average Voltage Card -->
                        <div class="bg-white p-6 rounded-lg shadow-md border border-electric-orange-200">
                            <h3 class="text-lg font-semibold text-electric-orange-700 mb-2">Average Voltage</h3>
                            <p class="text-3xl font-bold text-electric-orange-600">{{ number_format($averageVoltage, 1) }}V</p>
                        </div>

                        <!-- Average Current Card -->
                        <div class="bg-white p-6 rounded-lg shadow-md border border-electric-orange-200">
                            <h3 class="text-lg font-semibold text-electric-orange-700 mb-2">Average Current</h3>
                            <p class="text-3xl font-bold text-electric-orange-600">{{ number_format($averageCurrent, 1) }}A</p>
                        </div>
                    </div>
                @else
                    <div class="mb-6">
                        <h2 class="text-2xl font-semibold text-electric-orange-800">Room {{ $room->room_number }} Data</h2>
                        <p class="text-gray-600">Tenant: {{ $room->tenant ?? 'Vacant' }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Current Bill Card -->
                        <div class="bg-white p-6 rounded-lg shadow-md border border-electric-orange-200">
                            <h3 class="text-lg font-semibold text-electric-orange-700 mb-2">Current Bill</h3>
                            <p class="text-3xl font-bold text-electric-orange-600">₱{{ number_format($room->bill ?? 0, 2) }}</p>
                        </div>

                        <!-- Voltage Card -->
                        <div class="bg-white p-6 rounded-lg shadow-md border border-electric-orange-200">
                            <h3 class="text-lg font-semibold text-electric-orange-700 mb-2">Current Voltage</h3>
                            <p class="text-3xl font-bold text-electric-orange-600">{{ $room->volts ?? 0 }}V</p>
                        </div>

                        <!-- Current Card -->
                        <div class="bg-white p-6 rounded-lg shadow-md border border-electric-orange-200">
                            <h3 class="text-lg font-semibold text-electric-orange-700 mb-2">Current Draw</h3>
                            <p class="text-3xl font-bold text-electric-orange-600">{{ $room->current ?? 0 }}A</p>
                        </div>
                    </div>
                @endif

                <div class="flex justify-between items-center mt-4">
                    <h3 class="text-lg font-semibold text-electric-orange-700">Data Range Selection</h3>
                    <div class="flex gap-4 items-center">
                        <div class="flex gap-2 items-center">
                            <label class="text-sm text-gray-600">From:</label>
                            <input type="date"
                                id="startDate"
                                value="{{ $startDate }}"
                                class="rounded-md border-gray-300 shadow-sm focus:border-electric-orange-500 focus:ring-electric-orange-500">
                        </div>
                        <div class="flex gap-2 items-center">
                            <label class="text-sm text-gray-600">To:</label>
                            <input type="date"
                                id="endDate"
                                value="{{ $endDate }}"
                                class="rounded-md border-gray-300 shadow-sm focus:border-electric-orange-500 focus:ring-electric-orange-500">
                        </div>
                    </div>
                </div>
                <!-- Chart Section -->
                <div class="mt-6 space-y-6">
                    <!-- Voltage Chart -->
                    <div class="bg-white p-6 rounded-lg shadow-md border border-electric-orange-200">
                        <h3 class="text-lg font-semibold text-electric-orange-700 mb-4">Voltage Data</h3>
                        <div id="voltageChart" style="height: 300px;"></div>
                    </div>

                    <!-- Current Chart -->
                    <div class="bg-white p-6 rounded-lg shadow-md border border-electric-orange-200">
                        <h3 class="text-lg font-semibold text-electric-orange-700 mb-4">Current Data</h3>
                        <div id="currentChart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let voltageChart, currentChart;
        let pollingInterval;
        const roomId = @json($roomId);
        const ownerId = @json($ownerId);
        console.log('Room ID:', roomId);
        console.log('Owner ID:', ownerId);

        async function fetchChartData(startDate, endDate) {
            try {
                console.log('Fetching chart data for room:', roomId, 'from', startDate, 'to', endDate);
                const response = await fetch(`/api/chart-data?owner_id=${ownerId}&room_id=${roomId}&start_date=${startDate}&end_date=${endDate}`, {
                    headers: {
                        'Accept': 'application/json',
                    }
                });
                return await response.json();
            } catch (error) {
                console.error('Error fetching chart data:', error);
                return null;
            }
        }

        document.addEventListener('DOMContentLoaded', async () => {
            const startDateInput = document.getElementById('startDate');
            const endDateInput = document.getElementById('endDate');

            async function updateChartData() {
                const startDate = startDateInput.value;
                const endDate = endDateInput.value;
                const chartData = await fetchChartData(startDate, endDate);
                if (chartData) {
                    requestAnimationFrame(() => {
                        updateCharts(chartData);
                    });
                }
            }

            // Initial chart setup
            const chartData = await fetchChartData(startDateInput.value, endDateInput.value);
            if (chartData) {
                initCharts(chartData);
            }

            // Event listeners for date inputs
            startDateInput.addEventListener('change', updateChartData);
            endDateInput.addEventListener('change', updateChartData);

            // Setup polling for real-time updates
            pollingInterval = setInterval(updateChartData, 5000);

            // Cleanup on page unload
            window.addEventListener('beforeunload', () => {
                if (pollingInterval) {
                    clearInterval(pollingInterval);
                }
            });
        });

        function initCharts(chartData) {
            const commonOptions = {
                chart: {
                    type: 'line',
                    height: 300,
                    animations: {
                        enabled: false
                    },
                    zoom: {
                        enabled: true,
                        type: 'x'
                    },
                    toolbar: {
                        show: true
                    }
                },
                stroke: {
                    curve: 'straight',
                    width: 2
                },
                markers: {
                    size: 5
                },
                xaxis: {
                    type: 'datetime',
                    tickAmount: 6,
                    labels: {
                        formatter: function(value, timestamp) {
                            return new Date(timestamp).toLocaleTimeString();
                        }
                    },
                    tooltip: {
                        formatter: function(value) {
                            return new Date(value).toLocaleString();
                        }
                    }
                },
                tooltip: {
                    shared: false,
                    intersect: true,
                    x: {
                        show: true,
                        format: 'HH:mm:ss'
                    }
                }
            };

            // Initialize voltage chart
            voltageChart = new ApexCharts(document.querySelector("#voltageChart"), {
                ...commonOptions,
                series: [{
                    name: 'Voltage',
                    data: chartData.voltage
                }],
                colors: ['#EA580C'],
                yaxis: {
                    title: {
                        text: 'Voltage (V)'
                    },
                    tickAmount: 5,
                    decimalsInFloat: 1,
                    forceNiceScale: true
                }
            });

            // Initialize current chart
            currentChart = new ApexCharts(document.querySelector("#currentChart"), {
                ...commonOptions,
                series: [{
                    name: 'Current',
                    data: chartData.current
                }],
                colors: ['#FB923C'],
                yaxis: {
                    title: {
                        text: 'Current (A)'
                    },
                    tickAmount: 5,
                    decimalsInFloat: 2,
                    forceNiceScale: true
                }
            });

            voltageChart.render();
            currentChart.render();
        }

        function updateCharts(newData) {
            if (voltageChart && currentChart) {
                voltageChart.updateSeries([{
                    name: 'Voltage',
                    data: newData.voltage
                }], true, false);

                currentChart.updateSeries([{
                    name: 'Current',
                    data: newData.current
                }], true, false);
            }
        }
    </script>
    @endpush
</div>
