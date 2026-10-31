// Show the SPACE opening screen once per browser tab, then get out of the way.
document.addEventListener('DOMContentLoaded', () => {
    const splash = document.getElementById('space-splash');
    if (splash) {
        const closeSplash = () => {
            splash.classList.add('is-hidden');
            window.setTimeout(() => splash.remove(), 800);
        };
        let seen = false;
        try { seen = sessionStorage.getItem('space-intro-seen') === '1'; } catch (_) {}
        if (seen) {
            splash.remove();
        } else {
            try { sessionStorage.setItem('space-intro-seen', '1'); } catch (_) {}
            // Stars that keep flying out of the word SPACE.
            const burst = document.createElement('div');
            burst.className = 'splash-burst';
            const rnd = (a, b) => a + Math.random() * (b - a);
            const reach = Math.max(window.innerWidth, 600);
            for (let n = 0; n < 120; n++) {
                const star = document.createElement('i');
                star.className = n % 5 === 0 ? 'bd' : 'bs';
                const angle = rnd(0, Math.PI * 2);
                const dist = rnd(0.12, 0.5) * reach;
                const size = star.className === 'bd' ? rnd(4, 8) : (n % 6 === 0 ? rnd(34, 52) : rnd(14, 28));
                star.style.left = rnd(8, 92) + '%';
                star.style.top = rnd(22, 78) + '%';
                star.style.width = size + 'px';
                star.style.height = size + 'px';
                star.style.setProperty('--dx', (Math.cos(angle) * dist).toFixed(0) + 'px');
                star.style.setProperty('--dy', (Math.sin(angle) * dist * 0.75).toFixed(0) + 'px');
                star.style.setProperty('--r', rnd(-90, 90).toFixed(0) + 'deg');
                star.style.setProperty('--t', rnd(1.8, 3.2).toFixed(2) + 's');
                star.style.setProperty('--w', (-rnd(0, 3.2)).toFixed(2) + 's');
                burst.appendChild(star);
            }
            splash.querySelector('.splash-content').appendChild(burst);
            const timer = window.setTimeout(closeSplash, 4000);
            splash.addEventListener('click', () => { window.clearTimeout(timer); closeSplash(); });
        }
    }

    // Light / dark appearance, remembered on this device.
    let savedTheme = 'light';
    try { savedTheme = localStorage.getItem('space-theme') || 'light'; } catch (_) {}
    document.documentElement.dataset.theme = savedTheme;
    document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            const next = document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark';
            document.documentElement.dataset.theme = next;
            try { localStorage.setItem('space-theme', next); } catch (_) {}
        });
    });

    // The Schedule control follows the reference design's optional date/time field.
    const scheduleToggle = document.getElementById('schedule-toggle');
    const scheduleFields = document.getElementById('schedule-fields');
    const scheduleLocal = document.getElementById('schedule-local');
    const scheduleAt = document.getElementById('schedule-at');
    if (scheduleToggle && scheduleFields) {
        scheduleToggle.addEventListener('click', () => {
            const opening = scheduleFields.hidden;
            scheduleFields.hidden = !opening;
            scheduleToggle.setAttribute('aria-expanded', String(opening));
            if (opening && scheduleLocal) {
                const now = new Date(Date.now() - new Date().getTimezoneOffset() * 60000);
                scheduleLocal.min = now.toISOString().slice(0, 16);
            }
        });
    }
    const quoteForm = document.querySelector('#quote-dialog form');
    if (quoteForm && scheduleLocal && scheduleAt) {
        quoteForm.addEventListener('submit', () => {
            scheduleAt.value = (!scheduleFields.hidden && scheduleLocal.value) ? new Date(scheduleLocal.value).toISOString() : '';
        });
    }
});

// Sparkle sky + instant hearts.
document.addEventListener('DOMContentLoaded', () => {
    const sky = document.createElement('div');
    sky.className = 'sky';
    sky.setAttribute('aria-hidden', 'true');
    const rnd = (a, b) => a + Math.random() * (b - a);
    for (let n = 0; n < 56; n++) {
        const el = document.createElement('i');
        const star = n % 4 !== 0;
        el.className = star ? 'st' : 'dt';
        const size = star ? (n % 9 === 0 ? rnd(18, 26) : rnd(6, 12)) : rnd(3, 6);
        Object.assign(el.style, { left: rnd(0, 100) + '%', top: rnd(0, 100) + '%', width: size + 'px', height: size + 'px' });
        el.style.setProperty('--d', rnd(3, 8).toFixed(1) + 's');
        el.style.setProperty('--l', (-rnd(0, 8)).toFixed(1) + 's');
        sky.appendChild(el);
    }
    document.body.appendChild(sky);

    document.querySelectorAll('form[data-like-form]').forEach((form) => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = form.querySelector('.like-button');
            const count = btn.querySelector('span');
            if (btn.dataset.busy) return;
            btn.dataset.busy = '1';
            const liked = !btn.classList.contains('is-liked');
            btn.classList.toggle('is-liked', liked);
            count.textContent = Math.max(0, (parseInt(count.textContent, 10) || 0) + (liked ? 1 : -1));
            if (liked) { btn.classList.remove('pop'); void btn.offsetWidth; btn.classList.add('pop'); }
            try {
                const res = await fetch(form.action, { method: 'POST', body: new FormData(form), redirect: 'manual' });
                if (res.type !== 'opaqueredirect' && !res.ok) throw new Error('failed');
            } catch (_) { form.submit(); return; }
            delete btn.dataset.busy;
        });
    });
});

// Close the account menu when clicking elsewhere.
document.addEventListener('click', (e) => {
    document.querySelectorAll('details.account-menu[open]').forEach((d) => { if (!d.contains(e.target)) d.removeAttribute('open'); });
});

