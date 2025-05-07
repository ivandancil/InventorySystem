<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">Mark Restocked</h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-2">{{ $product->name }}</h3>
            <form method="POST" action="{{ route('staff.markRestocked', $product->id) }}">
                @csrf
                <textarea name="notes" placeholder="Optional notes..." class="w-full border rounded p-2 mt-2"></textarea>
                <div class="mt-4 flex justify-end space-x-2">
                    <a href="{{ route('staff.dashboard') }}"  class="ml-4 inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-500 disabled:opacity-25 transition ease-in-out duration-150">Cancel</a>
                    <x-primary-button class="ms-4">
                                {{ __('Confirm') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
