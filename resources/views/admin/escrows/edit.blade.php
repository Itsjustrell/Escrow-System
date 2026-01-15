@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <div style="background: white; padding: 30px; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); max-width: 600px; margin: 0 auto;">
        <h2 style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin-bottom: 25px; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px;">
            Edit Escrow
        </h2>

        <form method="POST" action="{{ route('admin.escrows.update', $escrow) }}">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div style="margin-bottom: 20px;">
                <label for="title" style="display: block; font-weight: 600; color: #475569; margin-bottom: 8px;">Transaction Title</label>
                <input id="title" type="text" name="title" value="{{ old('title', $escrow->title) }}" required autofocus
                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;">
                @error('title')
                    <div style="color: #ef4444; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Amount -->
            <div style="margin-bottom: 20px;">
                <label for="amount" style="display: block; font-weight: 600; color: #475569; margin-bottom: 8px;">Amount ($)</label>
                <input id="amount" type="number" step="0.01" name="amount" value="{{ old('amount', $escrow->amount) }}" required
                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;">
                @error('amount')
                    <div style="color: #ef4444; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description -->
            <div style="margin-bottom: 25px;">
                <label for="description" style="display: block; font-weight: 600; color: #475569; margin-bottom: 8px;">Description</label>
                <textarea id="description" name="description" rows="4" 
                    style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; resize: vertical;"
                    placeholder="Write description...">{{ old('description', $escrow->description) }}</textarea>
                @error('description')
                    <div style="color: #ef4444; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: flex; justify-content: flex-end; align-items: center; gap: 15px;">
                <a href="{{ route('admin.escrows') }}" style="color: #64748b; text-decoration: none; font-weight: 500;">Cancel</a>
                <button type="submit" style="background: #4f46e5; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.2s;">
                    Update Escrow
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
