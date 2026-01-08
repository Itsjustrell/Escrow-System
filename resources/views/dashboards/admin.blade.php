@extends('layouts.app')

@section('content')
<style>
    /* --- CORE LAYOUT (Sama dengan Buyer/Seller) --- */
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

    /* Headers */
    .section-header { display: flex; align-items: center; gap: 12px; margin-bottom: 25px; margin-top: 40px; }
    .section-header h3 { font-size: 1.5rem; font-weight: 700; color: #334155; }
    .section-icon {
        width: 32px; height: 32px; background: #e0e7ff; color: #4f46e5;
        border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
    }

    /* --- ADMIN SPECIFIC: STATS GRID --- */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }
    .stat-card {
        background: white; border-radius: 16px; padding: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        position: relative; overflow: hidden;
        transition: transform 0.2s;
    }
    .stat-card:hover { transform: translateY(-3px); }
    .stat-label { font-size: 0.9rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
    .stat-value { font-size: 2.2rem; font-weight: 800; color: #0f172a; margin-top: 5px; }
    /* Border Accents */
    .accent-blue { border-left: 5px solid #3b82f6; }
    .accent-yellow { border-left: 5px solid #eab308; }
    .accent-green { border-left: 5px solid #22c55e; }

    /* --- TABLES (Mata Elang) --- */
    .modern-table-card {
        background: white; border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0; overflow: hidden;
    }
    .table-container { width: 100%; overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    th {
        background: #f8fafc; padding: 16px 24px; text-align: left;
        font-size: 0.8rem; font-weight: 700; color: #475569;
        text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #e2e8f0;
    }
    td { padding: 20px 24px; border-bottom: 1px solid #f1f5f9; color: #334155; font-size: 0.95rem; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #f8fafc; }

    /* --- STATUS BADGES --- */
    .status-badge { display: inline-flex; align-items: center; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; }
    .status-created { background: #e0f2fe; color: #0369a1; }
    .status-funded { background: #fef9c3; color: #854d0e; }
    .status-shipping { background: #e0e7ff; color: #4338ca; }
    .status-delivered { background: #dbeafe; color: #1e40af; }
    .status-completed { background: #dcfce7; color: #15803d; }
    .status-disputed { background: #fee2e2; color: #991b1b; }

    /* --- LAYOUT SPLIT (Table & User List) --- */
    .dashboard-split { display: grid; grid-template-columns: 2fr 1fr; gap: 25px; }
    @media (max-width: 1024px) { .dashboard-split { grid-template-columns: 1fr; } }

    .user-list-item {
        display: flex; justify-content: space-between; align-items: center;
        padding: 15px 20px; border-bottom: 1px solid #f1f5f9;
    }
    .user-avatar {
        width: 40px; height: 40px; background: #f1f5f9; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; font-weight: bold; color: #64748b; margin-right: 15px;
    }
    .user-info h5 { margin: 0; font-size: 0.95rem; color: #1e293b; }
    .user-info span { font-size: 0.8rem; color: #94a3b8; }
</style>

<div class="dashboard-container">
    <div class="glass-banner">
        <div class="banner-content">
            <h1>Admin Dashboard</h1>
            <p>Eagle Eye View: Monitoring system performance and transactions.</p>
            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <a href="{{ route('admin.users') }}" style="background: rgba(255,255,255,0.2); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; border: 1px solid rgba(255,255,255,0.3);">
                    Manage Users
                </a>
                <a href="{{ route('admin.escrows') }}" style="background: rgba(255,255,255,0.2); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; border: 1px solid rgba(255,255,255,0.3);">
                    Manage Escrows
                </a>
            </div>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card accent-blue">
            <div class="stat-label">Total Registered Users</div>
            <div class="stat-value">{{ $totalUsers }}</div>
        </div>
        <div class="stat-card accent-yellow">
            <div class="stat-label">Active Escrows</div>
            <div class="stat-value">{{ $activeEscrows }}</div>
        </div>
        <div class="stat-card accent-green">
            <div class="stat-label">Funds in Escrow</div>
            <div class="stat-value" style="color: #15803d;">
                Rp {{ number_format($totalEscrowAmount, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <div class="section-header">
        <div class="section-icon">📈</div>
        <h3>Transaction Analytics</h3>
    </div>
    <div class="modern-table-card" style="padding: 20px; margin-bottom: 40px;">
        <div style="position: relative; height: 300px; width: 100%;">
            <canvas id="adminChart"></canvas>
        </div>
    </div>

    <div class="dashboard-split">
        
        <div>
            <div class="section-header" style="margin-top: 0;">
                <div class="section-icon">🦅</div>
                <h3>Recent Transactions</h3>
            </div>
            <div class="modern-table-card">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Parties</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentEscrows as $escrow)
                            <tr>
                                <td><span style="font-family: monospace; color: #64748b;">#{{ $escrow->id }}</span></td>
                                <td>
                                    <div style="font-size: 0.9rem; font-weight: 600;">B: {{ $escrow->buyer->name ?? 'N/A' }}</div>
                                    <div style="font-size: 0.9rem; color: #64748b;">S: {{ $escrow->seller->name ?? 'N/A' }}</div>
                                </td>
                                <td style="font-weight: 700;">$ {{ number_format($escrow->amount) }}</td>
                                <td>
                                    <span class="status-badge status-{{ strtolower($escrow->status) }}">
                                        {{ $escrow->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" style="text-align: center;">No Data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div>
            <div class="section-header" style="margin-top: 0;">
                <div class="section-icon">👥</div>
                <h3>Newest Users</h3>
            </div>
            <div class="modern-table-card">
                @if(isset($recentUsers) && count($recentUsers) > 0)
                    @foreach($recentUsers as $user)
                    <div class="user-list-item">
                        <div style="display: flex; align-items: center;">
                            <div class="user-avatar">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div class="user-info">
                                <h5>{{ $user->name }}</h5>
                                <span>{{ $user->email }}</span>
                            </div>
                        </div>
                        <span style="font-size: 0.75rem; background: #f1f5f9; padding: 2px 8px; rounded: 4px;">
                            {{ $user->role ?? 'User' }}
                        </span>
                    </div>
                    @endforeach
                @else
                    <div style="padding: 20px; text-align: center; color: #94a3b8;">No users found.</div>
                @endif
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('adminChart').getContext('2d');
        
        // Data dari Laravel Controller
        const labels = {!! json_encode($labels ?? []) !!};
        const data = {!! json_encode($data ?? []) !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Monthly Transactions',
                    data: data,
                    borderColor: '#4f46e5', // Indigo color matching theme
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    borderWidth: 3,
                    tension: 0.4, // Kurva halus
                    fill: true,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#4f46e5',
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: { stepSize: 1 }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endsection