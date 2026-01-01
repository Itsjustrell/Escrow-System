@extends('layouts.app')

@section('content')

<h1>Create Escrow</h1>

<form method="POST" action="{{ route('escrows.store') }}">
    @csrf

    <div>
        <label>Title</label><br>
        <input type="text" name="title" value="{{ old('title') }}">
        @error('title') <div>{{ $message }}</div> @enderror
    </div>

    <br>

    <div>
        <label>Amount</label><br>
        <input type="number" name="amount" value="{{ old('amount') }}">
        @error('amount') <div>{{ $message }}</div> @enderror
    </div>

    <br>

    <div>
        <label>Confirmation Window (days)</label><br>
        <input type="number" name="confirmation_window" min="1" max="7"
               value="{{ old('confirmation_window') }}">
        @error('confirmation_window') <div>{{ $message }}</div> @enderror
    </div>

    <br>

    <div>
        <label>Select Seller</label><br>
        <select name="seller_id">
            <option value="">-- Choose Seller --</option>
            @foreach($sellers as $seller)
                <option value="{{ $seller->id }}">
                    {{ $seller->name }}
                </option>
            @endforeach
        </select>
        @error('seller_id') <div>{{ $message }}</div> @enderror
    </div>

    <br>

    <button type="submit">Create Escrow</button>
</form>

@endsection
