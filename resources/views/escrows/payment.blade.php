@extends('layouts.app')

@section('content')
<div style="max-width: 500px; margin: 0 auto; padding: 20px;">
    <div style="text-align: center; margin-bottom: 30px;">
        <h1 style="color: #333; font-size: 1.5rem; margin-bottom: 10px;">Confirm Payment</h1>
        <p style="color: #666;">Transaction #{{ $escrow->id }}</p>
    </div>

    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 25px;">
        <div style="text-align: center; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #f0f0f0;">
            <p style="margin: 0; font-size: 0.9rem; color: #888; text-transform: uppercase; letter-spacing: 1px;">Amount to Pay</p>
            <h2 style="margin: 10px 0 0; font-size: 2.5rem; color: #667eea;">${{ number_format($escrow->amount, 2) }}</h2>
            <p style="margin-top: 5px; color: #555;">for "{{ $escrow->title }}"</p>
        </div>

        @if($escrow->status === 'created')
            <form method="POST" action="/escrows/{{ $escrow->id }}/fund">
                @csrf
                <input type="hidden" name="redirect_to" value="mobile_success">
                <button type="submit" 
                        style="width: 100%; padding: 15px; border: none; border-radius: 8px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-weight: bold; font-size: 1.1rem; cursor: pointer; transition: transform 0.2s; box-shadow: 0 4px 6px rgba(102, 126, 234, 0.3);">
                    Confirm Payment
                </button>
            </form>
        @else
            <div style="text-align: center; padding: 20px; background: #e3f2fd; color: #1565c0; border-radius: 8px;">
                <strong>Payment Completed</strong>
                <p style="margin: 5px 0 0;">This transaction has already been funded.</p>
            </div>
        @endif
    </div>

    <div style="text-align: center;">
        <a href="{{ route('escrows.show', $escrow) }}" style="color: #666; text-decoration: none; font-size: 0.9rem;">Back to Details</a>
    </div>
</div>
@endsection
