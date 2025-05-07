<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventory Actions') }}
        </h2>
    </x-slot>

    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-auth-session-status class="mb-4" :status="session('success')" />

                    <div class="mb-4 flex flex-col sm:flex-row sm:gap-4">
                        <!-- Back Button -->
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-900 active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-500 disabled:opacity-25 transition ease-in-out duration-150 mb-4 sm:mb-0">
                            <i class="fas fa-arrow-left mr-2"></i> {{ __('Back to Dashboard') }}
                        </a>
                    </div>            
            
                <table class="table-auto w-full border-collapse">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                {{ __('Product') }}
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                {{ __('Action') }}
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                {{ __('Notes') }}
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                {{ __('Date') }}
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                {{ __('Admin Tools') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($actions as $action)
                            <tr>
                                <td class="px-6 py-3 whitespace-nowrap">{{ $action->inventoryItem->name }}</td>
                                <td class="px-6 py-3 whitespace-nowrap capitalize">{{ str_replace('_', ' ', $action->action_type) }}</td>  
                                <td class="px-6 py-3 whitespace-nowrap">{{ $action->notes ?? '—' }}</td>  
                                <td class="px-6 py-3 whitespace-nowrap">{{ $action->created_at->format('Y-m-d H:i') }}</td> 

                                @if (in_array($action->action_type, ['restocked', 'request_update']))
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <form action="{{ route('admin.inventory.clearFlag', ['itemId' => $action->inventory_item_id, 'type' => $action->action_type]) }}" method="POST" onsubmit="return confirm('Clear this flag?')">
                                            @csrf
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-sm">
                                                Clear Flag
                                            </button>
                                        </form>
                                    </td>
                                @else
                                    <td class="px-6 py-3 whitespace-nowrap text-gray-400">—</td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500 py-4">No actions found.</td>
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
