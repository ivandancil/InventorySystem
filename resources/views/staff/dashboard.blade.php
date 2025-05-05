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
            <div class="flex justify-end">
                <form method="GET" action="{{ route('staff.dashboard') }}" class="flex items-center space-x-2">
                     <input type="text" name="search" value="{{ request()->query('search') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-black" placeholder="Search inventory..." autocomplete="off" />
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-xs font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <i class="fas fa-search"></i> {{ __('Search') }}
                        </button>
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
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($products as $product)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $product->name }}</td>
                    <!-- <td class="px-4 py-3 text-center whitespace-nowrap">{{ $product->quantity }}</td> -->
                    <td class="px-4 py-2">
                        {{ $product->quantity }}

                        @if ($product->restocked)
                            <span class="ml-2 inline-block px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Restocked</span>
                        @endif

                        @if ($product->needs_update)
                            <span class="ml-2 inline-block px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded">Update Requested</span>
                        @endif
                    </td>
                    <td class="px-6 py-3 text-center whitespace-nowrap">₱{{ $product->price_php }}</td>
                    <td class="px-4 py-3">{{ $product->category }}</td>
                    <td class="px-6 py-3 whitespace-nowrap">{{ $product->unit_type }}</td>
                    <td class="px-6 py-3 text-center whitespace-nowrap">{{ $product->units_per_package }}</td>
                    <td class="px-6 py-3 text-center text-sm font-medium">
                        <div class="flex justify-center items-center gap-2">
                            <a href="{{ route('staff.showRestockForm', $product->id) }}"
                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded-md text-sm transition duration-150">
                                    Restocked
                            </a>

                            <a href="{{ route('staff.showUpdateForm', $product->id) }}"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-md text-sm transition duration-150">
                                    Request Update
                            </a>
                        </div>
                    </td>


                </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-2 text-center text-gray-500">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
