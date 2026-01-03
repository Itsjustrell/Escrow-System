<style>
    .modern-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 40px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .header-container {
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-logo {
        font-size: 1.3rem;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .logo-icon {
        width: 35px;
        height: 35px;
        background: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #667eea;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .header-nav {
        display: flex;
        align-items: center;
        gap: 25px;
    }

    .nav-link {
        color: white;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
        padding: 8px 16px;
        border-radius: 6px;
    }

    .nav-link:hover {
        background: rgba(255,255,255,0.15);
    }

    .btn-logout {
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
        padding: 8px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-logout:hover {
        background: rgba(255,255,255,0.3);
    }

    .mobile-menu-btn {
        display: none;
        background: none;
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
    }

    @media (max-width: 768px) {
        .modern-header {
            padding: 15px 20px;
        }

        .header-container {
            flex-wrap: wrap;
        }

        .mobile-menu-btn {
            display: block;
        }

        .header-nav {
            display: none;
            width: 100%;
            flex-direction: column;
            align-items: flex-start;
            margin-top: 15px;
            gap: 10px;
        }

        .header-nav.active {
            display: flex;
        }

        .nav-link {
            width: 100%;
        }
    }
</style>

<header class="modern-header">
    <div class="header-container">
        <div class="header-logo">
            <div class="logo-icon">E</div>
            <span>Transaction Escrow System</span>
        </div>

        <button class="mobile-menu-btn" onclick="toggleMobileMenu()">☰</button>

        <nav class="header-nav" id="headerNav">
            <a href="{{ route('home') }}" class="nav-link">Home</a>

            @auth
                <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>

                <form method="POST" action="{{ route('logout') }}" style="display:inline; margin:0;">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="nav-link">Login</a>
                <a href="{{ route('register') }}" class="nav-link">Register</a>
            @endauth
        </nav>
    </div>
</header>

<script>
    function toggleMobileMenu() {
        const nav = document.getElementById('headerNav');
        nav.classList.toggle('active');
    }
</script>