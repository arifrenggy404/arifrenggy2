<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arif Renggy - Portofolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <script>
        // Inline script to prevent flash of light theme
        const savedTheme = localStorage.getItem('theme') || 'dark';
        document.documentElement.setAttribute('data-theme', savedTheme);
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
                <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Kontak</a>
                <button class="theme-toggle-btn" id="themeToggle" aria-label="Toggle Theme">
                    <span id="themeToggleIcon">🌙</span>
                </button>
            </nav>
        </header>

        <main>
            @yield('content')
        </main>

        <footer class="footer-text">
            &copy; {{ date('Y') }} Arif Renggy. Built with Laravel & Filament.
        </footer>
    </div>

    <script>
        const btn = document.getElementById('themeToggle');
        const icon = document.getElementById('themeToggleIcon');
        
        function updateToggleIcon(theme) {
            if (theme === 'dark') {
                icon.textContent = '🌙';
            } else {
                icon.textContent = '☀️';
            }
        }

        // Initialize icon
        const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
        updateToggleIcon(currentTheme);

        btn.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const targetTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', targetTheme);
            localStorage.setItem('theme', targetTheme);
            updateToggleIcon(targetTheme);
        });
    </script>
</body>
</html>
