@extends('layouts.app')

@extends('layouts.app')

@section('content')
    <div class="py-12" x-data="{ 
        showModal: false, 
        modalImage: '', 
        modalTitle: '',
        modalType: 'image',
        modalUrl: '',
        openModal(url, type = 'image', title = 'Attachment') {
            this.modalUrl = url;
            this.modalImage = url;
            this.modalType = type;
            this.modalTitle = title;
            this.showModal = true;
            document.body.style.overflow = 'hidden';
        },
        closeModal() {
            this.showModal = false;
            this.modalImage = '';
            this.modalUrl = '';
            document.body.style.overflow = '';
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                 <div class="flex items-center space-x-4">
                    <a href="{{ route('arbiter.dashboard') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                        Review Dispute
                    </h2>
                </div>
                <div class="text-sm font-medium px-3 py-1 bg-gray-100 rounded-md text-gray-600">
                    ID: #{{ $escrow->id }}
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- MAIN CONTENT (Left) -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Evidence Log -->
                    <!-- Evidence Log -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-800">Evidence & Chat Log</h3>
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                {{ $escrow->dispute->evidences->count() }} Items
                            </span>
                        </div>
                        
                        <div class="p-6 bg-slate-50 min-h-[400px] max-h-[800px] overflow-y-auto space-y-8">
                            @if($escrow->dispute->evidences->count() > 0)
                                @foreach($escrow->dispute->evidences as $evidence)
                                    @php
                                        $isBuyer = $evidence->uploaded_by === $escrow->buyer?->id;
                                        $isSeller = $evidence->uploaded_by === $escrow->seller?->id;
                                        $name = $isBuyer ? 'Buyer' : ($isSeller ? 'Seller' : 'User');
                                        
                                        // "Chat" alignment
                                        $containerClass = $isBuyer ? 'flex-row' : ($isSeller ? 'flex-row-reverse' : 'flex-row justify-center');
                                        $bubbleClass = $isBuyer ? 'bg-white rounded-tl-sm' : ($isSeller ? 'bg-indigo-50 rounded-tr-sm' : 'bg-gray-100');
                                        $borderClass = $isBuyer ? 'border-gray-200' : ($isSeller ? 'border-indigo-100' : 'border-gray-200');
                                    @endphp
                                    
                                    <div class="flex {{ $containerClass }} items-start gap-4">
                                        <!-- Avatar / Initials -->
                                        <div class="flex-shrink-0">
                                            <div class="h-10 w-10 rounded-full flex items-center justify-center text-sm font-bold shadow-sm
                                                {{ $isBuyer ? 'bg-blue-100 text-blue-600' : ($isSeller ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-200 text-gray-600') }}">
                                                {{ substr($name, 0, 1) }}
                                            </div>
                                        </div>

                                        <!-- Message Bubble -->
                                        <div class="max-w-[75%] rounded-2xl p-5 shadow-sm border {{ $bubbleClass }} {{ $borderClass }} text-sm">
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="font-bold text-gray-900">{{ $name }}</span>
                                                <span class="text-xs text-gray-400 ml-4">{{ $evidence->created_at->format('M d, H:i') }}</span>
                                            </div>

                                            @if($evidence->description)
                                                <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $evidence->description }}</p>
                                            @endif

                                            @if($evidence->file_path)
                                                @php
                                                    $extension = pathinfo($evidence->file_path, PATHINFO_EXTENSION);
                                                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                                    $fileUrl = Storage::url($evidence->file_path);
                                                @endphp

                                                <div class="mt-3">
                                                    @if($isImage)
                                                        <!-- Direct click handling on image wrapper -->
                                                        <div class="group relative rounded-lg overflow-hidden border border-gray-200 cursor-zoom-in"
                                                             @click="openModal('{{ $fileUrl }}', 'image', 'Evidence from {{ $name }}')">
                                                            <img src="{{ $fileUrl }}" alt="Attachment" class="max-h-64 rounded-lg object-cover bg-gray-100 transition-transform duration-200 group-hover:scale-[1.02]">
                                                        </div>
                                                        <p class="mt-1 text-xs text-gray-400 italic">Click image to enlarge</p>
                                                    @else
                                                        <div class="flex items-center p-3 bg-white rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 transition-colors"
                                                             @click="openModal('{{ $fileUrl }}', 'file', 'File from {{ $name }}')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                            </svg>
                                                            <div class="overflow-hidden">
                                                                <p class="font-medium text-gray-900 truncate">Attachment</p>
                                                                <p class="text-xs text-gray-500 uppercase">{{ $extension }} File</p>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="flex flex-col items-center justify-center h-64 text-gray-400">
                                    <div class="bg-gray-100 p-4 rounded-full mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium">No conversation history yet.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Escrow Details (Moved below evidence for flow, or keep top? Keeping order logic but improved UI) -->
                     <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold mb-4 text-gray-800">Transaction Details</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <p class="text-xs text-gray-500 uppercase font-semibold">Amount</p>
                                <p class="font-bold text-xl text-gray-900 mt-1 mb-1">${{ number_format($escrow->amount, 2) }}</p>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-700">HELD IN ESCROW</span>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <p class="text-xs text-gray-500 uppercase font-semibold">Title</p>
                                <p class="font-medium text-gray-900 mt-1 truncate" title="{{ $escrow->title }}">{{ $escrow->title }}</p>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <p class="text-xs text-gray-500 uppercase font-semibold">Buyer</p>
                                <p class="font-medium text-gray-900 mt-1 truncate">{{ $escrow->buyer->name ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ $escrow->buyer->email ?? '' }}</p>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <p class="text-xs text-gray-500 uppercase font-semibold">Seller</p>
                                <p class="font-medium text-gray-900 mt-1 truncate">{{ $escrow->seller->name ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ $escrow->seller->email ?? '' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Dispute Reason -->
                    <div class="bg-red-50 rounded-xl shadow-sm border border-red-100 p-6">
                         <h3 class="text-lg font-bold text-red-700 mb-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Dispute Reason
                        </h3>
                        <div class="bg-white p-4 rounded-lg border border-red-100 text-gray-700 shadow-sm leading-relaxed">
                            {{ $escrow->dispute->reason }}
                        </div>
                    </div>

                </div>

                <!-- SIDEBAR (Right) - Resolution -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] p-6 sticky top-6 border border-gray-100">
                        <div class="mb-6 pb-6 border-b border-gray-100">
                             <h3 class="text-lg font-bold text-gray-800 mb-1">Resolution Center</h3>
                             <p class="text-xs text-gray-500">Action is irreversible once submitted.</p>
                        </div>

                        <form action="{{ route('arbiter.resolve', $escrow) }}" method="POST">
                            @csrf
                            
                            <div class="mb-6 space-y-4">
                                <label class="group relative flex items-start p-4 cursor-pointer border rounded-xl hover:bg-gray-50 hover:border-indigo-300 transition-all duration-200">
                                    <div class="flex items-center h-5">
                                        <input type="radio" name="resolution" value="refund_buyer" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" required>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <span class="block font-bold text-gray-900 group-hover:text-indigo-700">Refund Buyer</span>
                                        <span class="block text-gray-500 mt-1">Return 100% of funds to the buyer.</span>
                                    </div>
                                </label>

                                <label class="group relative flex items-start p-4 cursor-pointer border rounded-xl hover:bg-gray-50 hover:border-indigo-300 transition-all duration-200">
                                    <div class="flex items-center h-5">
                                        <input type="radio" name="resolution" value="release_seller" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <span class="block font-bold text-gray-900 group-hover:text-indigo-700">Release to Seller</span>
                                        <span class="block text-gray-500 mt-1">Disburse 100% of funds to the seller.</span>
                                    </div>
                                </label>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Decision Notes</label>
                                <textarea name="notes" rows="6" class="w-full border-gray-200 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 resize-none p-3 text-sm" placeholder="Provide a detailed explanation for your decision..." required minlength="10"></textarea>
                            </div>

                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg shadow-indigo-200 hover:shadow-indigo-300 transform transition hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" onclick="return confirm('Are you sure you want to resolve this dispute? This action is FINAL and cannot be undone.')">
                                Submit Final Decision
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <!-- MODAL OVERLAY -->
        <div x-show="showModal" 
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" 
             role="dialog" 
             aria-modal="true">
             
            <!-- Backdrop -->
            <div x-show="showModal" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" 
                 @click="closeModal()"></div>

            <!-- Modal Panel -->
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="showModal" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex justify-between items-center mb-4">
                             <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title" x-text="modalTitle">Attachment</h3>
                             <button @click="closeModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                <span class="sr-only">Close</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                             </button>
                        </div>
                        
                        <div class="mt-2 flex justify-center items-center bg-gray-100 rounded-lg p-2 min-h-[300px]">
                            <template x-if="modalType === 'image'">
                                <img :src="modalImage" alt="Evidence Attachment" class="max-h-[70vh] w-auto rounded shadow-sm">
                            </template>
                            
                            <template x-if="modalType !== 'image'">
                                <div class="text-center p-12">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-gray-900 font-medium mb-1">File cannot be previewed</p>
                                    <p class="text-gray-500 text-sm mb-4">This file type is not supported for direct preview.</p>
                                    <a :href="modalUrl" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Download / Open in New Tab
                                    </a>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
