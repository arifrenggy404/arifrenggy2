<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arif Renggy - Portofolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <script>
        document.documentElement.setAttribute('data-theme', 'dark');
    </script>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <a href="{{ route('home') }}" class="logo-link" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none;">
                    <img src="/images/logo.jpg" alt="Logo" style="height: 40px; width: 40px; border-radius: 10px; border: 1px solid var(--border); object-fit: cover;">
                    <span style="font-weight: 800; font-size: 1.25rem; letter-spacing: -0.5px; background: var(--accent); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Arif Renggy</span>
                </a>
            </div>
            <nav>
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('projects.index') }}" class="{{ request()->routeIs('projects.*') ? 'active' : '' }}">Proyek</a>
            </nav>
        </header>

        <main>
            @yield('content')
        </main>

        <footer class="footer-text">
            &copy; {{ date('Y') }} Arif Renggy. Built with Laravel & Filament.
        </footer>
    </div>
</body>
</html>
