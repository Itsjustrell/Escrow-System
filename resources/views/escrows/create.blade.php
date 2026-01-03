@extends('layouts.app')

@section('content')
<style>
    .form-container {
        max-width: 700px;
        margin: 40px auto;
    }

    .glass-form {
        background: white;
        border-radius: 24px;
        box-shadow: 0 20px 40px -5px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: 1px solid rgba(226, 232, 240, 0.8);
    }

    .form-header {
        background: radial-gradient(circle at top right, rgba(99, 102, 241, 0.15) 0%, transparent 40%),
                    radial-gradient(circle at bottom left, rgba(168, 85, 247, 0.15) 0%, transparent 60%),
                    #1e293b;
        padding: 40px;
        color: white;
        text-align: center;
    }

    .form-title {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 10px;
        letter-spacing: -0.5px;
    }

    .form-subtitle {
        color: #94a3b8;
        font-size: 1.05rem;
    }

    .form-body {
        padding: 40px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        display: block;
        font-weight: 700;
        color: #334155;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .input-wrapper {
        position: relative;
    }

    .form-input,
    .form-select {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.2s;
        box-sizing: border-box;
        background: #f8fafc;
        color: #0f172a;
    }

    .form-input:focus,
    .form-select:focus {
        outline: none;
        border-color: #6366f1;
        background: white;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        font-weight: 600;
    }

    .has-icon .form-input {
        padding-left: 40px;
    }

    .form-helper {
        color: #64748b;
        font-size: 0.85rem;
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-submit {
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        color: white;
        padding: 16px 40px;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.2s;
        width: 100%;
        margin-top: 10px;
        box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.4);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px -5px rgba(99, 102, 241, 0.5);
    }

    .btn-cancel {
        display: block;
        text-align: center;
        margin-top: 20px;
        color: #64748b;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }

    .btn-cancel:hover {
        color: #475569;
    }

    .error-msg {
        color: #ef4444;
        font-size: 0.85rem;
        margin-top: 6px;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .form-container {
            margin: 20px auto;
            padding: 0 15px;
        }
        
        .form-body {
            padding: 25px;
        }
    }
</style>

<div class="form-container">
    <div class="glass-form">
        <div class="form-header">
            <h1 class="form-title">Start New Transaction</h1>
            <p class="form-subtitle">Create a secure escrow agreement</p>
        </div>

        <div class="form-body">
            <form method="POST" action="{{ route('escrows.store') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">What are you buying/selling?</label>
                    <input type="text" 
                           name="title" 
                           class="form-input" 
                           value="{{ old('title') }}"
                           placeholder="e.g., iPhone 15 Pro Max 256GB">
                    @error('title')<div class="error-msg">⚠️ {{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Transaction Amount</label>
                    <div class="input-wrapper has-icon">
                        <span class="input-icon">$</span>
                        <input type="number" 
                               name="amount" 
                               class="form-input" 
                               value="{{ old('amount') }}"
                               placeholder="0.00"
                               step="0.01"
                               min="0.01">
                    </div>
                    @error('amount')<div class="error-msg">⚠️ {{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Inspection Period (Days)</label>
                    <input type="number" 
                           name="confirmation_window" 
                           class="form-input"
                           min="1" 
                           max="7"
                           value="{{ old('confirmation_window', 3) }}">
                    <div class="form-helper">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Time allowed for buyer to inspect goods (1-7 days)
                    </div>
                    @error('confirmation_window')<div class="error-msg">⚠️ {{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Select Seller</label>
                    <select name="seller_id" class="form-select ">
                        <option value="">Choose a verified seller...</option>
                        @foreach($sellers as $seller)
                            <option value="{{ $seller->id }}" {{ old('seller_id') == $seller->id ? 'selected' : '' }}>
                                {{ $seller->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('seller_id')<div class="error-msg">⚠️ {{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn-submit">
                    Create & Fund Escrow →
                </button>

                <a href="{{ route('dashboard') }}" class="btn-cancel">Cancel Transaction</a>
            </form>
        </div>
    </div>
</div>
@endsection