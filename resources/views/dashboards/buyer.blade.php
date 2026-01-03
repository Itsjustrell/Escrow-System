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
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .header-content {
        flex: 1;
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

    .btn-create {
        background: white;
        color: #667eea;
        padding: 14px 28px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.25);
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
        margin-bottom: 30px;
    }

    .btn-empty-create {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 14px 32px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-empty-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }

    .escrow-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }

    .escrow-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        transition: all 0.3s;
        border: 2px solid transparent;
    }

    .escrow-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        border-color: #667eea;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 15px;
    }

    .card-id {
        font-size: 0.9rem;
        color: #999;
        font-weight: 600;
    }

    .card-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 15px;
    }

    .card-amount {
        font-size: 1.8rem;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 15px;
    }

    .card-status {
        margin-bottom: 20px;
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
        padding: 10px 24px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        display: inline-block;
        transition: all 0.3s;
        text-align: center;
        width: 100%;
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

    @media (max-width: 768px) {
        .dashboard-container {
            padding: 20px 15px;
        }

        .dashboard-header {
            padding: 30px 20px;
            flex-direction: column;
            align-items: flex-start;
        }

        .dashboard-title {
            font-size: 1.8rem;
        }

        .btn-create {
            width: 100%;
            justify-content: center;
        }

        .escrow-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="dashboard-container">
    <div class="dashboard-header">
        <div class="header-content">
            <h1 class="dashboard-title">Buyer Dashboard</h1>
            <p class="dashboard-welcome">Welcome back, <strong>{{ auth()->user()->name }}</strong> 👋</p>
        </div>
        <a href="{{ route('escrows.create') }}" class="btn-create">
            <span style="font-size: 1.2rem;">+</span>
            Create New Escrow
        </a>
    </div>

    <h3 class="section-title">
        <span>🛒</span> Your Escrows
    </h3>

    @if($escrows->count() === 0)
        <div class="empty-state">
            <div class="empty-icon">📦</div>
            <h3 class="empty-title">No Escrows Yet</h3>
            <p class="empty-text">Start your first secure transaction by creating an escrow</p>
            <a href="{{ route('escrows.create') }}" class="btn-empty-create">
                <span style="font-size: 1.2rem;">+</span>
                Create Your First Escrow
            </a>
        </div>
    @else
        <div class="escrow-grid">
            @foreach($escrows as $escrow)
            <div class="escrow-card">
                <div class="card-header">
                    <span class="card-id">#{{ $escrow->id }}</span>
                </div>
                <h3 class="card-title">{{ $escrow->title }}</h3>
                <div class="card-amount">${{ number_format($escrow->amount, 2) }}</div>
                <div class="card-status">
                    <span class="status-badge status-{{ strtolower($escrow->status) }}">
                        {{ $escrow->status }}
                    </span>
                </div>
                <a href="{{ route('escrows.show', $escrow) }}" class="btn-view">
                    View Details →
                </a>
            </div>
            @endforeach
        </div>

        <div class="pagination-wrapper" style="display: flex; justify-content: center; margin-top: 30px;">
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