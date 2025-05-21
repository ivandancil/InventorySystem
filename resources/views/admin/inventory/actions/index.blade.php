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
                            
                             <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider ">
                                {{ __('Request Quantity') }}
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
                                <td class="px-6 py-3 whitespace-nowrap text-center font-bold">{{ $action->quantity ?? '—' }}</td>  
                                <td class="px-6 py-3 whitespace-nowrap">{{ $action->notes ?? '—' }}</td>  
                                <td class="px-6 py-3 whitespace-nowrap">{{ $action->created_at->format('Y-m-d H:i') }}</td> 

                               @if (in_array($action->action_type, ['restocked', 'request_update']))
                        <td class="px-6 py-3 text-center text-sm font-medium">
                            <div class="flex justify-center items-center gap-3">

                                @if ($action->status === 'pending')
                                    <!-- Approve Form -->
                                    <form action="{{ route('admin.inventory.inventoryActions.approve', ['item' => $action->inventory_item_id, 'type' => $action->action_type]) }}"
                                        method="POST" onsubmit="handleButtonClick('approve', {{ $action->id }})">
                                        @csrf
                                        <button id="approve-btn-{{ $action->id }}" type="submit"
                                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded text-sm">
                                            Approve
                                        </button>
                                    </form>

                                   <!-- Redirect to Rejection Form -->
                                    <a href="{{ route('admin.inventory.inventoryActions.rejectionForm', ['action' => $action->id]) }}"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-sm">
                                        Reject
                                    </a>

                                @elseif ($action->status === 'approved')
                                    <span class="text-green-600 font-semibold">Approved</span>
                                @elseif ($action->status === 'rejected')
                                    <span class="text-red-600 font-semibold">Rejected</span>
                                @endif

                            </div>
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

  <script>
    function handleButtonClick(action, actionId) {
        const approveBtn = document.getElementById(`approve-btn-${actionId}`);
        const rejectBtn = document.getElementById(`reject-btn-${actionId}`);

        if (action === 'approve') {
            if (rejectBtn) {
                rejectBtn.disabled = true;
                rejectBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
            }
        } else if (action === 'reject') {
            if (approveBtn) {
                approveBtn.disabled = true;
                approveBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
            }
        }
    }
</script>
  


</x-app-layout>
