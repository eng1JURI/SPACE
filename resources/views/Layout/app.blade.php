<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#e9eee5">
    <title>@yield('title', 'SPACE — a little place for words')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <script>
        try {
            document.documentElement.dataset.theme = localStorage.getItem('space-theme') || 'light';
            if (sessionStorage.getItem('space-intro-seen') === '1') document.documentElement.classList.add('no-splash');
        } catch (e) {}
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="space-splash" id="space-splash" aria-hidden="true">
        <div class="splash-content">
            <div class="splash-wordmark">SPACE</div>
        </div>
    </div>
    <x-navbar :page="$page ?? ''" />
    <main class="page-shell">
        @yield('content')
    </main>
    <x-footer />
</body>
</html>
