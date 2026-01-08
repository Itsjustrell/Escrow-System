<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Arbiter Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Active Disputes</h3>

                    @if($escrows->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Escrow Title</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buyer</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seller</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($escrows as $escrow)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $escrow->title }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($escrow->amount, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $escrow->buyer->name ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $escrow->seller->name ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($escrow->dispute->reason ?? '-', 50) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('arbiter.show', $escrow) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">Review</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $escrows->links() }}
                        </div>
                    @else
                        <p class="text-gray-500">No active disputes found.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
