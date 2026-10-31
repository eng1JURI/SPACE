@props(['page' => ''])

<header class="site-header">
    <nav class="nav-inner" aria-label="Main navigation">
        <a class="brand" href="{{ route('home') }}" aria-label="SPACE home">SPACE<span>✦</span></a>
        <div class="nav-actions">
            @auth
                <button class="theme-toggle" type="button" data-theme-toggle aria-label="Switch color theme" title="Switch color theme"><svg class="theme-sun" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42"/></svg><svg class="theme-moon" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 15.2A8.5 8.5 0 0 1 8.8 3.5 8.7 8.7 0 1 0 20.5 15.2Z"/></svg></button>
                <details class="account-menu">
                    <summary aria-label="Account menu"><span class="avatar">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span></summary>
                    <nav class="account-dropdown" aria-label="Account">
                        <a href="{{ route('profile') }}">Profile</a>
                        <a href="{{ route('my-space') }}">Your SPACE</a>
                        <a href="{{ route('likes') }}">Your Likes</a>
                        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Log out</button></form>
                    </nav>
                </details>
            @else
                <button class="theme-toggle" type="button" data-theme-toggle aria-label="Switch color theme" title="Switch color theme"><svg class="theme-sun" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42"/></svg><svg class="theme-moon" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 15.2A8.5 8.5 0 0 1 8.8 3.5 8.7 8.7 0 1 0 20.5 15.2Z"/></svg></button>
                <a class="nav-link" href="{{ route('login') }}">Log in</a>
                <a class="button button-dark button-small" href="{{ route('signup') }}">Sign up</a>
            @endauth
        </div>
    </nav>
</header>
