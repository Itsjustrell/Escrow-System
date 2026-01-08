<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        --glass-bg: rgba(255, 255, 255, 0.85);
        --glass-border: 1px solid rgba(255, 255, 255, 0.3);
        --glass-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        --text-main: #1e293b;
        --text-muted: #64748b;
    }

    .glass-header {
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-bottom: var(--glass-border);
        box-shadow: var(--glass-shadow);
        position: sticky;
        top: 0;
        z-index: 1000;
        padding: 15px 0;
        transition: all 0.3s ease;
    }

    .header-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logo-area {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
    }

    .logo-icon {
        width: 40px;
        height: 40px;
        background: var(--primary-gradient);
        border-radius: 12px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1.2rem;
        box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3);
    }

    .logo-text {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-main);
        letter-spacing: -0.5px;
    }

    .nav-menu {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .nav-item {
        color: var(--text-muted);
        text-decoration: none;
        padding: 8px 16px;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.95rem;
        transition: all 0.2s;
    }

    .nav-item:hover {
        color: var(--text-main);
        background: rgba(0,0,0,0.05);
    }

    .nav-item.active {
        color: #6366f1;
        background: rgba(99, 102, 241, 0.1);
        font-weight: 600;
    }

    .btn-cta {
        background: var(--primary-gradient);
        color: white;
        padding: 10px 24px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        transition: transform 0.2s, box-shadow 0.2s;
        border: none;
        cursor: pointer;
    }

    .btn-cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
    }
    
    .mobile-toggle {
        display: none;
        font-size: 1.5rem;
        background: none;
        border: none;
        color: var(--text-main);
        cursor: pointer;
    }

    @media (max-width: 768px) {
        .mobile-toggle {
            display: block;
        }

        .nav-menu {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: white;
            flex-direction: column;
            padding: 20px;
            gap: 15px;
            border-bottom: 1px solid #eee;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transform: translateY(-20px);
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-menu.is-open {
            transform: translateY(0);
            opacity: 1;
            pointer-events: all;
        }

        .nav-item {
            width: 100%;
            text-align: center;
        }

        .btn-cta {
            width: 100%;
            text-align: center;
        }
    }
</style>

<header class="glass-header">
    <div class="header-container">
        <a href="{{ route('home') }}" class="logo-area">
            <div class="logo-icon">E</div>
            <span class="logo-text">EscrowSecure</span>
        </a>

        <button class="mobile-toggle" onclick="toggleMenu()">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 12h18M3 6h18M3 18h18" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        <nav class="nav-menu" id="mainNav">
            <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            
            @auth


                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                
                <form method="POST" action="{{ route('logout') }}" style="margin: 0; width: 100%;">
                    @csrf
                    <button type="submit" class="btn-cta" style="width: auto; min-width: 100px;">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="nav-item">Log In</a>
                <a href="{{ route('register') }}" class="btn-cta">Get Started</a>
            @endauth
        </nav>
    </div>
</header>

<script>
    function toggleMenu() {
        const nav = document.getElementById('mainNav');
        nav.classList.toggle('is-open');
    }
</script>