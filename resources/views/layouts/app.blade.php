<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="From My Stove To Yours — a culinary blog celebrating world cuisines, recipes, stories and techniques.">
    <title>From My Stove To Yours</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&family=Quicksand:wght@400;600;700&display=swap"
        rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            /* LIGHT MODE */
            --gold: #C87941; /* Vintage Terracotta */
            --gold-light: #F4E3CF; /* Vintage Cream */
            --gold-dark: #8B4513; /* Vintage Clay */
            --ink: #2D2926; /* Vintage Dark (Primary Text) */
            --parchment: #FDFAF6; /* Vintage Paper (Main BG) */
            --charcoal: #2D2926; /* Vintage Dark */
            --warm-gray: #8B4513; /* Vintage Clay */
            --card-bg: #FFFFFF;
            --border-light: rgba(200, 121, 65, 0.2);
            --input-bg: #FFFFFF;
            --footer-bg: #2D2926;
            --footer-text: #F4E3CF;
            --nav-bg: #2D2926; /* Always dark for the logo */
            --nav-border: rgba(244, 227, 207, 0.1);
        }

        [data-theme="dark"] {
            /* DARK MODE */
            --gold: #C87941;
            --gold-light: #F4E3CF;
            --gold-dark: #8B4513;
            --ink: #F4E3CF; /* Vintage Cream (Primary Text) */
            --parchment: #2D2926; /* Vintage Dark (Main BG) */
            --charcoal: #FDFAF6;
            --warm-gray: #C87941; /* Terracotta for accents */
            --card-bg: rgba(45, 41, 38, 0.4);
            --border-light: rgba(244, 227, 207, 0.1);
            --input-bg: rgba(45, 41, 38, 0.6);
            --footer-bg: #1A1715;
            --footer-text: #8B4513;
            --nav-bg: #2D2926;
            --nav-border: rgba(244, 227, 207, 0.1);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Quicksand', sans-serif;
            background-color: var(--parchment);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.05'/%3E%3C/svg%3E");
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--parchment);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gold);
            border-radius: 99px;
        }

        /* ── Navbar ── */
        .navbar {
            background: var(--nav-bg);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid var(--nav-border);
        }

        .navbar-inner {
            max-width: 1280px;
            margin: auto;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 72px;
        }

        .logo {
            font-family: 'Outfit', sans-serif;
            font-size: 1.45rem;
            font-weight: 600;
            color: var(--gold-light);
            text-decoration: none;
            letter-spacing: .03em;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .logo-icon {
            font-size: 1.6rem;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 1.8rem;
        }

        .nav-links a {
            color: #c8bfaf;
            text-decoration: none;
            font-size: .875rem;
            font-weight: 500;
            letter-spacing: .03em;
            transition: color .2s;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: var(--gold-light);
        }

        .nav-links a.active {
            border-bottom: 1px solid var(--gold);
            padding-bottom: 2px;
        }

        /* ── Buttons ── */
        .btn-gold {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-dark) 100%);
            color: var(--ink);
            font-weight: 600;
            font-size: .875rem;
            padding: .6rem 1.5rem;
            border-radius: 99px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            transition: transform .2s, box-shadow .2s, filter .2s;
            box-shadow: 0 2px 12px rgba(201, 168, 76, .3);
        }

        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(201, 168, 76, .45);
            filter: brightness(1.08);
        }

        .btn-outline {
            background: transparent;
            color: var(--warm-gray);
            border: 1.5px solid #d4c9b6;
            border-radius: 99px;
            padding: .55rem 1.3rem;
            font-size: .875rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            transition: border-color .2s, color .2s, background .2s;
        }

        .btn-outline:hover {
            border-color: var(--gold);
            color: var(--gold-dark);
            background: rgba(201, 168, 76, .06);
        }

        /* ── Main ── */
        .main {
            flex: 1;
            max-width: 1280px;
            margin: auto;
            padding: 2.5rem 2rem;
            width: 100%;
        }

        /* ── Toast ── */
        .toast {
            padding: .9rem 1.4rem;
            background: #1e3a2e;
            color: #7fc99d;
            border-left: 4px solid #3dba75;
            border-radius: .6rem;
            margin-bottom: 1.5rem;
            font-size: .9rem;
            display: flex;
            align-items: center;
            gap: .7rem;
        }

        /* ── Footer ── */
        footer {
            background: var(--footer-bg);
            border-top: 1px solid rgba(201, 168, 76, .2);
            color: var(--footer-text);
            padding: 3rem 2rem 2rem;
        }

        .footer-inner {
            max-width: 1280px;
            margin: auto;
        }

        .footer-brand {
            font-family: 'Outfit', sans-serif;
            font-size: 1.4rem;
            color: var(--gold-light);
        }

        .footer-tagline {
            font-size: .85rem;
            margin-top: .3rem;
        }

        .footer-divider {
            border-color: rgba(201, 168, 76, .15);
            margin: 1.5rem 0;
        }

        .footer-copy {
            font-size: .8rem;
            text-align: center;
        }

        /* ── Inputs ── */
        .field-label {
            display: block;
            font-size: .8rem;
            font-weight: 600;
            color: var(--warm-gray);
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: .5rem;
        }

        .field-input {
            width: 100%;
            background: var(--input-bg);
            border: 1.5px solid var(--border-light);
            border-radius: .75rem;
            padding: .75rem 1rem;
            font-family: 'Quicksand', sans-serif;
            font-size: .95rem;
            color: var(--charcoal);
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .field-input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201, 168, 76, .12);
        }

        .field-input::placeholder {
            color: #b8afa3;
        }

        .field-error {
            color: #c0392b;
            font-size: .78rem;
            margin-top: .3rem;
        }

        /* ── Card ── */
        .card {
            background: rgba(45, 41, 38, 0.4);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 3rem;
            border: 1px solid rgba(244, 227, 207, 0.2);
            overflow: hidden;
            transition: transform .25s, box-shadow .25s;
            display: flex;
            flex-direction: column;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(45, 41, 38, .1);
        }

        .card-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            display: block;
        }

        .card-body {
            padding: 1.4rem 1.6rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .card-category {
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--gold-dark);
            margin-bottom: .5rem;
        }

        .card-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1.35rem;
            font-weight: 600;
            color: var(--ink);
            line-height: 1.3;
            margin-bottom: .5rem;
        }

        .card-excerpt {
            font-size: .875rem;
            color: var(--warm-gray);
            line-height: 1.6;
            flex: 1;
        }

        .card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 1.2rem;
            padding-top: .9rem;
            border-top: 1px solid #f0e8da;
        }

        .card-meta {
            font-size: .78rem;
            color: #61584c;
            display: flex;
            align-items: center;
            gap: .35rem;
        }

        .like-btn {
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: .3rem;
            font-size: .78rem;
            color: #61584c;
            padding: .3rem .5rem;
            border-radius: .4rem;
            transition: color .2s, background .2s;
        }

        .like-btn:hover,
        .like-btn.liked {
            color: #e05a5a;
        }

        .like-btn svg {
            width: 15px;
            height: 15px;
        }

        /* ── Tags ── */
        .tag {
            display: inline-flex;
            align-items: center;
            background: #f5efe3;
            color: var(--gold-dark);
            border-radius: 99px;
            padding: .18rem .65rem;
            font-size: .72rem;
            font-weight: 500;
        }

        /* ── Misc ── */
        .divider-ornament {
            text-align: center;
            color: var(--gold);
            font-size: 1.1rem;
            letter-spacing: .5rem;
            margin: .5rem 0;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-inner">
            <a href="/" class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="From My Stove To Yours Logo"
                    style="height: 60px; width: auto; object-fit: contain; transform: scale(1.5); transform-origin: left center;">
            </a>
            <div class="nav-links">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('blogs.index') }}" class="{{ request()->routeIs('blogs.*') ? 'active' : '' }}">Blogs</a>
                
                @auth
                    <a href="{{ route('profile.edit') }}">Profile</a>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" style="background:none; border:none; color:#c8bfaf; font-size:.875rem; font-weight:500; font-family:inherit; cursor:pointer;" onmouseover="this.style.color='var(--gold-light)'" onmouseout="this.style.color='#c8bfaf'">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Log in</a>
                    <a href="{{ route('register') }}" class="btn-outline">Register</a>
                @endauth
                <button id="themeToggle"
                    style="background:none; border:none; cursor:pointer; font-size:1.2rem; color:#c8bfaf;"
                    title="Toggle Theme">
                    🌙
                </button>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main">
        @if(session('success'))
            <div class="toast">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
        {{ $slot ?? '' }}
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-inner">
            <div class="footer-brand">
                <img src="{{ asset('images/logo.png') }}" alt="From My Stove To Yours Logo"
                    style="height: 100px; width: auto; object-fit: contain; margin-bottom: 0.5rem; transform: scale(1.5);">
            </div>
            <div class="footer-tagline">A celebration of world cuisines — stories, recipes, and the joy of cooking.
            </div>
            <hr class="footer-divider">
            <div class="footer-copy">&copy; {{ date('Y') }} From My Stove To Yours. All rights reserved.</div>
        </div>
    </footer>

    <script>
        // Theme toggle logic
        const themeToggle = document.getElementById('themeToggle');
        const root = document.documentElement;

        const savedTheme = localStorage.getItem('theme') || 'light';
        if (savedTheme === 'dark') {
            root.setAttribute('data-theme', 'dark');
            themeToggle.textContent = '☀️';
        }

        themeToggle.addEventListener('click', () => {
            const currentTheme = root.getAttribute('data-theme');
            if (currentTheme === 'dark') {
                root.removeAttribute('data-theme');
                localStorage.setItem('theme', 'light');
                themeToggle.textContent = '🌙';
            } else {
                root.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
                themeToggle.textContent = '☀️';
            }
        });

        // Global CSRF setup for fetch
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
</body>

</html>
