<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Welcome to the Admin Dashboard!

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-100 rounded-md p-4">
                            <h3 class="font-semibold text-lg text-gray-700">{{ __('Total Products') }}</h3>
                            <p class="text-2xl text-gray-900">{{ $totalProducts }}</p>
                        </div>
                        <div class="bg-gray-100 rounded-md p-4">
                            <h3 class="font-semibold text-lg text-gray-700">{{ __('Total Stock') }}</h3>
                            <p class="text-2xl text-gray-900">{{ $totalStock }}</p>
                        </div>
                    </div>

                    <!-- <div class="mt-4">
                        <a href="{{ route('admin.inventory.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-900 active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-500 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Create New Inventory Item') }}
                        </a>
                    </div> -->

                    <div class="mt-4">
                        <a href="{{ route('admin.inventory.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-900 active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-500 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('View Inventory List') }}
                        </a>
                    </div>

                    <div class="mt-4">
                            <a href="{{ route('admin.inventory.inventoryActions') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-900 active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-500 disabled:opacity-25 transition ease-in-out duration-150">
                                View Inventory Actions
                            </a>
                </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>