<h1>Buyer Dashboard</h1>

<p>Welcome, {{ auth()->user()->name }}</p>

<hr>

<h3>Your Escrows</h3>

@if($escrows->count() === 0)
    <p>No escrows yet.</p>
@else
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        @foreach($escrows as $escrow)
        <tr>
            <td>{{ $escrow->id }}</td>
            <td>{{ $escrow->title }}</td>
            <td>{{ $escrow->amount }}</td>
            <td>{{ $escrow->status }}</td>
            <td>
                <a href="{{ route('escrows.show', $escrow) }}">
                    View
                </a>
            </td>
        </tr>
        @endforeach
    </table>

    <br>
    {{ $escrows->links() }}
@endif

<hr>

<a href="{{ route('escrows.index') }}">View All Escrows</a>
