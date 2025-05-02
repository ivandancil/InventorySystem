<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventory Actions') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <table class="table-auto w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2 text-left">Product</th>
                            <th class="px-4 py-2 text-left">Action</th>
                            <th class="px-4 py-2 text-left">Notes</th>
                            <th class="px-4 py-2 text-left">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($actions as $action)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $action->inventoryItem->name }}</td>
                                <td class="px-4 py-2 capitalize">{{ $action->action_type }}</td>
                                <td class="px-4 py-2">{{ $action->notes ?? '—' }}</td>
                                <td class="px-4 py-2">{{ $action->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 py-4">No actions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $actions->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
