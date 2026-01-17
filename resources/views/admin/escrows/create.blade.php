@extends('layouts.app')

@section('content')
<style>
    .dashboard-container { padding: 40px 0; max-width: 1200px; margin: 0 auto; }

    /* Glass Banner */
    .glass-banner {
        background: radial-gradient(circle at top right, rgba(99, 102, 241, 0.15) 0%, transparent 40%),
                    radial-gradient(circle at bottom left, rgba(168, 85, 247, 0.15) 0%, transparent 60%),
                    #1e293b;
        border-radius: 24px;
        padding: 40px;
        color: white;
        margin-bottom: 40px;
        box-shadow: 0 20px 40px -5px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .banner-content h1 { font-size: 2.2rem; font-weight: 800; margin-bottom: 5px; letter-spacing: -0.5px; }
    .banner-content p { color: #94a3b8; font-size: 1.1rem; }
    
    .back-link {
        display: inline-flex; align-items: center; 
        color: #94a3b8; text-decoration: none; font-weight: 500;
        margin-bottom: 20px; transition: color 0.2s;
    }
    .back-link:hover { color: white; }

    /* Form Card */
    .form-card {
        background: white; border-radius: 24px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
        border: 1px solid #e2e8f0;
        overflow: hidden;
        max-width: 900px; margin: 0 auto;
    }
    
    .form-header {
        background: #f8fafc; padding: 25px 40px; border-bottom: 1px solid #e2e8f0;
        display: flex; align-items: center; gap: 12px;
    }
    .form-header h2 { font-size: 1.25rem; color: #0f172a; font-weight: 700; margin: 0; letter-spacing: -0.5px; }
    .header-icon {
        width: 38px; height: 38px; background: #e0e7ff; color: #4f46e5;
        border-radius: 10px; display: flex; align-items: center; justify-content: center;
    }
    .header-icon svg { width: 20px; height: 20px; }
    
    .form-body { padding: 40px; }

    /* Inputs - PERBAIKAN UTAMA */
    .form-group { margin-bottom: 25px; position: relative; }
    .form-label { 
        display: block; 
        font-weight: 600; 
        color: #334155; 
        margin-bottom: 10px; 
        font-size: 0.85rem; 
        text-transform: uppercase; 
        letter-spacing: 0.6px; 
    }
    
    .input-wrapper { 
        position: relative;
        display: flex;
        align-items: center;
    }
    .input-icon {
        position: absolute; 
        left: 16px; 
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8; 
        pointer-events: none;
        transition: color 0.2s; 
        display: flex; 
        align-items: center; 
        justify-content: center;
        width: 24px;
        height: 24px;
    }
    .input-icon svg { 
        width: 22px; 
        height: 22px; 
    }
    
    .form-input, .form-select {
        width: 100%; 
        height: 52px;
        padding: 0 16px 0 52px;
        border: 1px solid #cbd5e1; 
        border-radius: 12px; 
        font-size: 0.95rem; 
        transition: all 0.2s; 
        background: #fff;
        color: #1e293b; 
        font-weight: 500;
        line-height: 1.5;
        box-sizing: border-box;
    }
    
    /* Perbaikan khusus untuk select */
    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 16px center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 48px;
    }
    
    .form-textarea {
        width: 100%; 
        padding: 16px; 
        border: 1px solid #cbd5e1; 
        border-radius: 12px; 
        font-size: 0.95rem; 
        transition: all 0.2s; 
        background: #fff;
        color: #1e293b; 
        font-weight: 500;
        line-height: 1.5;
        resize: vertical;
        min-height: 120px;
        box-sizing: border-box;
    }

    .form-input:focus, .form-select:focus, .form-textarea:focus {
        border-color: #6366f1; 
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); 
        outline: none;
    }
    .form-input:focus + .input-icon, 
    .form-input:focus ~ .input-icon,
    .form-select:focus + .input-icon,
    .form-select:focus ~ .input-icon { 
        color: #6366f1; 
    }

    /* Grid Layout */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
    }
    
    .full-width {
        grid-column: span 2;
    }

    /* Buttons */
    .form-actions {
        display: flex; 
        justify-content: flex-end; 
        align-items: center; 
        gap: 20px; 
        margin-top: 50px; 
        padding-top: 30px; 
        border-top: 1px solid #f1f5f9;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: white; 
        border: none; 
        padding: 0 32px; /* Rely on flex centering */
        border-radius: 12px; 
        font-weight: 600; 
        cursor: pointer; 
        transition: all 0.2s;
        box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3);
        display: inline-flex; 
        align-items: center; 
        gap: 8px;
        height: 52px;
        box-sizing: border-box; /* IMPORTANT */
    }
    .btn-primary:hover { 
        transform: translateY(-2px); 
        box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4); 
    }
    
    .btn-secondary {
        background: white; 
        border: 1px solid #cbd5e1; 
        color: #64748b;
        padding: 0 32px; /* Rely on flex centering */
        border-radius: 12px; 
        font-weight: 600; 
        text-decoration: none;
        transition: all 0.2s;
        height: 52px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box; /* IMPORTANT */
    }
    .btn-secondary:hover { 
        background: #f8fafc; 
        color: #1e293b; 
        border-color: #94a3b8; 
    }

    /* Error Messages */
    .error-message {
        color: #ef4444; 
        font-size: 0.85rem; 
        margin-top: 6px;
    }

    /* Helper Text */
    .helper-text {
        font-size: 0.8rem; 
        color: #94a3b8; 
        margin-top: 6px;
    }
