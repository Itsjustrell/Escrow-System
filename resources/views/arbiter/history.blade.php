@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight mb-6">Dispute History</h2>

            <!-- History Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Escrow Info</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Participants</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dispute Outcome</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Resolved On</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($escrows as $escrow)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $escrow->title }}</div>
                                        <div class="text-xs text-indigo-500">#{{ $escrow->id }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            ${{ number_format($escrow->amount, 2) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            <span class="font-medium text-blue-600">Buyer:</span> {{ $escrow->buyer?->name ?? 'N/A' }}
                                        </div>
                                        <div class="text-sm text-gray-900 mt-1">
                                            <span class="font-medium text-purple-600">Seller:</span> {{ $escrow->seller?->name ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="max-w-xs">
                                            @if($escrow->status === 'refunded')
                                                <span class="text-xs font-semibold text-red-600 uppercase bg-red-50 px-2 py-1 rounded">Refunded to Buyer</span>
                                            @elseif($escrow->status === 'released')
                                                <span class="text-xs font-semibold text-green-600 uppercase bg-green-50 px-2 py-1 rounded">Released to Seller</span>
                                            @else
                                                <span class="text-xs font-semibold text-gray-600 uppercase bg-gray-50 px-2 py-1 rounded">{{ $escrow->status }}</span>
                                            @endif
                                            
                                            <div class="text-xs text-gray-500 mt-1 truncate" title="{{ $escrow->dispute->resolution ?? '' }}">
                                                {{ Str::limit($escrow->dispute->resolution ?? 'No notes', 50) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                        {{ $escrow->updated_at->format('M d, Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <p class="text-base font-medium">No history available yet.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-6">
                {{ $escrows->links() }}
            </div>
        </div>
    </div>
@endsection
