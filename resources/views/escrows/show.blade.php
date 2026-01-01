@extends('layouts.app')

@section('content')

<h1>Escrow Detail</h1>

<p><strong>Title:</strong> {{ $escrow->title }}</p>
<p><strong>Amount:</strong> {{ number_format($escrow->amount, 2) }}</p>
<p><strong>Status:</strong> {{ $escrow->status }}</p>

<hr>

{{-- ========================= --}}
{{-- BUYER ACTIONS --}}
{{-- ========================= --}}
@if(auth()->user()->hasRole('buyer'))

    @if($escrow->status === 'created')
        <form method="POST" action="/escrows/{{ $escrow->id }}/fund">
            @csrf
            <button type="submit">Fund Escrow</button>
        </form>
    @endif

    @if($escrow->status === 'delivered')
        <form method="POST" action="/escrows/{{ $escrow->id }}/release">
            @csrf
            <button type="submit">Release Funds</button>
        </form>

        <br>

        <form method="POST" action="/escrows/{{ $escrow->id }}/dispute">
            @csrf
            <input type="text" name="reason" placeholder="Dispute reason" required>
            <button type="submit">Open Dispute</button>
        </form>

        <p>
            <small>
                Auto-release deadline:
                {{ $escrow->confirm_deadline }}
            </small>
        </p>
    @endif

@endif

{{-- ========================= --}}
{{-- SELLER ACTIONS --}}
{{-- ========================= --}}
@if(auth()->user()->hasRole('seller'))

    @if($escrow->status === 'funded')
        <form method="POST" action="/escrows/{{ $escrow->id }}/ship">
            @csrf
            <button type="submit">Mark as Shipped</button>
        </form>
    @endif

    @if($escrow->status === 'shipping')
        <form method="POST" action="/escrows/{{ $escrow->id }}/deliver">
            @csrf
            <button type="submit">Mark as Delivered</button>
        </form>
    @endif

@endif

{{-- ========================= --}}
{{-- DISPUTED STATE --}}
{{-- ========================= --}}
@if($escrow->status === 'disputed')

    <h3>Dispute Information</h3>

    <p><strong>Reason:</strong> {{ $escrow->dispute->reason }}</p>
    <p><strong>Status:</strong> {{ $escrow->dispute->status }}</p>

    {{-- BUYER: UPLOAD EVIDENCE --}}
    @if(auth()->user()->hasRole('buyer'))
        <form method="POST"
            action="{{ route('escrows.dispute.evidence', $escrow) }}"
            enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" required>
            <button type="submit">Upload Evidence</button>
        </form>
    @endif

    {{-- LIST EVIDENCES --}}
    <h4>Evidences</h4>
    <ul>
        @foreach($escrow->dispute->evidences as $evidence)
            <li>
                <a href="{{ Storage::url($evidence->file_path) }}" target="_blank">
                    View Evidence
                </a>
            </li>
        @endforeach
    </ul>

    {{-- ARBITER ACTION --}}
    @if(auth()->user()->hasRole('arbiter'))
        <form method="POST"
              action="/escrows/{{ $escrow->id }}/dispute/resolve">
            @csrf
            <button name="resolution" value="release">
                Release to Seller
            </button>
            <button name="resolution" value="refund">
                Refund to Buyer
            </button>
        </form>
    @endif

@endif

@endsection
