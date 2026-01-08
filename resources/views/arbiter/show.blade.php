@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                {{ __('Review Dispute') }}: {{ $escrow->title }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Transaction Details -->
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border">
                        <h3 class="text-lg font-bold mb-4">Escrow Details</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Amount</p>
                                <p class="font-bold text-xl">${{ number_format($escrow->amount, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Status</p>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    {{ ucfirst($escrow->status) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Buyer</p>
                                <p class="font-medium">{{ $escrow->buyer->name ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-400">{{ $escrow->buyer->email ?? '' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Seller</p>
                                <p class="font-medium">{{ $escrow->seller->name ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-400">{{ $escrow->seller->email ?? '' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Dispute Information -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border">
                        <div class="border-b pb-4 mb-4">
                            <h3 class="text-lg font-bold text-red-600">Dispute Reason</h3>
                            <p class="mt-2 text-gray-700 bg-gray-50 p-4 rounded">{{ $escrow->dispute->reason }}</p>
                        </div>
                    </div>

                    <!-- Evidence Log -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border">
                        <h3 class="text-lg font-bold mb-4">Evidence & Chat Log</h3>
                        
                        @if($escrow->dispute->evidences->count() > 0)
                            <div class="space-y-4">
                                @foreach($escrow->dispute->evidences as $evidence)
                                    <div class="flex {{ $evidence->uploaded_by === ($escrow->buyer?->id) ? 'justify-start' : 'justify-end' }}">
                                        <div class="max-w-lg {{ $evidence->uploaded_by === ($escrow->buyer?->id) ? 'bg-blue-50' : 'bg-green-50' }} rounded-lg p-4 shadow-sm border">
                                            <p class="text-xs font-bold mb-1 {{ $evidence->uploaded_by === ($escrow->buyer?->id) ? 'text-blue-600' : 'text-green-600' }}">
                                                @if($evidence->uploaded_by === ($escrow->buyer?->id)) Buyer @elseif($evidence->uploaded_by === ($escrow->seller?->id)) Seller @else User @endif
                                            </p>
                                            
                                            @if($evidence->description)
                                                <p class="text-sm text-gray-800 mb-2">{{ $evidence->description }}</p>
                                            @endif
                                            
                                            @if($evidence->file_path)
                                                <div class="mt-2">
                                                    <a href="{{ Storage::url($evidence->file_path) }}" target="_blank" class="text-indigo-600 underline text-sm">View Attachment</a>
                                                </div>
                                            @endif

                                            <p class="text-xs text-gray-400 mt-2 text-right">{{ $evidence->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 italic text-center">No evidence uploaded yet.</p>
                        @endif
                    </div>
                </div>

                <!-- Resolution Panel -->
                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 sticky top-6 border">
                        <h3 class="text-lg font-bold mb-4">Resolution</h3>
                        <p class="text-sm text-gray-600 mb-6">Make a final decision to resolve this dispute. This action is irreversible.</p>

                        <form action="{{ route('arbiter.resolve', $escrow) }}" method="POST">
                            @csrf
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">In favor of...</label>
                                <div class="space-y-2">
                                    <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                                        <input type="radio" name="resolution" value="refund_buyer" class="text-indigo-600" required>
                                        <span class="ml-2">
                                            <span class="block font-bold">Refund Buyer</span>
                                            <span class="block text-xs text-gray-500">Buyer gets 100% money back</span>
                                        </span>
                                    </label>
                                    <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                                        <input type="radio" name="resolution" value="release_seller" class="text-indigo-600">
                                        <span class="ml-2">
                                            <span class="block font-bold">Release to Seller</span>
                                            <span class="block text-xs text-gray-500">Seller receives funds</span>
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Decision Note</label>
                                <textarea name="notes" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Explain your decision..." required minlength="10"></textarea>
                            </div>

                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="return confirm('Are you sure? This action cannot be undone.')">
                                Submit Final Decision
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
