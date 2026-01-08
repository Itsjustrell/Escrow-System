@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Arbiter Dashboard') }}
                </h2>
                <div class="flex items-center gap-4">
                    <a href="{{ route('arbiter.history') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        View History
                    </a>
                    <div class="text-sm text-gray-500">
                        Last updated: {{ now()->format('M d, H:i') }}
                    </div>
                </div>
            </div>
            
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Pending -->
                <div class="bg-white rounded-xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] p-6 border-l-4 border-indigo-500 relative overflow-hidden group hover:scale-[1.02] transition-transform duration-300">
                    <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-indigo-50 to-transparent opacity-50"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-indigo-500 uppercase tracking-wider">Pending Reviews</p>
                                <h3 class="mt-2 text-4xl font-extrabold text-gray-900">{{ $stats['pending'] }}</h3>
                            </div>
                            <div class="p-3 bg-indigo-100 rounded-full text-indigo-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resolved -->
                <div class="bg-white rounded-xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] p-6 border-l-4 border-green-500 relative overflow-hidden group hover:scale-[1.02] transition-transform duration-300">
                    <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-green-50 to-transparent opacity-50"></div>
                     <div class="relative z-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-green-600 uppercase tracking-wider">Resolved Cases</p>
                                <h3 class="mt-2 text-4xl font-extrabold text-gray-900">{{ $stats['resolved'] }}</h3>
                            </div>
                            <div class="p-3 bg-green-100 rounded-full text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total -->
                <div class="bg-white rounded-xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] p-6 border-l-4 border-gray-500 relative overflow-hidden group hover:scale-[1.02] transition-transform duration-300">
                    <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-gray-50 to-transparent opacity-50"></div>
                     <div class="relative z-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Disputes</p>
                                <h3 class="mt-2 text-4xl font-extrabold text-gray-900">{{ $stats['total'] }}</h3>
                            </div>
                            <div class="p-3 bg-gray-100 rounded-full text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-800">Active Disputes</h3>
                        <span class="px-3 py-1 text-xs font-semibold text-indigo-700 bg-indigo-100 rounded-full">ACTION REQUIRED</span>
                    </div>

                    @if($escrows->count() > 0)
                        <div class="overflow-x-auto rounded-lg border border-gray-100">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Escrow Info</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Amount</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Participants</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Reason</th>
                                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($escrows as $escrow)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4">
                                                <div class="flex flex-col">
                                                    <span class="font-medium text-gray-900">{{ $escrow->title }}</span>
                                                    <span class="text-xs text-gray-400">#{{ $escrow->id }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-50 text-green-700 border border-green-100">
                                                    ${{ number_format($escrow->amount, 2) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm">
                                                    <div class="flex items-center space-x-1">
                                                        <span class="text-xs text-gray-500 w-10">Buyer:</span>
                                                        <span class="font-medium text-gray-900">{{ $escrow->buyer->name ?? 'N/A' }}</span>
                                                    </div>
                                                    <div class="flex items-center space-x-1 mt-1">
                                                        <span class="text-xs text-gray-500 w-10">Seller:</span>
                                                        <span class="font-medium text-gray-900">{{ $escrow->seller->name ?? 'N/A' }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <p class="text-sm text-gray-600 max-w-xs truncate" title="{{ $escrow->dispute->reason ?? '' }}">
                                                    {{ Str::limit($escrow->dispute->reason ?? '-', 40) }}
                                                </p>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                <a href="{{ route('arbiter.show', $escrow) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                    Review
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6">
                            {{ $escrows->links() }}
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-12 text-center border-2 border-dashed border-gray-200 rounded-lg">
                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No active disputes</h3>
                            <p class="mt-1 text-sm text-gray-500">Good job! All cases are currently resolved.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
