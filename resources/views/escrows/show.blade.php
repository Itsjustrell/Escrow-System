<h2>{{ $escrow->title }}</h2>

<p>Amount: {{ $escrow->amount }}</p>
<p>Status: {{ $escrow->status }}</p>

<hr>

{{-- BUYER ACTION --}}
@if(auth()->user()->hasRole('buyer'))

    @if($escrow->status === 'created')
        <form method="POST" action="/escrows/{{ $escrow->id }}/fund">
            @csrf
            <button>Fund Escrow</button>
        </form>
    @endif

    @if($escrow->status === 'delivered')
        <form method="POST" action="/escrows/{{ $escrow->id }}/release">
            @csrf
            <button>Release</button>
        </form>

        <form method="POST" action="/escrows/{{ $escrow->id }}/dispute">
            @csrf
            <textarea name="reason" placeholder="Dispute reason"></textarea>
            <button>Open Dispute</button>
        </form>
    @endif

@endif

{{-- SELLER ACTION --}}
@if(auth()->user()->hasRole('seller'))

    @if($escrow->status === 'funded')
        <form method="POST" action="/escrows/{{ $escrow->id }}/ship">
            @csrf
            <button>Ship</button>
        </form>
    @endif

    @if($escrow->status === 'shipping')
        <form method="POST" action="/escrows/{{ $escrow->id }}/deliver">
            @csrf
            <button>Mark Delivered</button>
        </form>
    @endif

@endif

@if($escrow->status === 'disputed')
<form method="POST" enctype="multipart/form-data"
      action="/escrows/{{ $escrow->id }}/dispute/evidence">
    @csrf
    <input type="file" name="file">
    <button>Upload Evidence</button>
</form>
@endif
