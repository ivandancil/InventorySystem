<x-app-layout>
    <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
        <i class="fas fa-edit text-indigo-500"></i>
            {{ __('Edit Inventory Item') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.inventory.update', $inventoryItem->id) }}">
                        @csrf
                        @method('PUT') {{--  Important for updating  --}}

                        {{-- Name --}}
                        <div class="mb-5">
                            <label for="name" class="block text-sm font-semibold text-gray-700">Name</label>
                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name', $inventoryItem->name) }}"
                                required
                                placeholder="e.g. iPhone 15"
                                class="mt-1 block w-full h-12 px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 sm:text-sm"
                            />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Description --}}
                        <div class="mb-5">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea
                                id="description"
                                name="description"
                                rows="3"
                                placeholder="e.g. Latest model with advanced features"
                                autocomplete="off"
                                class="mt-1 block w-full h-24 px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 sm:text-sm"
                            >{{ old('description', $inventoryItem->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        {{-- Quantity --}}
                        <div class="mb-5">
                            <label for="quantity" class="block font-medium text-sm text-gray-700">Quantity</label>
                            <input
                                id="quantity"
                                name="quantity"
                                type="number"
                                value="{{ old('quantity', $inventoryItem->quantity) }}"
                                required
                                placeholder="e.g. 100"
                                 class="mt-1 block w-full h-12 px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 sm:text-sm"
                            />
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>

                        {{-- Price --}}
                        <div class="mb-5">
                            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                            <input
                                id="price"
                                name="price_php"
                                type="number"
                                value="{{ old('price_php', $inventoryItem->price_php) }}"
                                required
                                placeholder="e.g. 799.99"
                                class="mt-1 block w-full h-12 px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 sm:text-sm"
                            />
                            <x-input-error :messages="$errors->get('price_php')" class="mt-2" />

                        </div>

                        {{-- Category --}}
                        <div class="mb-6">
                            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                            <input
                                id="category"
                                name="category"
                                type="text"
                                value="{{ old('category', $inventoryItem->category) }}"
                                placeholder="e.g. Electronics"
                                 class="mt-1 block w-full h-12 px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 sm:text-sm"
                            />
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        {{-- Unit Type --}}
                        <div class="mb-5">
                            <label for="unit_type" class="block text-sm font-medium text-gray-700">Unit Type</label>
                            <select
                                id="unit_type"
                                name="unit_type"
                                class="mt-1 block w-full h-12 px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 sm:text-sm"
                            >
                                <option value="each" {{ old('unit_type', $inventoryItem->unit_type) == 'each' ? 'selected' : '' }}>Each</option>
                                <option value="box" {{ old('unit_type', $inventoryItem->unit_type) == 'box' ? 'selected' : '' }}>Box</option>
                                <option value="dozen" {{ old('unit_type', $inventoryItem->unit_type) == 'dozen' ? 'selected' : '' }}>Dozen</option>
                            </select>
                            <x-input-error :messages="$errors->get('unit_type')" class="mt-2" />
                        </div>

                        {{-- Units per Package --}}
                        <div class="mb-6">
                            <label for="units_per_package" class="block text-sm font-medium text-gray-700">Units per Package</label>
                            <input
                                id="units_per_package"
                                name="units_per_package"
                                type="number"
                                value="{{ old('units_per_package', $inventoryItem->units_per_package) }}"
                                placeholder="e.g. 12"
                                autocomplete="off"
                                class="mt-1 block w-full h-12 px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 sm:text-sm"
                            />
                            <x-input-error :messages="$errors->get('units_per_package')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Update Item') }}
                            </x-primary-button>
                            <a href="{{ route('admin.inventory.index') }}" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-500 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>