@extends('layouts.app')

@section('content')
<style>
    .form-container {
        max-width: 700px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .form-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        text-align: center;
    }

    .form-title {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .form-subtitle {
        font-size: 1.1rem;
        opacity: 0.95;
    }

    .form-card {
        background: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        font-size: 1rem;
    }

    .form-label-icon {
        margin-right: 8px;
    }

    .form-input,
    .form-select {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s;
        box-sizing: border-box;
    }

    .form-input:focus,
    .form-select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }

    .form-input::placeholder {
        color: #999;
    }

    .form-error {
        color: #dc3545;
        font-size: 0.9rem;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .form-helper {
        color: #666;
        font-size: 0.9rem;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .btn-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 16px 40px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s;
        width: 100%;
        margin-top: 10px;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }

    .btn-cancel {
        background: white;
        color: #667eea;
        padding: 16px 40px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s;
        width: 100%;
        text-decoration: none;
        display: inline-block;
        text-align: center;
        margin-top: 15px;
        box-sizing: border-box;
    }

    .btn-cancel:hover {
        border-color: #667eea;
        color: #667eea;
    }

    .input-prefix {
        position: relative;
    }

    .input-prefix .form-input {
        padding-left: 35px;
    }

    .prefix-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .form-container {
            padding: 20px 15px;
        }

        .form-header {
            padding: 30px 20px;
        }

        .form-title {
            font-size: 1.8rem;
        }

        .form-card {
            padding: 25px 20px;
        }
    }
</style>

<div class="form-container">
    <div class="form-header">
        <h1 class="form-title">Create New Escrow</h1>
        <p class="form-subtitle">Set up a secure transaction with a seller</p>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('escrows.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">
                    <span class="form-label-icon">📋</span>
                    Transaction Title
                </label>
                <input type="text" 
                       name="title" 
                       class="form-input" 
                       value="{{ old('title') }}"
                       placeholder="e.g., Purchase MacBook Pro 2024">
                @error('title') 
                    <div class="form-error">
                        ⚠️ {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    <span class="form-label-icon">💰</span>
                    Amount (USD)
                </label>
                <div class="input-prefix">
                    <span class="prefix-icon">$</span>
                    <input type="number" 
                           name="amount" 
                           class="form-input" 
                           value="{{ old('amount') }}"
                           placeholder="0.00"
                           step="0.01"
                           min="0.01">
                </div>
                @error('amount') 
                    <div class="form-error">
                        ⚠️ {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    <span class="form-label-icon">⏰</span>
                    Confirmation Window (days)
                </label>
                <input type="number" 
                       name="confirmation_window" 
                       class="form-input"
                       min="1" 
                       max="7"
                       value="{{ old('confirmation_window', 3) }}"
                       placeholder="3">
                <div class="form-helper">
                    ℹ️ Days you have to confirm delivery (1-7 days)
                </div>
                @error('confirmation_window') 
                    <div class="form-error">
                        ⚠️ {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    <span class="form-label-icon">👤</span>
                    Select Seller
                </label>
                <select name="seller_id" class="form-select">
                    <option value="">-- Choose a Seller --</option>
                    @foreach($sellers as $seller)
                        <option value="{{ $seller->id }}" {{ old('seller_id') == $seller->id ? 'selected' : '' }}>
                            {{ $seller->name }}
                        </option>
                    @endforeach
                </select>
                @error('seller_id') 
                    <div class="form-error">
                        ⚠️ {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn-submit">
                Create Escrow Transaction
            </button>

            <a href="{{ route('dashboard') }}" class="btn-cancel">
                Cancel
            </a>
        </form>
    </div>
</div>

@endsection