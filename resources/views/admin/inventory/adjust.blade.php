<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Adjust Inventory') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                <form method="POST" action="{{ route('admin.inventory.adjust', $inventoryItem->id) }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700">{{ __('Item Name') }}</label>
                        <div class="mt-1 block w-full h-12 px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 sm:text-sm">{{ $inventoryItem->name }}</div>
                    </div>

                    <div class="mb-4">
                        <label for="quantity" class="block font-medium text-sm text-gray-700">{{ __('Quantity') }}</label>
                        <input id="quantity" name="quantity" type="number"  class="mt-1 block w-full h-12 px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 sm:text-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="price_php" class="block font-medium text-sm text-gray-700">{{ __('Price (₱)') }}</label>
                        <input id="price_php" name="price_php" type="number" step="0.01"  class="mt-1 block w-full h-12 px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 sm:text-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="type" class="block font-medium text-sm text-gray-700">{{ __('Type') }}</label>
                        <select id="type" name="type" class="mt-1 block w-full h-12 px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 sm:text-sm" required>
                            <option value="restock">{{ __('Restock') }}</option>
                            <option value="deduct">{{ __('Deduct') }}</option>
                        </select>
                    </div>

                     <div class="flex items-center justify-end mt-4">
                     <x-primary-button class="ms-4">
                        {{ __('Submit Adjustment') }}
                    </x-primary-button>
                     <a href="{{ route('admin.inventory.index') }}" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-500 disabled:opacity-25 transition ease-in-out duration-150">
                        {{ __('Cancel') }}
                     </a>
                </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
