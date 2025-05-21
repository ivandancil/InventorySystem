<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staff Dashboard') }}
        </h2>
    </x-slot>

    <!-- ✅ Notification -->
    @if (session('success'))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-end space-x-4">
                    <!-- Export CSV Button -->
                    <a href="{{ route('staff.generateInventoryReport') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-900 active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-500 disabled:opacity-25 transition ease-in-out duration-150">
                        <i class="fas fa-file-csv mr-2"></i> {{ __('Export CSV') }}
                    </a>
                    
                    <!-- Live Search Bar -->
                    <form method="GET" action="{{ route('staff.dashboard.liveSearch') }}" class="flex items-center space-x-2">
                        <input type="text" name="search" id="live-search-input" value="{{ request()->query('search') }}" class="px-4 py-2 border border-gray-500 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Search inventory..." autocomplete="off" />
                    </form>
                </div>

                <table class="w-full mt-4 table-auto border-collapse">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                {{ __('Name') }}
                            </th>
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
                    <tbody id="inventory-table-body" class="bg-white divide-y divide-gray-200">
                        @foreach ($products as $product)
                            @php
                                $hasApprovedRestock = $product->inventoryActions->where('action_type', 'restocked')->where('status', 'approved')->isNotEmpty();
                                $hasPendingRestock = $product->inventoryActions->where('action_type', 'restocked')->where('status', 'pending')->isNotEmpty();
                                $hasRejectedRestock = $product->inventoryActions->where('action_type', 'restocked')->where('status', 'rejected')->isNotEmpty();
                                $hasUpdateRequest = $product->inventoryActions->where('action_type', 'request_update')->where('status', 'pending')->isNotEmpty();
                            @endphp
                            <tr class="border-t">
                                <td class="px-4 py-3">
                                    {{ $product->name }}
                                    <div class="mt-1 space-x-1">
                                        @if ($hasPendingRestock)
                                            <span class="inline-block bg-yellow-100 text-yellow-800 text-xs px-2 py-0.5 rounded">Restock Requested</span>
                                        @endif
                                        @if ($hasUpdateRequest)
                                            <span class="mt-1 inline-block bg-blue-100 text-blue-800 text-xs px-2 py-0.5 rounded-full">Update Requested</span>
                                        @endif
                                      @if ($hasRejectedRestock)
    @php
        $rejectedRestockAction = $product->inventoryActions->where('action_type', 'restocked')->where('status', 'rejected')->first(); 
    @endphp
    <a href="{{ route('staff.viewRejectedRestock', ['product' => $product->id]) }}" 
       class="mt-1 inline-block bg-red-100 text-red-800 text-xs px-2 py-0.5 rounded-full rejected-badge" 
       data-id="{{ $product->id }}">
        Restock Rejected
    </a>
@endif
                                    </div>
                                </td>
                                <td class="px-4 py-2 text-center">
                                    @php
                                        $approvedRestocks = $product->inventoryActions
                                            ->where('action_type', 'restocked')
                                            ->where('status', 'approved')
                                            ->sum('quantity');
                                    @endphp
                                    {{ $approvedRestocks }}
                                </td>
                                <td class="px-6 py-3 text-center whitespace-nowrap">₱{{ $product->price_php }}</td>
                                <td class="px-4 py-3">{{ $product->category }}</td>
                                <td class="px-6 py-3 whitespace-nowrap">{{ $product->unit_type }}</td>
                                <td class="px-6 py-3 text-center whitespace-nowrap">{{ $product->units_per_package }}</td>
                                <td class="px-6 py-3 text-center text-sm font-medium">
                                    <div class="flex justify-center items-center gap-2">
                                        <a href="{{ route('staff.showRestockForm', $product->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded-md text-sm transition duration-150">
                                            Request Stock
                                        </a>
                                        <a href="{{ route('staff.showUpdateForm', $product->id) }}" 
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-md text-sm transition duration-150">
                                            Request Update
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery for live search -->
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Select all the "Restock Rejected" badges
        const rejectedBadges = document.querySelectorAll('.rejected-badge');
        
        // Attach click event listener
        rejectedBadges.forEach(badge => {
            badge.addEventListener('click', function (e) {
                e.preventDefault(); // Prevent default link behavior (for smooth JS action)
                
                // Hide the clicked badge
                badge.style.display = 'none';

                // Redirect the user to the rejection reason page
                window.location.href = badge.getAttribute('href');
            });
        });
    });
</script>

</x-app-layout>
