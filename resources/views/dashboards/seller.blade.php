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
    }

    .banner-content h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 5px;
        letter-spacing: -1px;
    }

    .banner-content p {
        color: #94a3b8;
        font-size: 1.1rem;
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

    .modern-table-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .table-container {
        width: 100%;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #f8fafc;
        padding: 16px 24px;
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

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    /* Status Colors */
    .status-created { background: #e0f2fe; color: #0369a1; }
    .status-funded { background: #fef9c3; color: #854d0e; }
    .status-shipping { background: #e0e7ff; color: #4338ca; }
    .status-delivered { background: #dbeafe; color: #1e40af; }
    .status-completed { background: #dcfce7; color: #15803d; }
    .status-disputed { background: #fee2e2; color: #991b1b; }

    .btn-view-sm {
        color: #6366f1;
        font-weight: 600;
        text-decoration: none;
        font-size: 0.9rem;
        padding: 6px 12px;
        border-radius: 6px;
        background: #eef2ff;
        transition: all 0.2s;
    }

    .btn-view-sm:hover {
        background: #6366f1;
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 60px;
        background: white;
        border-radius: 20px;
        border: 2px dashed #e2e8f0;
    }
</style>

<div class="dashboard-container">
    <div class="glass-banner">
        <div class="banner-content">
            <h1>Seller Dashboard</h1>
            <p>Track your incoming orders and manage shipments efficiently.</p>
        </div>
    </div>

    <div class="section-header">
        <div class="section-icon">📦</div>
        <h3>Incoming Orders</h3>
    </div>

    @if($escrows->count() === 0)
        <div class="empty-state">
            <div style="font-size: 3rem; margin-bottom: 15px;">�</div>
            <h3 style="margin-bottom: 10px; color: #334155;">No orders yet</h3>
            <p style="color: #64748b;">Waiting for buyers to create transactions with you.</p>
        </div>
    @else
        <div class="modern-table-card">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Title</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($escrows as $escrow)
                        <tr>
                            <td>
                                <span style="font-family: monospace; color: #64748b;">#TRANS-{{ $escrow->id }}</span>
                            </td>
                            <td>
                                <div style="font-weight: 600;">{{ $escrow->title }}</div>
                                <div style="font-size: 0.85rem; color: #94a3b8;">{{ $escrow->created_at->format('M d, Y') }}</div>
                            </td>
                            <td style="font-weight: 700; color: #0f172a;">
                                ${{ number_format($escrow->amount, 2) }}
                            </td>
                            <td>
                                <span class="status-badge status-{{ strtolower($escrow->status) }}">
                                    {{ $escrow->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('escrows.show', $escrow) }}" class="btn-view-sm">
                                    Manage
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