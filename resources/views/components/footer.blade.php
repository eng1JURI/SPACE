@php
    // Put your own profile links here:
    $linkedin = 'https://www.linkedin.com/in/juri-albeshri-219676420';
    $twitter = 'https://x.com/eng1juri?s=11';
@endphp

<footer class="site-footer">
    <div class="footer-inner">
        <span class="footer-brand">SPACE<span>✦</span> <small>a little place for words</small></span>
        <div class="footer-links">
            <span class="footer-contact">Contact us at</span>
            <a href="{{ $linkedin }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4.98 3.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3 9.75h4V21H3V9.75ZM9.5 9.75h3.8v1.6h.05c.55-1 1.9-1.95 3.9-1.95 4.1 0 4.75 2.6 4.75 6V21h-4v-4.9c0-1.2 0-2.7-1.7-2.7s-1.9 1.3-1.9 2.6V21h-4V9.75Z"/></svg>
                <span>LinkedIn</span>
            </a>
            <a href="{{ $twitter }}" target="_blank" rel="noopener noreferrer" aria-label="twitter">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231Zm-1.161 17.52h1.833L7.084 4.126H5.117Z"/></svg>
                <span>X</span>
            </a>
        </div>
    </div>
</footer>
