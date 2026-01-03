@extends('layouts.app')

@section('content')
<style>
    .escrows-container {
        padding: 40px 0;
    }

    .glass-banner {
        background: radial-gradient(circle at top right, rgba(99, 102, 241, 0.15) 0%, transparent 40%),
                    radial-gradient(circle at bottom left, rgba(168, 85, 247, 0.15) 0%, transparent 60%),
                    #1e293b;
        border-radius: 20px;
        padding: 40px;
        color: white;
        margin-bottom: 30px;
        box-shadow: 0 20px 40px -5px rgba(0, 0, 0, 0.2);
    }

    .banner-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .banner-subtitle {
        color: #94a3b8;
        font-size: 1.1rem;
    }

    .glass-table-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #f8fafc;
        padding: 20px 24px;
        text-align: left;
        font-size: 0.8rem;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0;
    }

    td {
        padding: 20px 24px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 0.95rem;
    }

    tr:last-child td {
        border-bottom: none;
    }

    tr:hover td {
        background: #f8fafc;
    }

    .transaction-id {
        font-family: monospace;
        font-weight: 600;
        color: #64748b;
        background: #f1f5f9;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.85rem;
    }

    .amount-display {
        font-weight: 700;
        color: #0f172a;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
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

    .btn-view {
        color: #6366f1;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: color 0.2s;
    }

    .btn-view:hover {
        color: #4338ca;
    }

    .empty-state {
        text-align: center;
        padding: 80px 40px;
        background: white;
        border-radius: 20px;
        border: 2px dashed #e2e8f0;
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.5;
    }
</style>

<div class="escrows-container">
    <div class="glass-banner">
        <h1 class="banner-title">All Transactions</h1>
        <p class="banner-subtitle">Manage and track your secure payments</p>
    </div>

    @if($escrows->count() === 0)
        <div class="empty-state">
            <div class="empty-icon">🔍</div>
            <h3 style="margin-bottom: 10px; color: #334155;">No records found</h3>
            <p style="color: #64748b;">You haven't participated in any transactions yet.</p>
        </div>
    @else
        <div class="glass-table-card">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($escrows as $escrow)
                        <tr>
                            <td>
                                <span class="transaction-id">#{{ $escrow->id }}</span>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #1e293b;">{{ $escrow->title }}</div>
                            </td>
                            <td>
                                <span class="amount-display">${{ number_format($escrow->amount, 2) }}</span>
                            </td>
                            <td>
                                <span class="status-badge status-{{ strtolower($escrow->status) }}">
                                    {{ $escrow->status }}
                                </span>
                            </td>
                            <td style="color: #64748b; font-size: 0.9rem;">
                                {{ $escrow->created_at->format('M d, Y') }}
                            </td>
                            <td>
                                <a href="{{ route('escrows.show', $escrow) }}" class="btn-view">
                                    View Details →
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div style="margin-top: 40px; display: flex; justify-content: center;">
            {{ $escrows->links() }}
        </div>
    @endif
</div>
@endsection