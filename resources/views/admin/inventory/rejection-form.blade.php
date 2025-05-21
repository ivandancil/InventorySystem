<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reject Inventory Action') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('admin.inventory.inventoryActions.rejectWithNote', $action->id) }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Reason for Rejection
                        </label>
                        <textarea name="notes" rows="4"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('admin.inventory.inventoryActions') }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded mr-2">
                            Cancel
                        </a>
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                            Submit Rejection
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
