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

    /* Avatar & Badges */
    .user-avatar {
        width: 40px; height: 40px; background: #e0e7ff; 
        color: #4338ca; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; 
        font-weight: 700; font-size: 1.1rem; margin-right: 15px;
    }
    .role-badge {
        display: inline-flex; align-items: center; padding: 4px 12px; 
        border-radius: 20px; font-size: 0.75rem; font-weight: 700; 
        text-transform: uppercase; letter-spacing: 0.5px;
    }
    .role-buyer { background: #e0f2fe; color: #0369a1; }
    .role-seller { background: #fef9c3; color: #854d0e; }
    .role-admin { background: #fee2e2; color: #991b1b; }
    .role-arbiter { background: #f3e8ff; color: #6b21a8; }
</style>

<div class="dashboard-container">
    <div class="glass-banner">
        <div class="banner-content">
            <a href="{{ route('dashboard') }}" class="back-link">&larr; Back to Dashboard</a>
            <h1>User Management</h1>
            <p>Manage all registered users and their roles.</p>
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
                        <th style="width: 300px;">User Profile</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined Date</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center;">
                                <div class="user-avatar">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div style="font-weight: 600; color: #1e293b;">{{ $user->name }}</div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="role-badge role-{{ strtolower($role->name) }}">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td style="text-align: right;">
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: transparent; border: none; color: #ef4444; font-weight: 600; cursor: pointer; transition: color 0.2s;" onmouseover="this.style.color='#b91c1c'" onmouseout="this.style.color='#ef4444'">
                                        Delete
                                    </button>
                                </form>
                            @else
                                <span style="color: #cbd5e1; font-weight: 500; cursor: not-allowed;">Delete</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div style="padding: 20px; border-top: 1px solid #e2e8f0;">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
