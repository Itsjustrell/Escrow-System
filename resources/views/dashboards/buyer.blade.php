@extends('layouts.app')

@section('content')
<style>
    .dashboard-container {
        padding: 40px 0;
    }

    .glass-banner {
        background: radial-gradient(circle at top right, rgba(99, 102, 241, 0.15) 0%, transparent 40%),
                    radial-gradient(circle at bottom left, rgba(168, 85, 247, 0.15) 0%, transparent 60%),
                    #1e293b;
        border-radius: 20px;
        padding: 40px;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 40px;
        box-shadow: 0 20px 40px -5px rgba(0, 0, 0, 0.2);
    }

    .banner-content {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .welcome-text h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 5px;
        letter-spacing: -1px;
    }

    .welcome-text p {
        color: #94a3b8;
        font-size: 1.1rem;
    }

    .btn-action {
        background: white;
        color: #0f172a;
        padding: 12px 28px;
        border-radius: 12px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 25px;
    }

    .section-header h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #334155;
    }

    .section-icon {
        width: 32px;
        height: 32px;
        background: #e0e7ff;
        color: #4f46e5;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .grid-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 25px;
    }

    .transaction-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .transaction-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        border-color: #6366f1;
    }

    .card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .card-id {
        font-size: 0.85rem;
        font-weight: 600;
        color: #94a3b8;
        background: #f1f5f9;
        padding: 4px 10px;
        border-radius: 6px;
    }

    .card-amount {
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f172a;
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 20px;
        line-height: 1.4;
    }

    .status-pill {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Status Colors */
    .status-created { background: #e0f2fe; color: #0369a1; }
    .status-funded { background: #fef9c3; color: #854d0e; }
    .status-shipping { background: #e0e7ff; color: #4338ca; }
    .status-delivered { background: #dbeafe; color: #1e40af; }
    .status-completed { background: #dcfce7; color: #15803d; }
    .status-disputed { background: #fee2e2; color: #991b1b; }
    .status-cancelled { background: #f1f5f9; color: #475569; }

    .card-footer {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
        text-align: right;
    }

    .link-details {
        color: #6366f1;
        font-weight: 600;
        text-decoration: none;
        font-size: 0.95rem;
        transition: color 0.2s;
    }

    .link-details:hover {
        color: #4338ca;
    }

    .empty-state {
        text-align: center;
        padding: 60px;
        background: white;
        border-radius: 20px;
        border: 2px dashed #e2e8f0;
    }

    @media (max-width: 768px) {
        .banner-content {
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
        }
        
        .btn-action {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="dashboard-container">
    <!-- Premium Banner -->
    <div class="glass-banner">
        <div class="banner-content">
            <div class="welcome-text">
                <h1>Buyer Dashboard</h1>
                <p>Welcome back, {{ auth()->user()->name }}! Ready to secure your next deal?</p>
            </div>
            <a href="{{ route('escrows.create') }}" class="btn-action">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Transaction
            </a>
        </div>
    </div>

    <!-- Active Transactions -->
    <div class="section-header">
        <div class="section-icon">🛒</div>
        <h3>Your Active Escrows</h3>
    </div>

    @if($escrows->count() === 0)
        <div class="empty-state">
            <div style="font-size: 3rem; margin-bottom: 15px;">🛍️</div>
            <h3 style="margin-bottom: 10px; color: #334155;">No transactions yet</h3>
            <p style="color: #64748b; margin-bottom: 25px;">Start creating safe transactions with EscrowSecure.</p>
            <a href="{{ route('escrows.create') }}" style="color: #6366f1; font-weight: 600; text-decoration: none;">Create Escrow &rarr;</a>
        </div>
    @else
        <div class="grid-cards">
            @foreach($escrows as $escrow)
            <div class="transaction-card">
                <div class="card-top">
                    <span class="card-id">#TRANS-{{ $escrow->id }}</span>
                    <span class="status-pill status-{{ strtolower($escrow->status) }}">
                        {{ $escrow->status }}
                    </span>
                </div>
                
                <h4 class="card-title">{{ $escrow->title }}</h4>
                <div class="card-amount">${{ number_format($escrow->amount, 2) }}</div>
                
                <div class="card-footer">
                    <a href="{{ route('escrows.show', $escrow) }}" class="link-details">View Details &rarr;</a>
                </div>
            </div>
            @endforeach
        </div>


    @endif
</div>
@endsection