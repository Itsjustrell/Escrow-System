@extends('layouts.app')

@section('content')
<style>
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 80px 20px;
        text-align: center;
    }

    .hero-title {
        font-size: 3rem;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .hero-subtitle {
        font-size: 1.2rem;
        margin-bottom: 40px;
        opacity: 0.9;
    }

    .btn-primary {
        background: white;
        color: #667eea;
        padding: 15px 40px;
        border: none;
        border-radius: 8px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        margin: 0 10px;
        transition: all 0.3s;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    .btn-secondary {
        background: transparent;
        color: white;
        padding: 15px 40px;
        border: 2px solid white;
        border-radius: 8px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        margin: 0 10px;
        transition: all 0.3s;
    }

    .btn-secondary:hover {
        background: white;
        color: #667eea;
    }

    .steps-section {
        max-width: 1200px;
        margin: 60px auto;
        padding: 0 20px;
    }

    .steps-title {
        text-align: center;
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 50px;
        color: #333;
    }

    .steps-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
    }

    .step-card {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: all 0.3s;
    }

    .step-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }

    .step-number {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .step-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: #333;
    }

    .step-desc {
        color: #666;
        line-height: 1.6;
    }

    .button-group {
        margin-top: 30px;
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }
        
        .btn-primary, .btn-secondary {
            display: block;
            width: 100%;
            margin: 10px 0;
        }
    }
</style>

<div class="hero-section">
    <h1 class="hero-title">Transaction Escrow System</h1>
    <p class="hero-subtitle">
        A simulated escrow platform that ensures fair transactions between<br>
        buyers and sellers through a structured, state-based process.
    </p>

    <div class="button-group">
        @auth
            <a href="{{ route('dashboard') }}">
                <button class="btn-primary">Go to Dashboard</button>
            </a>
        @else
            <a href="{{ route('register') }}">
                <button class="btn-primary">Register</button>
            </a>
            <a href="{{ route('login') }}">
                <button class="btn-secondary">Login</button>
            </a>
        @endauth
    </div>
</div>

<div class="steps-section">
    <h2 class="steps-title">How It Works</h2>
    
    <div class="steps-grid">
        <div class="step-card">
            <div class="step-number">1</div>
            <h3 class="step-title">Buyer Creates Escrow</h3>
            <p class="step-desc">
                The buyer initiates the transaction by creating an escrow agreement with the seller.
            </p>
        </div>

        <div class="step-card">
            <div class="step-number">2</div>
            <h3 class="step-title">Funds Are Held</h3>
            <p class="step-desc">
                The system securely holds the buyer's funds until all conditions are met.
            </p>
        </div>

        <div class="step-card">
            <div class="step-number">3</div>
            <h3 class="step-title">Seller Delivers</h3>
            <p class="step-desc">
                The seller delivers the goods or services as agreed in the transaction.
            </p>
        </div>

        <div class="step-card">
            <div class="step-number">4</div>
            <h3 class="step-title">Funds Released</h3>
            <p class="step-desc">
                After confirmation, the funds are released to the seller automatically.
            </p>
        </div>
    </div>
</div>

@endsection