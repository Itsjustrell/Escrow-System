@extends('layouts.app')

@section('content')

<h1>Transaction Escrow System</h1>

<p>
    A simulated escrow platform that ensures fair transactions between
    buyers and sellers through a structured, state-based process.
</p>

<hr>

<h3>How It Works</h3>
<ol>
    <li>Buyer creates an escrow</li>
    <li>Funds are held by the system</li>
    <li>Seller delivers goods/services</li>
    <li>Funds are released after confirmation</li>
</ol>

<hr>

@auth
    <a href="{{ route('dashboard') }}">
        <button>Go to Dashboard</button>
    </a>
@else
    <a href="{{ route('login') }}">
        <button>Login</button>
    </a>

    <a href="{{ route('register') }}">
        <button>Register</button>
    </a>
@endauth

@endsection
