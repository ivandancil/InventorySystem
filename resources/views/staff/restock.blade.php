<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">Request {{ $product->name }} Restocked</h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            @if (session('success'))
                <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 rounded bg-red-100 text-red-800 border border-red-300">
                    {{ session('error') }}
                </div>
            @endif

            <h3 class="text-lg font-semibold mb-2">{{ $product->name }}</h3>

            <div class="mt-4">
                <label for="available" class="block text-sm font-medium text-gray-700">Available Stocks in Warehouse</label>
                <input
                    type="number"
                    id="available"
                    name="available"
                    value="{{ $availableQuantity }}"
                    class="mt-1 block w-full h-12 px-3 py-2 rounded-md border border-gray-300 bg-gray-100 text-gray-700 cursor-not-allowed"
                    readonly
                >
            </div>

            <form method="POST" action="{{ route('staff.markRestocked', $product->id) }}">
                @csrf
                <!-- Restock quantity -->
                <div class="mt-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700" required>Restock Quantity</label>
                    <input type="number" id="quantity" name="quantity" class="mt-1 block w-full h-12 px-3 py-2 rounded-md border border-gray-300" required min="1">
                    @error('quantity')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Optional notes -->
                <div class="mt-4">
                    <label for="notes" class="block text-sm font-medium text-gray-700" required>Optional Notes</label>
                    <textarea id="notes" name="notes" class="w-full border rounded p-2 mt-2" placeholder="Optional notes about restocking"></textarea>
                    @error('notes')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4 flex justify-end space-x-2">
                    <a href="{{ route('staff.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md text-white">Cancel</a>
                    <x-primary-button>
                        {{ __('Send Request') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const quantityInput = document.getElementById('quantity');
        const submitBtn = document.querySelector('button[type="submit"]');
        const maxAvailable = {{ $availableQuantity }};
        const errorDiv = document.createElement('div');

        errorDiv.className = 'text-red-500 text-sm mt-1';
        quantityInput.parentNode.appendChild(errorDiv);

        quantityInput.addEventListener('input', function () {
            const value = parseInt(this.value, 10);

            if (value > maxAvailable) {
                errorDiv.textContent = `Only ${maxAvailable} available in warehouse.`;
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                errorDiv.textContent = '';
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        });
    });
</script>

</x-app-layout>
