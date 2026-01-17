@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <div style="background: white; padding: 30px; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); max-width: 800px; margin: 0 auto;">
        <h2 style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin-bottom: 25px; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px;">
            Create New Escrow
        </h2>

        <form method="POST" action="{{ route('admin.escrows.store') }}">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <!-- Title -->
                <div style="grid-column: span 2; margin-bottom: 10px;">
                    <label for="title" style="display: block; font-weight: 600; color: #475569; margin-bottom: 8px;">Transaction Title</label>
                    <input id="title" type="text" name="title" value="{{ old('title') }}" required autofocus
                        style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;">
                    @error('title')
                        <div style="color: #ef4444; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Buyer -->
                <div style="margin-bottom: 15px;">
                    <label for="buyer_id" style="display: block; font-weight: 600; color: #475569; margin-bottom: 8px;">Select Buyer</label>
                    <select id="buyer_id" name="buyer_id" required
                        style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; background: white;">
                        <option value="">-- Select Buyer --</option>
                        @foreach($buyers as $buyer)
                            <option value="{{ $buyer->id }}" {{ old('buyer_id') == $buyer->id ? 'selected' : '' }}>
                                {{ $buyer->name }} ({{ $buyer->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('buyer_id')
                        <div style="color: #ef4444; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Seller -->
                <div style="margin-bottom: 15px;">
                    <label for="seller_id" style="display: block; font-weight: 600; color: #475569; margin-bottom: 8px;">Select Seller</label>
                    <select id="seller_id" name="seller_id" required
                        style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; background: white;">
                        <option value="">-- Select Seller --</option>
                        @foreach($sellers as $seller)
                            <option value="{{ $seller->id }}" {{ old('seller_id') == $seller->id ? 'selected' : '' }}>
                                {{ $seller->name }} ({{ $seller->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('seller_id')
                        <div style="color: #ef4444; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Amount -->
                <div style="margin-bottom: 15px;">
                    <label for="amount" style="display: block; font-weight: 600; color: #475569; margin-bottom: 8px;">Amount ($)</label>
                    <input id="amount" type="number" step="0.01" name="amount" value="{{ old('amount') }}" required
                        style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;">
                    @error('amount')
                        <div style="color: #ef4444; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirmation Window -->
                <div style="margin-bottom: 15px;">
                    <label for="confirmation_window" style="display: block; font-weight: 600; color: #475569; margin-bottom: 8px;">Inspection Period (Days)</label>
                    <input id="confirmation_window" type="number" name="confirmation_window" value="{{ old('confirmation_window', 3) }}" min="1" max="30" required
                        style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;">
                    @error('confirmation_window')
                        <div style="color: #ef4444; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div style="grid-column: span 2; margin-bottom: 25px;">
                    <label for="description" style="display: block; font-weight: 600; color: #475569; margin-bottom: 8px;">Description (Optional)</label>
                    <textarea id="description" name="description" rows="4" 
                        style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; resize: vertical;"
                        placeholder="Write description...">{{ old('description') }}</textarea>
                    @error('description')
                        <div style="color: #ef4444; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div style="display: flex; justify-content: flex-end; align-items: center; gap: 15px; margin-top: 10px;">
                <a href="{{ route('admin.escrows') }}" style="color: #64748b; text-decoration: none; font-weight: 500;">Cancel</a>
                <button type="submit" style="background: #4f46e5; color: white; border: none; padding: 10px 25px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.2s;">
                    Create Escrow
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
