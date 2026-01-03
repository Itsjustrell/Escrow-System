@extends('layouts.app')

@section('content')
<style>
    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px;
        border-radius: 12px;
        margin-bottom: 40px;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .dashboard-title {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .dashboard-welcome {
        font-size: 1.2rem;
        opacity: 0.95;
    }

    .section-title {
        font-size: 1.8rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .empty-state {
        background: #f8f9fa;
        padding: 60px 40px;
        border-radius: 12px;
        text-align: center;
        border: 2px dashed #ddd;
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.3;
    }

    .empty-text {
        font-size: 1.1rem;
        color: #666;
    }

    .escrow-table {
        width: 100%;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }

    .escrow-table table {
        width: 100%;
        border-collapse: collapse;
    }

    .escrow-table th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 18px;
        text-align: left;
        font-weight: 600;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .escrow-table td {
        padding: 18px;
        border-bottom: 1px solid #f0f0f0;
        color: #333;
    }

    .escrow-table tr:last-child td {
        border-bottom: none;
    }

    .escrow-table tr:hover {
        background: #f8f9fa;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: capitalize;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-funded {
        background: #d1ecf1;
        color: #0c5460;
    }

    .status-delivered {
        background: #d4edda;
        color: #155724;
    }

    .status-completed {
        background: #d4edda;
        color: #155724;
    }

    .status-disputed {
        background: #f8d7da;
        color: #721c24;
    }

    .btn-view {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 8px 20px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
        display: inline-block;
    }

    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .btn-all-escrows {
        background: white;
        color: #667eea;
        padding: 12px 30px;
        border: 2px solid #667eea;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: inline-block;
        margin-top: 30px;
        transition: all 0.3s;
    }

    .btn-all-escrows:hover {
        background: #667eea;
        color: white;
    }

    .pagination-wrapper {
        margin-top: 25px;
        display: flex;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .dashboard-container {
            padding: 20px 15px;
        }

        .dashboard-header {
            padding: 30px 20px;
        }

        .dashboard-title {
            font-size: 1.8rem;
        }

        .escrow-table {
            overflow-x: auto;
        }

        .escrow-table table {
            min-width: 600px;
        }
    }
</style>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1 class="dashboard-title">Seller Dashboard</h1>
        <p class="dashboard-welcome">Welcome back, <strong>{{ auth()->user()->name }}</strong> 👋</p>
    </div>

    <h3 class="section-title">
        <span>📦</span> Escrows to Process
    </h3>

    @if($escrows->count() === 0)
        <div class="empty-state">
            <div class="empty-icon">📭</div>
            <p class="empty-text">No escrows assigned to you at the moment.</p>
        </div>
    @else
        <div class="escrow-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($escrows as $escrow)
                    <tr>
                        <td><strong>#{{ $escrow->id }}</strong></td>
                        <td>{{ $escrow->title }}</td>
                        <td><strong>${{ number_format($escrow->amount, 2) }}</strong></td>
                        <td>
                            <span class="status-badge status-{{ strtolower($escrow->status) }}">
                                {{ $escrow->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('escrows.show', $escrow) }}" class="btn-view">
                                View Details
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $escrows->links() }}
        </div>
    @endif

    <div style="text-align: center;">
        <a href="{{ route('escrows.index') }}" class="btn-all-escrows">
            View All Escrows →
        </a>
    </div>
</div>

@endsection