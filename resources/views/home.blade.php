@extends('layouts.app')

@section('content')
<style>
    .hero-section {
        text-align: center;
        padding: 60px 20px 80px;
        background: radial-gradient(circle at top right, rgba(99, 102, 241, 0.15) 0%, transparent 40%),
                    radial-gradient(circle at bottom left, rgba(168, 85, 247, 0.15) 0%, transparent 40%);
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 20px;
        background: linear-gradient(135deg, #1e293b 0%, #475569 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        line-height: 1.2;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        color: #64748b;
        max-width: 700px;
        margin: 0 auto 40px;
        line-height: 1.6;
    }

    .hero-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
    }

    .btn-hero-primary {
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        color: white;
        padding: 15px 40px;
        border-radius: 50px;
        font-weight: 700;
        text-decoration: none;
        font-size: 1.1rem;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 10px 25px rgba(99, 102, 241, 0.4);
    }

    .btn-hero-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(99, 102, 241, 0.5);
    }

    .btn-hero-secondary {
        background: white;
        color: #475569;
        padding: 15px 40px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        font-size: 1.1rem;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }

    .btn-hero-secondary:hover {
        border-color: #cbd5e1;
        transform: translateY(-3px);
        background: #f8fafc;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 60px;
    }

    .feature-card {
        background: white;
        padding: 30px;
        border-radius: 20px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s, box-shadow 0.3s;
        position: relative;
        overflow: hidden;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px -5px rgba(0, 0, 0, 0.1);
        border-color: #6366f1;
    }

    .feature-icon {
        width: 50px;
        height: 50px;
        background: #eff6ff;
        color: #6366f1;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 20px;
    }

    .feature-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 10px;
    }

    .feature-desc {
        color: #64748b;
        line-height: 1.5;
    }

    .badge-check {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #dcfce7;
        color: #166534;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        position: absolute;
        top: 20px;
        right: 20px;
    }

    .badge-soon {
        background: #f1f5f9;
        color: #64748b;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        position: absolute;
        top: 20px;
        right: 20px;
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }
        
        .hero-buttons {
            flex-direction: column;
        }

        .btn-hero-primary, .btn-hero-secondary {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="hero-section">
    <h1 class="hero-title">Secure Transactions,<br>Simplified.</h1>
    <p class="hero-subtitle">
        The modern escrow platform protecting your digital transactions. 
        Whether you're buying services or selling goods, we ensure peace of mind for everyone involved.
    </p>
    
    <div class="hero-buttons">
        @auth
            <a href="{{ route('escrows.create') }}" class="btn-hero-primary">Start Transaction</a>
            <a href="{{ route('dashboard') }}" class="btn-hero-secondary">Go to Dashboard</a>
        @else
            <a href="{{ route('register') }}" class="btn-hero-primary">Get Started Free</a>
            <a href="{{ route('login') }}" class="btn-hero-secondary">Sign In</a>
        @endauth
    </div>
</div>

<div class="features-grid">
    <!-- Feature 1: QR Payment -->
    <div class="feature-card">
        <span class="badge-check">✓ Live</span>
        <div class="feature-icon">📱</div>
        <h3 class="feature-title">QR Code Payments</h3>
        <p class="feature-desc">
            Instantly fund transactions by scanning a secure QR code directly from your mobile device. Fast, simple, and error-free.
        </p>
    </div>

    <!-- Feature 2: Secure Escrow -->
    <div class="feature-card">
        <span class="badge-check">✓ Live</span>
        <div class="feature-icon">🛡️</div>
        <h3 class="feature-title">Secure Escrow Engine</h3>
        <p class="feature-desc">
            Funds are held safely until both parties are satisfied. Includes comprehensive dispute resolution and evidence handling.
        </p>
    </div>

    <!-- Feature 3: File Upload -->
    <div class="feature-card">
        <span class="badge-check">✓ Live</span>
        <div class="feature-icon">📂</div>
        <h3 class="feature-title">Evidence Management</h3>
        <p class="feature-desc">
            Securely upload and manage transaction evidence using our integrated File Storage system during dispute resolution.
        </p>
    </div>

    <!-- Feature 4: Middleware Security -->
    <div class="feature-card">
        <span class="badge-check">✓ Live</span>
        <div class="feature-icon">🔒</div>
        <h3 class="feature-title">Advanced Security</h3>
        <p class="feature-desc">
            Custom Middleware ensures transaction integrity, enforcing strict state transitions and role-based access control.
        </p>
    </div>

    <!-- Feature 5: Export/Import -->
    <div class="feature-card" style="opacity: 0.7;">
        <span class="badge-soon">Coming Soon</span>
        <div class="feature-icon">📊</div>
        <h3 class="feature-title">Data Export/Import</h3>
        <p class="feature-desc">
            Seamlessly migrate your transaction history. Export to CSV/PDF for accounting or batch import new orders instantly.
        </p>
    </div>

    <!-- Feature 6: Real-time Notifications -->
    <div class="feature-card" style="opacity: 0.7;">
        <span class="badge-soon">Coming Soon</span>
        <div class="feature-icon">🔔</div>
        <h3 class="feature-title">Real-time Updates</h3>
        <p class="feature-desc">
            Stay in the loop with instant push notifications and email alerts for every step of your transaction journey.
        </p>
    </div>
    
    <!-- Feature 7: API Integration -->
    <div class="feature-card" style="opacity: 0.7;">
        <span class="badge-soon">Coming Soon</span>
        <div class="feature-icon">🔌</div>
        <h3 class="feature-title">API Integration</h3>
        <p class="feature-desc">
            Connect your favorite tools. Payment gateways (Stripe/Midtrans), Google Maps for logistics, and Social Login.
        </p>
    </div>

    <!-- Feature 8: Dark Mode -->
    <div class="feature-card" style="opacity: 0.7;">
        <span class="badge-soon">Coming Soon</span>
        <div class="feature-icon">🌙</div>
        <h3 class="feature-title">Dark Mode</h3>
        <p class="feature-desc">
            A fully immersive dark theme for those late-night trading sessions. Easy on the eyes, sleek in design.
        </p>
    </div>
</div>
@endsection