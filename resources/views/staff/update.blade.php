<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">Request Update</h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-2">{{ $product->name }}</h3>
            
            <!-- Display any validation errors -->
            @if ($errors->any())
                <div class="mb-4">
                    <ul class="list-disc pl-5 text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('staff.requestUpdate', $product->id) }}">
                @csrf
                <textarea name="notes" placeholder="Describe the update or issue with this product" class="w-full border rounded p-2 mt-2" required></textarea>
                <div class="mt-4 flex justify-end space-x-2">
                    <a href="{{ route('staff.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md text-white">Cancel</a>
                    <x-primary-button>
                        {{ __('Send Request') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
