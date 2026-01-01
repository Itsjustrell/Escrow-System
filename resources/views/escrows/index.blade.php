<h2>Escrow List</h2>

<form method="GET">
    <input type="text" name="q" placeholder="Search title..." value="{{ request('q') }}">
    <button type="submit">Search</button>
</form>

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
            <a href="{{ route('escrows.show', $escrow) }}">View</a>
        </td>
    </tr>
    @endforeach
</table>

{{ $escrows->links() }}
