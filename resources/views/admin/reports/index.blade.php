<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Monthly Inventory Report') }}
        </h2>
    </x-slot>

    <div class="pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                 <div class="mb-4 flex flex-col sm:flex-row sm:gap-4 sm:justify-between">
                        <!-- Back Button -->
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-900 active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-500 disabled:opacity-25 transition ease-in-out duration-150 mb-4 sm:mb-0">
                            <i class="fas fa-arrow-left mr-2"></i> {{ __('Back to Dashboard') }}
                        </a>

                        <!-- Export CSV -->
                          <a href="{{ route('admin.inventory.reports.export', ['month' => request('month')]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-900 active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-500 disabled:opacity-25 transition ease-in-out duration-150 mb-4 sm:mb-0">
                            <i class="fas fa-file-csv mr-2"></i>  {{ __('Export CSV') }}
                        </a>    
                    </div>

            {{-- Export & Filter --}}
            <div class="flex flex-col sm:flex-row sm:justify-between items-center gap-4 mt-4">
                <form method="GET" action="{{ route('admin.inventory.reports.index') }}" class="w-full sm:w-1/2">
                    <input 
                        type="month" 
                        name="month" 
                        value="{{ request('month', now()->format('Y-m')) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-indigo-200"
                        placeholder="Select month"
                        onchange="this.form.submit()" 
                    >
                </form>

              
            </div>

            {{-- Report Table --}}
            <div class="bg-white shadow rounded-lg overflow-x-auto mt-6">
                <table class="min-w-full table-auto text-sm text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 font-medium text-gray-600 uppercase tracking-wider">Item Name</th>
                            <th class="px-6 py-3 font-medium text-gray-600 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 font-medium text-gray-600 uppercase tracking-wider text-center">Stock</th>
                            <th class="px-6 py-3 font-medium text-gray-600 uppercase tracking-wider text-right">Price (₱)</th>
                            <th class="px-6 py-3 font-medium text-gray-600 uppercase tracking-wider text-right">Total Value</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($inventoryItems as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->category ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">{{ $item->quantity }}</td>
                                <td class="px-6 py-4 text-right">₱{{ number_format($item->price_php, 2) }}</td>
                                <td class="px-6 py-4 text-right">₱{{ number_format($item->price_php * $item->quantity, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No report data for this month.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
          </div>
        </div>
    </div>
</x-app-layout>
