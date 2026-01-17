@extends('layouts.app')

@section('content')
<style>
    /* --- SHARED ADMIN STYLES --- */
    .dashboard-container { padding: 40px 0; }

    /* Banner Gradient Premium */
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
    .banner-content { position: relative; z-index: 2; }
    .banner-content h1 { font-size: 2.5rem; font-weight: 800; margin-bottom: 5px; letter-spacing: -1px; }
    .banner-content p { color: #94a3b8; font-size: 1.1rem; }
    
    .back-link {
        display: inline-flex; align-items: center; 
        color: #94a3b8; text-decoration: none; font-weight: 500;
        margin-bottom: 20px; transition: color 0.2s;
    }
    .back-link:hover { color: white; }

    /* Tables */
    .modern-table-card {
        background: white; border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0; overflow: hidden;
    }
    .table-container { width: 100%; overflow-x: auto; max-height: 600px; overflow-y: auto; }
    table { width: 100%; border-collapse: collapse; }
    th {
        background: #f8fafc; padding: 16px 24px; text-align: left;
        font-size: 0.8rem; font-weight: 700; color: #475569;
        text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #e2e8f0;
    }
    td { padding: 20px 24px; border-bottom: 1px solid #f1f5f9; color: #334155; font-size: 0.95rem; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #f8fafc; }

    /* Status Badges */
    .status-badge { display: inline-flex; align-items: center; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
    .status-created { background: #e0f2fe; color: #0369a1; }
    .status-funded { background: #fef9c3; color: #854d0e; }
    .status-shipping { background: #e0e7ff; color: #4338ca; }
    .status-delivered { background: #dbeafe; color: #1e40af; }
    .status-completed { background: #dcfce7; color: #15803d; }
    .status-disputed { background: #fee2e2; color: #991b1b; }
    .status-cancelled { background: #f1f5f9; color: #64748b; text-decoration: line-through; }
    .status-refunded { background: #fee2e2; color: #991b1b; }

    /* Action Buttons */
    .btn-view {
        color: #4f46e5; font-weight: 600; text-decoration: none; margin-right: 15px;
    }
    .btn-view:hover { color: #4338ca; text-decoration: underline; }
    
    .btn-cancel {
        background: none; border: none; color: #ef4444; font-weight: 600; cursor: pointer;
    }
    .btn-cancel:hover { color: #b91c1c; text-decoration: underline; }

</style>

<div class="dashboard-container">
    <div class="glass-banner">
        <div class="banner-content">
            <a href="{{ route('dashboard') }}" class="back-link">&larr; Back to Dashboard</a>
            <h1>Escrow Management</h1>
            <p>Monitor and manage all escrow transactions.</p>
            <div style="margin-top: 15px; display: flex; gap: 10px;">
                <a href="{{ route('admin.escrows.create') }}" style="background: white; color: #4f46e5; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    + Create New Escrow
                </a>
                <a href="{{ route('admin.export.escrows') }}" class="btn-view" style="color: white; border: 1px solid rgba(255,255,255,0.3); padding: 8px 16px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    Download CSV Report 📥
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #dcfce7; border: 1px solid #86efac; color: #15803d; padding: 16px; border-radius: 12px; margin-bottom: 25px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 16px; border-radius: 12px; margin-bottom: 25px;">
            {{ session('error') }}
        </div>
    @endif

    <div class="modern-table-card">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Transaction Title</th>
                        <th>Buyer</th>
                        <th>Seller</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($escrows as $escrow)
                    <tr>
                        <td>
                            <span style="font-family: monospace; color: #64748b; font-weight: 600;">#{{ $escrow->id }}</span>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #1e293b;">{{ $escrow->title }}</div>
                            <div style="font-size: 0.8rem; color: #94a3b8;">Created {{ $escrow->created_at->diffForHumans() }}</div>
                        </td>
                        <td>{{ $escrow->buyer->name ?? 'N/A' }}</td>
                        <td>{{ $escrow->seller->name ?? 'N/A' }}</td>
                        <td>
                            <div style="font-weight: 700; color: #0f172a;">$ {{ number_format($escrow->amount) }}</div>
                        </td>
                        <td>
                            <span class="status-badge status-{{ strtolower($escrow->status) }}">
                                {{ $escrow->status }}
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <a href="{{ route('escrows.show', $escrow) }}" class="btn-view">View Details</a>
                            <a href="{{ route('admin.escrows.edit', $escrow) }}" class="btn-view" style="color: #059669;">Edit</a>
                            
                            @if(!in_array($escrow->status, ['completed', 'cancelled', 'refunded', 'released', 'disputed']))
                                <form action="{{ route('admin.escrows.cancel', $escrow) }}" method="POST" onsubmit="return confirm('ADMIN OVERRIDE: Are you sure you want to forcibly cancel this escrow? This cannot be undone.');" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-cancel" style="margin-right: 15px;" title="Cancel Transaction">Cancel</button>
                                </form>
                            @endif

                             <form action="{{ route('admin.escrows.destroy', $escrow) }}" method="POST" onsubmit="return confirm('PERMANENT DELETE: Are you sure? This will remove all records of this transaction from the database.');" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-cancel" style="color: #991b1b;" title="Delete Permanently">🗑️</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