</style>

<div class="dashboard-container">
    <div class="glass-banner">
        <div class="banner-content">
            <a href="{{ route('admin.escrows') }}" class="back-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px;">
                    <path d="M19 12H5"/>
                    <path d="M12 19l-7-7 7-7"/>
                </svg>
                Back to Escrows
            </a>
            <h1>Create New Escrow</h1>
            <p>Manually initiate a secure transaction between users.</p>
        </div>
    </div>

    <div class="form-card">
        <div class="form-header">
            <div class="header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    <path d="m9 12 2 2 4-4"/>
                </svg>
            </div>
            <h2>Transaction Details</h2>
        </div>
        
        <div class="form-body">
            <form method="POST" action="{{ route('admin.escrows.store') }}">
                @csrf
                
                <div class="form-grid">
                    <!-- Title -->
                    <div class="form-group full-width">
                        <label for="title" class="form-label">Title / Item Name</label>
                        <div class="input-wrapper">
                            <input id="title" type="text" name="title" value="{{ old('title') }}" required autofocus
                                class="form-input" placeholder="e.g. iPhone 15 Pro Max - Titanium">
                            <span class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"/>
                                    <path d="M7 7h.01"/>
                                </svg>
                            </span>
                        </div>
                        @error('title')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <!-- Buyer -->
                    <div class="form-group">
                        <label for="buyer_id" class="form-label">Buyer</label>
                        <div class="input-wrapper">
                            <select id="buyer_id" name="buyer_id" required class="form-select">
                                <option value="">Select Buyer...</option>
                                @foreach($buyers as $buyer)
                                    <option value="{{ $buyer->id }}" {{ old('buyer_id') == $buyer->id ? 'selected' : '' }}>
                                        {{ $buyer->name }} ({{ $buyer->email }})
                                    </option>
                                @endforeach
                            </select>
                            <span class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                            </span>
                        </div>
                        @error('buyer_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <!-- Seller -->
                    <div class="form-group">
                        <label for="seller_id" class="form-label">Seller</label>
                        <div class="input-wrapper">
                            <select id="seller_id" name="seller_id" required class="form-select">
                                <option value="">Select Seller...</option>
                                @foreach($sellers as $seller)
                                    <option value="{{ $seller->id }}" {{ old('seller_id') == $seller->id ? 'selected' : '' }}>
                                        {{ $seller->name }} ({{ $seller->email }})
                                    </option>
                                @endforeach
                            </select>
                            <span class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"/>
                                    <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/>
                                    <path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"/>
                                    <path d="M2 7h20"/>
                                    <path d="M22 7v3a2 2 0 0 1-2 2v0a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 16 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 12 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 8 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 4 12v0a2 2 0 0 1-2-2V7"/>
                                </svg>
                            </span>
                        </div>
                        @error('seller_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <!-- Amount -->
                    <div class="form-group">
                        <label for="amount" class="form-label">Transaction Amount</label>
                        <div class="input-wrapper">
                            <input id="amount" type="number" step="0.01" name="amount" value="{{ old('amount') }}" required
                                class="form-input" placeholder="0.00">
                            <span class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="1" x2="12" y2="23"/>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                                </svg>
                            </span>
                        </div>
                        @error('amount')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <!-- Confirmation Window -->
                    <div class="form-group">
                        <label for="confirmation_window" class="form-label">Inspection Period</label>
                        <div class="input-wrapper">
                            <input id="confirmation_window" type="number" name="confirmation_window" value="{{ old('confirmation_window', 3) }}" min="1" max="30" required
                                class="form-input" placeholder="Days">
                            <span class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                            </span>
                        </div>
                        <div class="helper-text">Number of days for buyer to inspect item.</div>
                        @error('confirmation_window')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <!-- Description -->
                    <div class="form-group full-width">
                        <label for="description" class="form-label">Terms / Description</label>
                        <textarea id="description" name="description" rows="5" 
                            class="form-textarea"
                            placeholder="Detailed description of the agreement...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
    
                <div class="form-actions">
                    <a href="{{ route('admin.escrows') }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/>
                            <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/>
                            <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/>
                            <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/>
                        </svg>
                        Create Secure Escrow
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection