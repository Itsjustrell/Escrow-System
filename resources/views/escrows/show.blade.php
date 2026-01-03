@extends('layouts.app')

@section('content')
<style>
    .detail-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .detail-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .detail-title {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .detail-subtitle {
        opacity: 0.9;
    }

    .info-card {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 25px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 15px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #666;
    }

    .info-value {
        font-weight: 600;
        color: #333;
    }

    .amount-value {
        font-size: 1.5rem;
        color: #667eea;
    }

    .status-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: capitalize;
    }

    .status-created { background: #e3f2fd; color: #1565c0; }
    .status-funded { background: #fff3cd; color: #856404; }
    .status-shipping { background: #d1ecf1; color: #0c5460; }
    .status-delivered { background: #cfe2ff; color: #084298; }
    .status-completed { background: #d4edda; color: #155724; }
    .status-disputed { background: #f8d7da; color: #721c24; }

    .action-card {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 25px;
    }

    .action-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 1rem;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .btn-danger {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 1rem;
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 87, 108, 0.4);
    }

    .btn-success {
        background: linear-gradient(135deg, #a8edea 0%, #43cea2 100%);
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 1rem;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(67, 206, 162, 0.4);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-input {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s;
    }

    .form-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .file-input {
        padding: 10px;
        border: 2px dashed #e0e0e0;
        border-radius: 8px;
        cursor: pointer;
    }

    .alert-info {
        background: #e3f2fd;
        border-left: 4px solid #2196f3;
        padding: 15px 20px;
        border-radius: 8px;
        margin-top: 15px;
    }

    .dispute-section {
        background: #fff3cd;
        padding: 25px;
        border-radius: 12px;
        border-left: 4px solid #ffc107;
        margin-bottom: 25px;
    }

    .dispute-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #856404;
        margin-bottom: 15px;
    }

    .evidence-list {
        list-style: none;
        padding: 0;
    }

    .evidence-item {
        background: white;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .evidence-link {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
    }

    .evidence-link:hover {
        text-decoration: underline;
    }

    .button-group {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .detail-container {
            padding: 20px 15px;
        }

        .detail-header {
            padding: 25px 20px;
        }

        .info-row {
            flex-direction: column;
            gap: 5px;
        }

        .button-group {
            flex-direction: column;
        }

        .button-group button {
            width: 100%;
        }
    }
</style>

<div class="detail-container">
    <div class="detail-header">
        <h1 class="detail-title">Escrow Detail</h1>
        <p class="detail-subtitle">Transaction ID: #{{ $escrow->id }}</p>
    </div>

    <div class="info-card">
        <div class="info-row">
            <span class="info-label">📋 Title</span>
            <span class="info-value">{{ $escrow->title }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">💰 Amount</span>
            <span class="info-value amount-value">${{ number_format($escrow->amount, 2) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">📊 Status</span>
            <span class="status-badge status-{{ strtolower($escrow->status) }}">
                {{ $escrow->status }}
            </span>
        </div>
    </div>

    {{-- ========================= --}}
    {{-- BUYER ACTIONS --}}
    {{-- ========================= --}}
    @if(auth()->user()->hasRole('buyer'))

        @if($escrow->status === 'created')
            <div class="action-card">
                <h3 class="action-title">💳 Fund this Escrow</h3>
                <button type="button" class="btn-primary" onclick="openPaymentModal()">Fund Escrow</button>
            </div>
        @endif

        @if($escrow->status === 'delivered')
            <div class="action-card">
                <h3 class="action-title">✅ Confirm Delivery</h3>
                <form method="POST" action="/escrows/{{ $escrow->id }}/release">
                    @csrf
                    <button type="submit" class="btn-success">Release Funds to Seller</button>
                </form>

                <hr style="margin: 25px 0; border: none; border-top: 1px solid #e0e0e0;">

                <h3 class="action-title">⚠️ Report an Issue</h3>
                <form method="POST" action="/escrows/{{ $escrow->id }}/dispute">
                    @csrf
                    <div class="form-group">
                        <input type="text" 
                               name="reason" 
                               class="form-input" 
                               placeholder="Describe the issue with this transaction" 
                               required>
                    </div>
                    <button type="submit" class="btn-danger">Open Dispute</button>
                </form>

                <div class="alert-info">
                    <strong>⏰ Auto-release deadline:</strong> {{ $escrow->confirm_deadline }}
                </div>
            </div>
        @endif

    @endif

    {{-- ========================= --}}
    {{-- SELLER ACTIONS --}}
    {{-- ========================= --}}
    @if(auth()->user()->hasRole('seller'))

        @if($escrow->status === 'funded')
            <div class="action-card">
                <h3 class="action-title">📦 Ship the Item</h3>
                <form method="POST" action="/escrows/{{ $escrow->id }}/ship">
                    @csrf
                    <button type="submit" class="btn-primary">Mark as Shipped</button>
                </form>
            </div>
        @endif

        @if($escrow->status === 'shipping')
            <div class="action-card">
                <h3 class="action-title">✅ Confirm Delivery</h3>
                <form method="POST" action="/escrows/{{ $escrow->id }}/deliver">
                    @csrf
                    <button type="submit" class="btn-success">Mark as Delivered</button>
                </form>
            </div>
        @endif

    @endif

    {{-- ========================= --}}
    {{-- DISPUTED STATE --}}
    {{-- ========================= --}}
    @if($escrow->status === 'disputed')

        <div class="dispute-section">
            <h3 class="dispute-title">⚠️ Dispute Information</h3>
            
            <div class="info-row">
                <span class="info-label">Reason</span>
                <span class="info-value">{{ $escrow->dispute->reason }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status</span>
                <span class="status-badge status-{{ strtolower($escrow->dispute->status) }}">
                    {{ $escrow->dispute->status }}
                </span>
            </div>
        </div>

        {{-- BUYER: UPLOAD EVIDENCE --}}
        @if(auth()->user()->hasRole('buyer'))
            <div class="action-card">
                <h3 class="action-title">📎 Upload Evidence</h3>
                <form method="POST"
                    action="{{ route('escrows.dispute.evidence', $escrow) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="file" name="file" class="file-input" required>
                    </div>
                    <button type="submit" class="btn-primary">Upload Evidence</button>
                </form>
            </div>
        @endif

        {{-- LIST EVIDENCES --}}
        <div class="action-card">
            <h3 class="action-title">📁 Submitted Evidence</h3>
            @if($escrow->dispute->evidences->count() > 0)
                <ul class="evidence-list">
                    @foreach($escrow->dispute->evidences as $evidence)
                        <li class="evidence-item">
                            📄
                            <a href="{{ Storage::url($evidence->file_path) }}" 
                               target="_blank" 
                               class="evidence-link">
                                View Evidence #{{ $loop->iteration }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p style="color: #666;">No evidence submitted yet.</p>
            @endif
        </div>

        {{-- ARBITER ACTION --}}
        @if(auth()->user()->hasRole('arbiter'))
            <div class="action-card">
                <h3 class="action-title">⚖️ Resolve Dispute</h3>
                <form method="POST" action="/escrows/{{ $escrow->id }}/dispute/resolve">
                    @csrf
                    <div class="button-group">
                        <button name="resolution" value="release" class="btn-success">
                            ✅ Release to Seller
                        </button>
                        <button name="resolution" value="refund" class="btn-danger">
                            💸 Refund to Buyer
                        </button>
                    </div>
                </form>
            </div>
        @endif

    @endif

    @if(auth()->user()->hasRole('buyer') && $escrow->status === 'created')
    <!-- Payment Modal -->
    <div id="paymentModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Scan to Pay</h3>
                <button type="button" class="close-btn" onclick="closePaymentModal()">&times;</button>
            </div>
            <div class="modal-body" style="text-align: center;">
                <p>Please scan the QR code below to fund this escrow.</p>
                <div style="margin: 20px auto; display: inline-block; padding: 10px; background: white; border: 1px solid #ddd; border-radius: 8px;">
                    {!! QrCode::size(200)->generate(
                        rtrim(config('app.url'), '/') . route('escrows.pay', $escrow, false)
                    ) !!}
                </div>
                <p class="amount-value" style="font-size: 1.2rem;">Total: ${{ number_format($escrow->amount, 2) }}</p>
            </div>
            <div class="modal-footer">
                <form method="POST" action="/escrows/{{ $escrow->id }}/fund">
                    @csrf
                    <button type="submit" class="btn-primary" style="width: 100%;">Confirm Payment</button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-header h3 {
            margin: 0;
            color: #333;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #666;
        }

        .modal-footer {
            margin-top: 20px;
        }
    </style>

    <script>
        function openPaymentModal() {
            document.getElementById('paymentModal').style.display = 'flex';
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').style.display = 'none';
        }

        // Close on click outside
        window.onclick = function(event) {
            var modal = document.getElementById('paymentModal');
            if (event.target == modal) {
                closePaymentModal();
            }
        }
    </script>
    @endif


</div>

@endsection