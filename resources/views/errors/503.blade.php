<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPACE — Back soon</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        html { background: #a9ab82; }
        html[data-theme="dark"] { background: #1b241a; }
        html, body { min-height: 100%; margin: 0; }
        body { min-height: 100vh; min-height: 100dvh; display: grid; place-items: center; overflow: hidden; text-align: center; color: #263b20; font-family: 'DM Sans', sans-serif; background: none; }
        body::before { content: ''; position: fixed; inset: 0; z-index: -1; pointer-events: none; background:
            radial-gradient(ellipse 34% 60% at 36% 56%, rgba(70,106,58,.85), transparent 72%),
            radial-gradient(ellipse 46% 42% at 76% 6%, rgba(214,230,190,.95), rgba(214,230,190,0) 70%),
            radial-gradient(ellipse 50% 70% at 96% 52%, rgba(120,142,98,.7), transparent 70%),
            radial-gradient(ellipse 30% 40% at 6% 100%, rgba(88,122,70,.5), transparent 70%),
            radial-gradient(ellipse 30% 40% at 14% 62%, rgba(176,200,140,.5), transparent 70%),
            linear-gradient(120deg, #aaae80, #9aa77a 55%, #a3ad84); }
        body::after { content: ''; position: fixed; inset: 0; z-index: -1; pointer-events: none; opacity: .22; mix-blend-mode: overlay;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='160' height='160'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.8' numOctaves='2' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.6'/%3E%3C/svg%3E"); }
        .sky { position: fixed; inset: 0; z-index: -1; pointer-events: none; overflow: hidden; }
        .sky i { position: absolute; display: block; animation: twinkle var(--d, 5s) ease-in-out var(--l, 0s) infinite; }
        .sky .st { background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23fffbe2' d='M12 0l1.4 10.6L24 12l-10.6 1.4L12 24l-1.4-10.6L0 12l10.6-1.4z'/%3E%3C/svg%3E") center/contain no-repeat; filter: drop-shadow(0 0 4px rgba(255,252,220,.9)); }
        .sky .dt { border-radius: 50%; background: #f6dc6e; box-shadow: 0 0 8px 2px rgba(246,220,110,.55); }
        @keyframes twinkle { 0%, 100% { opacity: .3; transform: scale(.8); } 50% { opacity: 1; transform: scale(1.1); } }
        main { padding: 24px; }
        .brand { padding-left: .16em; font: 700 clamp(64px, 15vw, 160px)/1 'Playfair Display', serif; letter-spacing: .16em; color: #30432a; }
        .brand span { margin-left: 8px; color: #71845d; font: clamp(24px, 4vw, 48px) 'DM Sans', sans-serif; vertical-align: top; }
        h1 { margin: 22px 0 0; font: 500 clamp(32px, 6vw, 64px)/1.08 'Playfair Display', serif; letter-spacing: .08em; color: #2c4424; }
        p { max-width: 380px; margin: 22px auto 0; font-size: clamp(14px, 2vw, 16px); line-height: 1.8; color: #3a5030; }
        html[data-theme="dark"] body::before { background: radial-gradient(ellipse 34% 60% at 36% 56%, rgba(60,96,52,.7), transparent 72%), radial-gradient(ellipse 40% 35% at 76% 6%, rgba(120,140,96,.35), transparent 70%), linear-gradient(145deg, #1b241a, #26331f 55%, #1c271b); }
        html[data-theme="dark"] .brand, html[data-theme="dark"] h1 { color: #e5ebd8; }
        html[data-theme="dark"] .brand span { color: #a8bb91; }
        html[data-theme="dark"] p { color: #b8c6a8; }
        html[data-theme="dark"] .sky { opacity: .6; }
        @media (prefers-reduced-motion: reduce) { .sky i { animation: none; } }
    </style>
</head>
<body>
    <main>
        <div class="brand">SPACE<span>✦</span></div>
        <h1>BACK SOON</h1>
        <p>We are currently making some improvements to our website!</p>
    </main>
    <script>
        // Same light / dark choice as the site (saved on this device).
        try { document.documentElement.dataset.theme = localStorage.getItem('space-theme') || 'light'; } catch (_) {}
        const sky = document.createElement('div'); sky.className = 'sky'; sky.setAttribute('aria-hidden', 'true');
        const r = (a, b) => a + Math.random() * (b - a);
        for (let n = 0; n < 56; n++) {
            const el = document.createElement('i'), star = n % 4 !== 0;
            el.className = star ? 'st' : 'dt';
            const s = star ? (n % 9 === 0 ? r(18, 26) : r(6, 12)) : r(3, 6);
            Object.assign(el.style, { left: r(0, 100) + '%', top: r(0, 100) + '%', width: s + 'px', height: s + 'px' });
            el.style.setProperty('--d', r(3, 8).toFixed(1) + 's');
            el.style.setProperty('--l', (-r(0, 8)).toFixed(1) + 's');
            sky.appendChild(el);
        }
        document.body.appendChild(sky);
    </script>
</body>
</html>
