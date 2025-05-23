<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventory List') }}
        </h2>
    </x-slot>

    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-auth-session-status class="mb-4" :status="session('success')" />

                    <div class="mb-4 flex flex-col sm:flex-row sm:gap-4 sm:justify-between">
                        <!-- Back Button -->
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-.5 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-900 active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-500 disabled:opacity-25 transition ease-in-out duration-150 mb-4 sm:mb-0">
                            <i class="fas fa-arrow-left mr-2"></i> {{ __('Back to Dashboard') }}
                        </a>

                        <!-- Live Search Bar -->
                        <form method="GET" action="{{ route('admin.inventory.index') }}" class="inline-flex items-center space-x-2 mb-4 sm:mb-0">
                            <input type="text" name="search" id="live-search-input" value="{{ request()->query('search') }}" class="px-4 py-2 border border-gray-500 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Search inventory..." autocomplete="off" />
                        </form>
                    </div>

                    <!-- <div class="mb-4 flex flex-col sm:flex-row sm:gap-4">
                        <a href="{{ route('admin.inventory.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-900 active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-500 disabled:opacity-25 transition ease-in-out duration-150">
                            <i class="fas fa-plus mr-2"></i> {{ __('Create New Inventory Item') }}
                        </a>
                        <a href="{{ route('admin.inventory.inventoryActions') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-900 active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-500 disabled:opacity-25 transition ease-in-out duration-150">
                            <i class="fas fa-tasks mr-2"></i> {{ __('View Inventory Actions') }}
                        </a>
                    </div> -->

                    @if ($inventoryItems->isEmpty())
                        <p>{{ __('No inventory items found.') }}</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                        {{ __('Name') }}
                                    </th>
                                    <!-- <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                        {{ __('Description') }}
                                    </th> -->
                                    <th scope="col" class="px-6 py-4 text-center text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                        {{ __('Quantity') }}
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-right text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                        {{ __('Price') }}
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                        {{ __('Category') }}
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                        {{ __('Unit Type') }}
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                        {{ __('Units per Package') }}
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                        {{ __('Actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="inventory-table-body"  class="bg-white divide-y divide-gray-200">
                                @foreach ($inventoryItems as $item)
                                    <tr>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-gray-800">{{ $item->name }}</span>

                                            <!-- Pending Restock Requests Badge -->
                                                @if ($item->pending_restock_requests_count > 0)
                                                    <a href="{{ route('admin.inventory.inventoryActions', ['item' => $item->id]) }}"
                                                    class="mt-1 inline-block bg-yellow-100 text-yellow-800 text-xs px-2 py-0.5 rounded-full w-fit hover:bg-yellow-200 transition">
                                                        {{ $item->pending_restock_requests_count }} Pending Restock Request{{ $item->pending_restock_requests_count > 1 ? 's' : '' }}
                                                    </a>
                                                @endif

                                          <!-- Pending Update Requests Badge -->
                                                @if ($item->pending_update_requests_count > 0)
                                                    <a href="{{ route('admin.inventory.inventoryActions', ['item' => $item->id]) }}"
                                                    class="mt-1 inline-block bg-blue-100 text-blue-800 text-xs px-2 py-0.5 rounded-full w-fit hover:bg-blue-200 transition">
                                                        {{ $item->pendingUpdateRequests->count() }} Pending Update Request{{ $item->pendingUpdateRequests->count() > 1 ? 's' : '' }}
                                                    </a>
                                                @endif
                                        </div>
                                    </td>

                                        <!-- <td class="px-6 py-4 whitespace-nowrap">{{ $item->description ?? '-' }}</td> -->
                                        <td class="px-6 py-3 text-center whitespace-nowrap">{{ $item->quantity }}</td>
                                        <td class="px-6 py-3 text-right whitespace-nowrap">₱{{ number_format($item->price_php, 2) }}</td>
                                        <td class="px-6 py-3 whitespace-nowrap">{{ $item->category ?? '-' }}</td>
                                        <td class="px-6 py-3 whitespace-nowrap">{{ $item->unit_type }}</td>
                                        <td class="px-6 py-3 text-center whitespace-nowrap">{{ $item->units_per_package }}</td>

                                        <!-- <td class="px-6 py-4 whitespace-nowrap">${{ number_format($item->price, 2) }}</td> -->
                                        <td class="px-6 py-3 text-center text-sm font-medium">
                                            <div class="flex justify-center items-center gap-3">
                                                 <a href="{{ route('admin.inventory.adjust', $item->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    <x-secondary-button>
                                                        <i class="fas fa-cogs mr-1"></i> {{ __('Adjust') }}
                                                    </x-secondary-button>
                                                </a>

                                                <a href="{{ route('admin.inventory.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    <x-secondary-button>
                                                        <i class="fas fa-edit mr-1"></i> {{ __('Edit') }}
                                                    </x-secondary-button>
                                                </a>

                                                <form method="POST" action="{{ route('admin.inventory.destroy', $item->id) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this item?') }}');" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-danger-button type="submit">
                                                        <i class="fas fa-trash mr-1"></i> {{ __('Delete') }}
                                                    </x-danger-button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.getElementById('live-search-input').addEventListener('input', function () {
        const query = this.value.trim();

        fetch(`/admin/inventory/live-search?query=${query}`)
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('inventory-table-body');
                tbody.innerHTML = ''; // Clear existing rows

                if (data.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="7" class="text-center py-4">No inventory items found.</td></tr>`;
                    return;
                }

                data.forEach(item => {
                    const row = `
                        <tr>
                            <td class="px-6 py-3 whitespace-nowrap">${item.name}</td>
                            <td class="px-6 py-3 text-center whitespace-nowrap">${item.quantity}</td>
                            <td class="px-6 py-3 text-right whitespace-nowrap">₱${parseFloat(item.price_php).toFixed(2)}</td>
                            <td class="px-6 py-3 whitespace-nowrap">${item.category ?? '-'}</td>
                            <td class="px-6 py-3 whitespace-nowrap">${item.unit_type}</td>
                            <td class="px-6 py-3 text-center whitespace-nowrap">${item.units_per_package}</td>
                            <td class="text-center">
                                <div class="flex justify-center items-center gap-3">
                                    <a href="/admin/inventory/${item.id}/adjust" class="text-indigo-600 hover:text-indigo-900">
                                        <x-secondary-button><i class="fas fa-cogs mr-1"></i> Adjust</x-secondary-button>
                                    </a>
                                    <a href="/admin/inventory/${item.id}/edit" class="text-indigo-600 hover:text-indigo-900">
                                        <x-secondary-button><i class="fas fa-edit mr-1"></i> Edit</x-secondary-button>
                                    </a>
                                    <form method="POST" action="/admin/inventory/${item.id}" onsubmit="return confirm('Are you sure you want to delete this item?');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button type="submit"><i class="fas fa-trash mr-1"></i> Delete</x-danger-button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    `;
                    tbody.insertAdjacentHTML('beforeend', row);
                });
            });
    });
</script>


</x-app-layout>







