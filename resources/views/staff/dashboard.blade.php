<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staff Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{ __('Welcome to the Staff Dashboard!') }}
                </div>
            </div>

            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">{{ __('Inventory Items') }}</h3>
                    
                    <form method="GET" class="flex items-center space-x-2" autocomplete="off">
                        <div>
                            <label for="search" class="sr-only">{{ __('Search by Name or Category') }}</label>
                          <input type="text" name="search" id="search" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="{{ __('Search Name, Category, Width, or Length') }}" value="{{ request('search') }}" oninput="filterInventory(this.value)">
                        </div>
                    </form>
                </div>

                <div id="inventory-table-container" class="p-6 bg-white border-b border-gray-200">
                    @if ($inventoryItems->isEmpty())
                        <p>{{ __('No inventory items found.') }}</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Name') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Category') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Quantity') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Price') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('SKU') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($inventoryItems as $item)
                                    <tr id="item-{{ $item->id }}">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->category ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->quantity }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">${{ $item->price }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->sku ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                            <button class="bg-green-500 hover:bg-green-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="openRestockModal({{ $item->id }})">{{ __('Restock') }}</button>
                                            <button class="bg-yellow-500 hover:bg-yellow-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="openUpdateRequestModal({{ $item->id }})">{{ __('Request Update') }}</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $inventoryItems->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Restock Modal --}}
        <div id="restockModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="restockModalLabel" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="restockModalLabel">
                            {{ __('Restock Item') }}
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                {{ __('Enter the quantity being restocked.') }}
                            </p>
                            <form id="restockForm" method="POST" action="{{ route('staff.inventory.restock') }}">
                                @csrf
                                <input type="hidden" name="item_id" id="restock_item_id">
                                <div class="mt-4">
                                    <label for="restock_quantity" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Restock Quantity') }}</label>
                                    <input type="number" name="quantity" id="restock_quantity" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" min="1" value="1">
                                    @error('quantity') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                                </div>
                                <div class="mt-4">
                                    <button type="button" class="inline-flex justify-center px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-md font-semibold text-sm uppercase hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" onclick="closeRestockModal()">
                                        {{ __('Cancel') }}
                                    </button>
                                    <button type="button" class="inline-flex justify-center px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-md font-semibold text-sm uppercase hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" onclick="submitRestockForm()">
                                        {{ __('Confirm Restock') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{-- Request Update Modal --}}
    <div id="updateRequestModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="updateRequestModalLabel" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="updateRequestModalLabel">
                        {{ __('Request Quantity Update') }}
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            {{ __('Please specify the reason for the quantity update request.') }}
                        </p>
                        <form method="POST" action="{{ route('staff.inventory.request-update') }}">
                            @csrf
                            <input type="hidden" name="item_id" id="update_request_item_id">
                            <div class="mt-4">
                                <label for="reason" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Reason for Update') }}</label>
                                <textarea name="reason" id="reason" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div class="mt-4">
                                <button type="button" class="inline-flex justify-center px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-md font-semibold text-sm uppercase hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" onclick="closeUpdateRequestModal()">
                                    {{ __('Cancel') }}
                                </button>
                                <button type="submit" class="inline-flex justify-center px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-md font-semibold text-sm uppercase hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ __('Submit Request') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterInventory(query) {
            fetch(`/staff/inventory/filter?query=${query}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('inventory-table-container').innerHTML = html;
                });
        }


        function openRestockModal(itemId) {
        document.getElementById('restockModal').classList.remove('hidden');
        document.getElementById('restock_item_id').value = itemId;
        document.getElementById('restock_quantity').value = 1; // Reset quantity on open
    }

    function closeRestockModal() {
        document.getElementById('restockModal').classList.add('hidden');
    }

    function submitRestockForm() {
        const form = document.getElementById('restockForm');
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
                'X-Requested-With': 'XMLHttpRequest' // To indicate AJAX request
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // This is the code that updates the quantity in the table
                const itemId = formData.get('item_id');
                console.log('Item ID:', itemId); // ADDED FOR DEBUGGING
                const quantityElement = document.querySelector(`#item-${itemId} td:nth-child(3)`);
                console.log('Quantity Element:', quantityElement); // ADDED FOR DEBUGGING
                if (quantityElement) {
                    quantityElement.textContent = data.newQuantity;
                }
                closeRestockModal();
                alert(data.message);// Or use a more sophisticated notification
            } else if (data.error) {
                alert(data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while restocking.');
        });
    }

        function openUpdateRequestModal(itemId) {
            document.getElementById('updateRequestModal').classList.remove('hidden');
            document.getElementById('update_request_item_id').value = itemId;
        }

        function closeUpdateRequestModal() {
            document.getElementById('updateRequestModal').classList.add('hidden');
        }
    </script>
</x-app-layout>