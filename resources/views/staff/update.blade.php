<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">Request Update</h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-2">{{ $product->name }}</h3>
            <form method="POST" action="{{ route('staff.requestUpdate', $product->id) }}">
                @csrf
                <textarea name="notes" placeholder="What needs to be updated?" class="w-full border rounded p-2 mt-2" required></textarea>
                <div class="mt-4 flex justify-end space-x-2">
                    <a href="{{ route('staff.dashboard') }}" class="px-4 py-2 bg-gray-300 rounded">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-yellow-500 text-black rounded">Send Request</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
