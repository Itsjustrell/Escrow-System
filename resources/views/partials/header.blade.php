<header style="background:#222; color:#fff; padding:15px 40px;">
    <strong>Transaction Escrow System</strong>

    <nav style="float:right;">
        <a href="{{ route('home') }}" style="color:#fff; margin-right:15px;">Home</a>

        @auth
            <a href="{{ route('dashboard') }}" style="color:#fff; margin-right:15px;">
                Dashboard
            </a>

            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button style="background:none;border:none;color:#fff;cursor:pointer;">
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" style="color:#fff; margin-right:15px;">Login</a>
            <a href="{{ route('register') }}" style="color:#fff;">Register</a>
        @endauth
    </nav>

    <div style="clear:both;"></div>
</header>
