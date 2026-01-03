@extends('layouts.app')

@section('content')
<style>
    .escrows-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .escrows-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px;
        border-radius: 12px;
        margin-bottom: 40px;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .escrows-title {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .escrows-subtitle {
        font-size: 1.1rem;
        opacity: 0.95;
    }

    .filter-bar {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 30px;
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
    }

    .filter-label {
        font-weight: 600;
        color: #333;
    }

    .filter-select {
        padding: 10px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s;
    }

    .filter-select:focus {
        outline: none;
        border-color: #667eea;
    }

    .empty-state {
        background: white;
        padding: 80px 40px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }

    .empty-icon {
        font-size: 5rem;
        margin-bottom: 20px;
        opacity: 0.3;
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }

    .empty-text {
        font-size: 1.1rem;
        color: #666;
    }

    .escrows-table {
        width: 100%;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }

    .escrows-table table {
        width: 100%;
        border-collapse: collapse;
    }

    .escrows-table th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 18px;
        text-align: left;
        font-weight: 600;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .escrows-table td {
        padding: 18px;
        border-bottom: 1px solid #f0f0f0;
        color: #333;
    }

    .escrows-table tr:last-child td {
        border-bottom: none;
    }

    .escrows-table tbody tr:hover {
        background: #f8f9fa;
    }

    .escrow-id {
        font-weight: 700;
        color: #667eea;
    }

    .escrow-title {
        font-weight: 600;
    }

    .escrow-amount {
        font-weight: 700;
        font-size: 1.1rem;
        color: #333;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: capitalize;
    }

    .status-created { background: #e3f2fd; color: #1565c0; }
    .status-funded { background: #fff3cd; color: #856404; }
    .status-shipping { background: #d1ecf1; color: #0c5460; }
    .status-delivered { background: #cfe2ff; color: #084298; }
    .status-completed { background: #d4edda; color: #155724; }
    .status-disputed { background: #f8d7da; color: #721c24; }

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

    .pagination-wrapper {
        margin-top: 25px;
        display: flex;
        justify-content: center;
    }

    .stats-bar {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        text-align: center;
    }

    .stat-icon {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 5px;
    }

    .stat-label {
        color: #666;
        font-size: 0.95rem;
    }

    @media (max-width: 768px) {
        .escrows-container {
            padding: 20px 15px;
        }

        .escrows-header {
            padding: 30px 20px;
        }

        .escrows-title {
            font-size: 1.8rem;
        }

        .filter-bar {
            flex-direction: column;
            align-items: flex-start;
        }

        .filter-select {
            width: 100%;
        }

        .escrows-table {
            overflow-x: auto;
        }

        .escrows-table table {
            min-width: 600px;
        }

        .stats-bar {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="escrows-container">
    <div class="escrows-header">
        <h1 class="escrows-title">All Escrows</h1>
        <p class="escrows-subtitle">Browse and manage all escrow transactions</p>
    </div>

    @if($escrows->count() === 0)
        <div class="empty-state">
            <div class="empty-icon">🔍</div>
            <h3 class="empty-title">No Escrows Found</h3>
            <p class="empty-text">There are no escrow transactions at the moment.</p>
        </div>
    @else
        <!-- Stats Bar (Optional - uncomment if you want to show stats) -->
        <!--
        <div class="stats-bar">
            <div class="stat-card">
                <div class="stat-icon">📊</div>
                <div class="stat-value">{{ $escrows->total() }}</div>
                <div class="stat-label">Total Escrows</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <div class="stat-value">--</div>
                <div class="stat-label">Completed</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">⏳</div>
                <div class="stat-value">--</div>
                <div class="stat-label">In Progress</div>
            </div>
        </div>
        -->

        <!-- Filter Bar (Optional - uncomment if you want to add filters) -->
        <!--
        <div class="filter-bar">
            <span class="filter-label">Filter by:</span>
            <select class="filter-select">
                <option>All Status</option>
                <option>Created</option>
                <option>Funded</option>
                <option>Shipping</option>
                <option>Delivered</option>
                <option>Completed</option>
                <option>Disputed</option>
            </select>
            <select class="filter-select">
                <option>All Time</option>
                <option>Last 7 Days</option>
                <option>Last 30 Days</option>
                <option>Last 90 Days</option>
            </select>
        </div>
        -->

        <div class="escrows-table">
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
                        <td><span class="escrow-id">#{{ $escrow->id }}</span></td>
                        <td><span class="escrow-title">{{ $escrow->title }}</span></td>
                        <td><span class="escrow-amount">${{ number_format($escrow->amount, 2) }}</span></td>
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
</div>

@endsection