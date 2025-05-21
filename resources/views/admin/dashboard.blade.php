    <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>
       
        <div class="pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center gap-6">
                    <!-- Total Products Box -->
                    <div class="bg-white rounded-md p-6 w-full shadow flex flex-col items-center justify-center text-center">
                        <h3 class="font-semibold text-lg text-gray-700">{{ __('Total Products') }}</h3>
                        <div class="mt-2 flex items-center justify-center gap-2 text-2xl text-gray-900">
                            <i class="fas fa-box-open text-blue-500"></i>
                            <span>{{ $totalProducts }}</span>
                        </div>
                    </div>

                    <!-- Total Stock Box -->
                    <div class="bg-white rounded-md p-6 w-full shadow flex flex-col items-center justify-center text-center">
                        <h3 class="font-semibold text-lg text-gray-700">{{ __('Total Stock') }}</h3>
                        <div class="mt-2 flex items-center justify-center gap-2 text-2xl text-gray-900">
                            <i class="fas fa-chart-bar text-green-500"></i>
                            <span>{{ $totalStock }}</span>
                        </div>
                    </div>

                    
                </div>
            </div>
        </div>

        <div class="pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                    <div class="flex flex-col lg:flex-row gap-6">
                        <!-- Chart Section -->
                        <div class="w-full lg:w-2/3 bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                                <i class="fas fa-boxes text-blue-500"></i> Stock Overview
                            </h3>
                            <canvas id="stockChart" height="120"></canvas>
                        </div>

                   

                      <!-- Quick Actions -->
                      <div class="w-full lg:w-1/3 bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-lg font-semibold text-gray-800  flex items-center gap-2">
                                <i class="fas fa-bolt text-yellow-500"></i> Quick Actions
                            </h3>
                            <div class="flex flex-col gap-4 mt-10">
                                <a href="{{ route('admin.inventory.create') }}"
                                class="inline-flex items-center justify-center w-64 mx-auto px-4 py-2 bg-black text-white border border-indigo-800 rounded-md text-sm font-medium hover:bg-black transition">
                                    <i class="fas fa-plus mr-2"></i> Add New Inventory Item
                                </a>

                                <a href="{{ route('admin.inventory.index') }}"
                                class="inline-flex items-center justify-center w-64 mx-auto px-4 py-2 bg-black text-white border border-blue-800 rounded-md text-sm font-medium hover:bg-black transition">
                                    <i class="fas fa-list mr-2"></i> View Inventory List
                                </a>

                                <a href="{{ route('admin.inventory.inventoryActions') }}"
                                class="inline-flex items-center justify-center w-64 mx-auto px-4 py-2 bg-black text-white border border-green-800 rounded-md text-sm font-medium hover:bg-black transition">
                                    <i class="fas fa-tasks mr-2"></i> View Inventory Logs
                                </a>

                                  <!-- New Reports Button -->
                                <a href="{{ route('admin.inventory.reports.index') }}"
                                    class="inline-flex items-center justify-center w-64 mx-auto px-4 py-2 bg-black text-white border border-red-800 rounded-md text-sm font-medium hover:bg-black transition">
                                    <i class="fas fa-chart-line mr-2"></i> View Reports
                                </a>
                              
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="pt-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                     <!-- Monthly Sales Line Graph -->
                    <div class="w-full bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                            <i class="fas fa-chart-line text-green-500"></i> Monthly Sales
                        </h3>
                        <canvas id="salesLineChart" height="120"></canvas>
                    </div>
                  
                    </div>
                </div>
            </div>

        {{-- Chart.js CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        {{-- Chart Script --}}
        <script>
            const ctx = document.getElementById('stockChart').getContext('2d');
            const stockChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($productNames) !!},
                    datasets: [{
                        label: 'Stock Quantity',
                        data: {!! json_encode($stockCounts) !!},
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 10
                            }
                        }
                    }
                }
            });
        </script>

        <script>
    const salesCtx = document.getElementById('salesLineChart').getContext('2d');
    const salesLineChart = new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: [
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ],
            datasets: [{
                label: 'Monthly Sales (₱)',
                data: {!! json_encode($fullMonthlySales) !!},
                fill: false,
                borderColor: 'rgba(34, 197, 94, 1)', // Tailwind green-500
                backgroundColor: 'rgba(34, 197, 94, 0.2)',
                tension: 0.3,
                pointBackgroundColor: 'rgba(34, 197, 94, 1)',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₱' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
</script>

    </x-app-layout>