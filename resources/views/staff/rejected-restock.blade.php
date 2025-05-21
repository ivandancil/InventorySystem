<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rejected Restock Details') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg">
                <h3 class="text-lg font-semibold mb-2">Item: {{ $product->name }}</h3>
                <p><strong>Category:</strong> {{ $product->category }}</p>
                <p><strong>Unit Type:</strong> {{ $product->unit_type }}</p>
                <p><strong>Units per Package:</strong> {{ $product->units_per_package }}</p>
                <hr class="my-4">
                <h4 class="text-md font-semibold text-red-600">Rejection Reason</h4>
                <p class="mt-2 text-gray-700">{{ $rejectionReason }}</p>

                <div class="mt-6">
                    <a href="{{ route('staff.dashboard') }}"
                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                        ← Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
