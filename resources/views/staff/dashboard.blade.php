<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staff Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex justify-end mt-4">
                <form method="GET" action="{{ route('staff.dashboard') }}" class="flex items-center space-x-2">
                    <label for="search" class="sr-only">Search Products</label>
                    <input
                        type="text"
                        id="search"
                        name="search"
                        placeholder="Search products..."
                        value="{{ request('search') }}"
                        class="border-gray-300 focus:ring focus:ring-indigo-200 focus:border-indigo-400 rounded-md shadow-sm px-4 py-2 w-72"
                    >
                    <button
    type="submit"
    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-900 text-black font-semibold rounded-md shadow-sm transition-all duration-150 ease-in-out"
>
    Search
</button>


                </form>
            </div>



                <table class="w-full mt-4 table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-200 text-left">
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Category</th>
                            <th class="px-4 py-2">Quantity</th>
                            <th class="px-4 py-2">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $product->name }}</td>
                                <td class="px-4 py-2">{{ $product->category }}</td>
                                <td class="px-4 py-2">{{ $product->quantity }}</td>
                                <td class="px-4 py-2">{{ $product->price }}</td>
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
