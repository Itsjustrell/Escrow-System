@extends('layouts.app')

@section('content')

<h1>Buyer Dashboard</h1>

<p>Welcome, {{ auth()->user()->name }}</p>

<a href="{{ route('escrows.create') }}">
    <button style="padding:10px 16px; margin-bottom:20px;">
        + Create New Escrow
    </button>
</a>

<hr>

<h3>Your Escrows</h3>

@if($escrows->count() === 0)
    <p>No escrows yet.</p>
@else
    ...
@endif

<a href="{{ route('escrows.index') }}">View All Escrows</a>

@endsection
