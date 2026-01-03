@extends('layouts.app')

@section('content')
<style>
    .detail-container {
        padding: 40px 0;
    }

    /* Glass Header */
    .glass-header-card {
        background: radial-gradient(circle at top right, rgba(99, 102, 241, 0.15) 0%, transparent 40%),
                    radial-gradient(circle at bottom left, rgba(168, 85, 247, 0.15) 0%, transparent 60%),
                    #1e293b;
        border-radius: 20px;
        padding: 40px;
        color: white;
        margin-bottom: 30px;
        box-shadow: 0 20px 40px -5px rgba(0, 0, 0, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .header-info h1 {
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .header-info p {
        color: #94a3b8;
        font-size: 1.1rem;
    }

    .header-amount {
        text-align: right;
    }

    .amount-display {
        font-size: 2.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .amount-label {
        color: #94a3b8;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Timeline */
    .timeline-container {
        background: white;
        padding: 30px;
        border-radius: 20px;
        margin-bottom: 30px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        overflow-x: auto;
    }

    .timeline-track {
        display: flex;
        justify-content: space-between;
        position: relative;
        min-width: 600px;
    }

    .timeline-line {
        position: absolute;
        top: 20px;
        left: 0;
        right: 0;
        height: 4px;
        background: #f1f5f9;
        z-index: 1;
    }

    .timeline-progress {
        position: absolute;
        top: 20px;
        left: 0;
        height: 4px;
        background: #6366f1;
        z-index: 1;
        transition: width 0.5s ease;
    }

    .timeline-step {
        position: relative;
        z-index: 2;
        text-align: center;
        width: 120px;
    }

    .step-dot {
        width: 44px;
        height: 44px;
        background: white;
        border: 4px solid #f1f5f9;
        border-radius: 50%;
        margin: 0 auto 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: #94a3b8;
        transition: all 0.3s;
    }

    .step-active .step-dot {
        border-color: #6366f1;
        background: #6366f1;
        color: white;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2);
    }

    .step-completed .step-dot {
        border-color: #6366f1;
        background: #6366f1;
        color: white;
    }

    .step-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #64748b;
    }

    .step-active .step-label {
        color: #0f172a;
        font-weight: 700;
    }

    /* Action Panels */
    .action-panel {
        background: white;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
    }

    .panel-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f1f5f9;
    }

    .panel-header h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .panel-icon {
        width: 36px;
        height: 36px;
        background: #eff6ff;
        color: #6366f1;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    /* Buttons */
    .btn-action-primary {
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        color: white;
        padding: 14px 28px;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
        transition: all 0.2s;
        box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.3);
    }

    .btn-action-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.4);
    }

    .btn-action-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 14px 28px;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
        transition: all 0.2s;
        box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);
    }

    .btn-action-danger {
        background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
        color: white;
        padding: 14px 28px;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
        transition: all 0.2s;
    }

    /* Dispute Section */
    .dispute-panel {
        background: #fff1f2;
        border: 1px solid #fecdd3;
    }

    .dispute-panel .panel-icon {
        background: #ffe4e6;
        color: #e11d48;
    }

    .dispute-panel .panel-header h3 {
        color: #881337;
    }

    .info-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .list-item {
        display: flex;
        justify-content: space-between;
        padding: 12px;
        background: #f8fafc;
        border-radius: 8px;
    }

    .item-label { color: #64748b; font-weight: 600; }
    .item-value { color: #0f172a; font-weight: 600; }

    /* Modal Styles */
    .modal-overlay {
        backdrop-filter: blur(5px);
        background: rgba(15, 23, 42, 0.6);
    }
    
    .modal-content {
        border: 1px solid rgba(255,255,255,0.1);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    @media (max-width: 768px) {
        .glass-header-card {
            flex-direction: column;
            text-align: center;
        }
        
        .header-amount {
            text-align: center;
        }
    }
</style>

@php
    $steps = ['created', 'funded', 'shipping', 'delivered', 'completed'];
    $currentStepIndex = array_search($escrow->status === 'disputed' ? 'delivered' : $escrow->status, $steps);
    $progressWidth = max(0, min(100, $currentStepIndex * 25));
@endphp

<div class="detail-container">
    <!-- Header -->
    <div class="glass-header-card">
        <div class="header-info">
            <h1>{{ $escrow->title }}</h1>
            <p>Transaction ID: #{{ $escrow->id }}</p>
        </div>
        <div class="header-amount">
            <div class="amount-label">Escrow Amount</div>
            <div class="amount-display">${{ number_format($escrow->amount, 2) }}</div>
        </div>
    </div>

    <!-- Timeline -->
    <div class="timeline-container">
        <div class="timeline-track">
            <div class="timeline-line"></div>
            <div class="timeline-progress" style="width: {{ $progressWidth }}%"></div>
            
            <div class="timeline-step {{ $currentStepIndex >= 0 ? 'step-active' : '' }} {{ $currentStepIndex > 0 ? 'step-completed' : '' }}">
                <div class="step-dot">📝</div>
                <div class="step-label">Created</div>
            </div>
            <div class="timeline-step {{ $currentStepIndex >= 1 ? 'step-active' : '' }} {{ $currentStepIndex > 1 ? 'step-completed' : '' }}">
                <div class="step-dot">💳</div>
                <div class="step-label">Funded</div>
            </div>
            <div class="timeline-step {{ $currentStepIndex >= 2 ? 'step-active' : '' }} {{ $currentStepIndex > 2 ? 'step-completed' : '' }}">
                <div class="step-dot">📦</div>
                <div class="step-label">Shipped</div>
            </div>
            <div class="timeline-step {{ $currentStepIndex >= 3 ? 'step-active' : '' }} {{ $currentStepIndex > 3 ? 'step-completed' : '' }}">
                <div class="step-dot">✅</div>
                <div class="step-label">Delivered</div>
            </div>
            <div class="timeline-step {{ $currentStepIndex >= 4 ? 'step-active' : '' }} {{ $currentStepIndex > 4 ? 'step-completed' : '' }}">
                <div class="step-dot">🎉</div>
                <div class="step-label">Completed</div>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px;">
        
        <!-- Info Panel -->
        <div class="action-panel">
            <div class="panel-header">
                <div class="panel-icon">ℹ️</div>
                <h3>Transaction Details</h3>
            </div>
            <div class="info-list">
                <div class="list-item">
                    <span class="item-label">Current Status</span>
                    <span class="item-value" style="text-transform: uppercase; color: #6366f1;">{{ $escrow->status }}</span>
                </div>
                <div class="list-item">
                    <span class="item-label">Seller</span>
                    <span class="item-value">{{ $escrow->participants->where('role', 'seller')->first()->user->name ?? 'Unknown' }}</span>
                </div>
                <div class="list-item">
                    <span class="item-label">Buyer</span>
                    <span class="item-value">{{ $escrow->created_by == auth()->id() ? 'You' : $escrow->creator->name }}</span>
                </div>
                <div class="list-item">
                    <span class="item-label">Last Update</span>
                    <span class="item-value">{{ $escrow->updated_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>

        <!-- Actions Panel -->
        <div class="actions-wrapper">
            
            {{-- BUYER ACTIONS --}}
            @if(auth()->user()->hasRole('buyer'))
                @if($escrow->status === 'created')
                    <div class="action-panel">
                        <div class="panel-header">
                            <div class="panel-icon">💳</div>
                            <h3>Payment Required</h3>
                        </div>
                        <p style="color: #64748b; margin-bottom: 20px;">Funds are required to start the shipping process.</p>
                        <button type="button" class="btn-action-primary" onclick="openPaymentModal()">Fund Escrow Now</button>
                    </div>
                @endif

                @if($escrow->status === 'delivered')
                    <div class="action-panel">
                        <div class="panel-header">
                            <div class="panel-icon">✅</div>
                            <h3>Confirm Delivery</h3>
                        </div>
                        <p style="color: #64748b; margin-bottom: 20px;">Please inspect your item. You have until <strong>{{ $escrow->confirm_deadline }}</strong> to release funds.</p>
                        
                        <form method="POST" action="/escrows/{{ $escrow->id }}/release">
                            @csrf
                            <button type="submit" class="btn-action-success" style="margin-bottom: 15px;">Release Funds to Seller</button>
                        </form>

                        <div style="border-top: 1px solid #f1f5f9; padding-top: 20px; margin-top: 20px;">
                            <h4 style="color: #334155; margin-bottom: 15px;">Issues with the item?</h4>
                            <form method="POST" action="/escrows/{{ $escrow->id }}/dispute">
                                @csrf
                                <input type="text" name="reason" class="form-input" placeholder="Describe the issue..." required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 10px;">
                                <button type="submit" class="btn-action-danger" style="padding: 10px;">Open Dispute</button>
                            </form>
                        </div>
                    </div>
                @endif
            @endif

            {{-- SELLER ACTIONS --}}
            @if(auth()->user()->hasRole('seller'))
                @if($escrow->status === 'funded')
                    <div class="action-panel">
                        <div class="panel-header">
                            <div class="panel-icon">📦</div>
                            <h3>Ready to Ship</h3>
                        </div>
                        <p style="color: #64748b; margin-bottom: 20px;">Funds have been secured. Please ship the item.</p>
                        <form method="POST" action="/escrows/{{ $escrow->id }}/ship">
                            @csrf
                            <button type="submit" class="btn-action-primary">Mark as Shipped</button>
                        </form>
                    </div>
                @endif

                @if($escrow->status === 'shipping')
                    <div class="action-panel">
                        <div class="panel-header">
                            <div class="panel-icon">🚚</div>
                            <h3>Shipping in Progress</h3>
                        </div>
                        <p style="color: #64748b; margin-bottom: 20px;">Confirm when the item has reached the buyer.</p>
                        <form method="POST" action="/escrows/{{ $escrow->id }}/deliver">
                            @csrf
                            <button type="submit" class="btn-action-success">Mark as Delivered</button>
                        </form>
                    </div>
                @endif
            @endif

            {{-- DISPUTE ACTIONS --}}
            @if($escrow->status === 'disputed')
                <div class="action-panel dispute-panel">
                    <div class="panel-header">
                        <div class="panel-icon">⚠️</div>
                        <h3>Dispute Active</h3>
                    </div>
                    
                    <div class="info-list" style="margin-bottom: 20px;">
                        <div class="list-item" style="background: white;">
                            <span class="item-label">Reason</span>
                            <span class="item-value">{{ $escrow->dispute->reason }}</span>
                        </div>
                    </div>

                    @if(auth()->user()->hasRole('buyer'))
                        <h4 style="margin-bottom: 10px; color: #881337;">Submit Evidence</h4>
                        <form method="POST" action="{{ route('escrows.dispute.evidence', $escrow) }}" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file" style="margin-bottom: 10px; width: 100%;">
                            @error('file')
                                <div style="color: #ef4444; font-size: 0.85rem; margin-bottom: 10px;">{{ $message }}</div>
                            @enderror
                            <button type="submit" class="btn-action-primary" style="background: #e11d48;">Upload File</button>
                        </form>
                    @endif

                    <h4 style="margin: 20px 0 10px; color: #881337;">Submitted Evidence</h4>
                    @if($escrow->dispute->evidences->count() > 0)
                        <div style="max-height: 250px; overflow-y: auto; padding-right: 5px; border: 1px solid #f1f5f9; border-radius: 8px; padding: 10px; background: #fff1f2;">
                            <ul style="list-style: none; padding: 0; margin: 0;">
                                @foreach($escrow->dispute->evidences as $evidence)
                                    <li style="background: white; padding: 10px; border-radius: 8px; margin-bottom: 8px; border: 1px solid #fecdd3; display: flex; align-items: center; gap: 10px;">
                                        <span>📄</span>
                                        <a href="#" onclick="openEvidenceModal('{{ Storage::url($evidence->file_path) }}'); return false;" style="color: #e11d48; font-weight: 600; text-decoration: none;">
                                            View Evidence #{{ $loop->iteration }}
                                        </a>
                                        <span style="color: #94a3b8; font-size: 0.8rem; margin-left: auto;">
                                            {{ $evidence->created_at->format('M d H:i') }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <p style="color: #be123c; font-size: 0.9rem; font-style: italic;">No evidence submitted yet.</p>
                    @endif

                    @if(auth()->user()->hasRole('arbiter'))
                        <h4 style="margin: 20px 0 10px; color: #881337;">Arbiter Resolution</h4>
                        <form method="POST" action="/escrows/{{ $escrow->id }}/dispute/resolve">
                            @csrf
                            <div style="display: flex; gap: 10px;">
                                <button name="resolution" value="release" class="btn-action-success">Release to Seller</button>
                                <button name="resolution" value="refund" class="btn-action-danger">Refund to Buyer</button>
                            </div>
                        </form>
                    @endif
                </div>
            @endif

        </div>
    </div>
</div>

{{-- Payment Modal Logic (Preserved but styled) --}}
@if(auth()->user()->hasRole('buyer') && $escrow->status === 'created')
<div id="paymentModal" class="modal-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1000; justify-content: center; align-items: center;">
    <div class="modal-content" style="background: white; padding: 30px; border-radius: 20px; width: 90%; max-width: 400px; text-align: center;">
        <h3 style="font-size: 1.5rem; margin-bottom: 10px; font-weight: 700;">Scan to Pay</h3>
        <p style="color: #64748b; margin-bottom: 20px;">Scan this QR code with your mobile app</p>
        
        <div style="background: white; padding: 15px; border-radius: 12px; border: 1px solid #e2e8f0; display: inline-block; margin-bottom: 20px;">
             {!! QrCode::size(200)->generate(rtrim(config('app.url'), '/') . route('escrows.pay', $escrow, false)) !!}
        </div>
        
        <div style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin-bottom: 20px;">
            ${{ number_format($escrow->amount, 2) }}
        </div>

        <div style="display: flex; gap: 10px; flex-direction: column;">
            <form method="POST" action="/escrows/{{ $escrow->id }}/fund">
                @csrf
                <button type="submit" class="btn-action-primary">Confirm Payment</button>
            </form>
            <button onclick="closePaymentModal()" style="background: none; border: none; color: #64748b; cursor: pointer; padding: 10px;">Cancel</button>
        </div>
    </div>
</div>

<script>
    function openPaymentModal() { document.getElementById('paymentModal').style.display = 'flex'; }
    function closePaymentModal() { document.getElementById('paymentModal').style.display = 'none'; }
    window.onclick = function(e) { if(e.target == document.getElementById('paymentModal')) closePaymentModal(); }
</script>
@endif

<!-- Evidence Modal (Generic) -->
<div id="evidenceModal" class="modal-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1000; justify-content: center; align-items: center;">
    <div class="modal-content" style="background: white; padding: 20px; border-radius: 20px; width: 90%; max-width: 800px; max-height: 90vh; text-align: center; position: relative; display: flex; flex-direction: column;">
        <button onclick="closeEvidenceModal()" style="position: absolute; top: 10px; right: 10px; background: #f1f5f9; border: none; border-radius: 50%; width: 30px; height: 30px; cursor: pointer; font-weight: bold; color: #64748b;">✕</button>
        <h3 style="margin-bottom: 15px; color: #334155;">Evidence Preview</h3>
        <div style="flex: 1; overflow: auto; display: flex; align-items: center; justify-content: center; background: #f8fafc; border-radius: 10px; padding: 10px;">
            <img id="evidenceImage" src="" alt="Evidence" style="max-width: 100%; max-height: 70vh; display: none; border-radius: 8px;">
            <p id="evidenceFallback" style="display: none; color: #64748b;">Cannot preview this file type.<br><a id="evidenceLink" href="#" target="_blank" style="color: #6366f1;">Download / View in New Tab</a></p>
        </div>
    </div>
</div>

<script>
    function openEvidenceModal(url) {
        const modal = document.getElementById('evidenceModal');
        const img = document.getElementById('evidenceImage');
        const fallback = document.getElementById('evidenceFallback');
        const link = document.getElementById('evidenceLink');

        modal.style.display = 'flex';
        
        // Simple check for images based on common extensions (not perfect but mostly works for 'photos')
        // Or we just try to load it as an image.
        // For now, let's treat everything as image since user said "photo"
        // But add error handling to show fallback if image fails to load.
        
        img.style.display = 'block';
        img.src = url;
        fallback.style.display = 'none';
        
        img.onerror = function() {
            img.style.display = 'none';
            fallback.style.display = 'block';
            link.href = url;
        };
    }

    function closeEvidenceModal() {
        document.getElementById('evidenceModal').style.display = 'none';
        document.getElementById('evidenceImage').src = '';
    }
    
    // Add close on outside click for evidence modal too
    window.addEventListener('click', function(e) {
        if(e.target == document.getElementById('evidenceModal')) {
            closeEvidenceModal();
        }
    });
</script>
@endsection