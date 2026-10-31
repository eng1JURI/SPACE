@extends('Layout.app')

@section('title', 'SPACE — a little place for your words')
@section('content')
@php
    $editingId = request()->filled('edit') ? (int) request('edit') : null;
    $sectionTitle = $sectionTitle ?? 'Explore SPACE';
@endphp

<section class="hero">
    <div class="hero-stars" aria-hidden="true">✦　　✧　　 ✦　　·　　✧</div>
    <p class="eyebrow">A quiet corner of the universe</p>
    <h1>Make SPACE for<br><em>what moves you.</em></h1>
    <p class="hero-copy">SPACE is a calm little corner of the internet where words get room to glow. Write a thought, keep what moves you, or schedule a line for the day it's needed.</p>
    @guest
        <div class="hero-actions">
            <a href="{{ route('signup') }}" class="button button-dark">Find your SPACE <span>↗</span></a>
            <a href="{{ route('login') }}" class="button button-glass">I have an account</a>
        </div>
    @else
        <button type="button" class="button button-dark" onclick="document.getElementById('quote-dialog').showModal()">＋ Add a SPACE!</button>
    @endguest
    <div class="hero-orbit" aria-hidden="true"><span></span></div>
</section>

<section class="quotes-section" id="quotes">
    <div class="section-heading">
        <div><p class="eyebrow">Collected thoughts</p><h2>{{ $sectionTitle }}</h2></div>
        <p class="muted">{{ $quotes->count() }} {{ \Illuminate\Support\Str::plural('thought', $quotes->count()) }}</p>
    </div>

    @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if ($errors->any()) <div class="alert alert-error"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div> @endif

    @if ($quotes->isEmpty())
        <div class="empty-state glass-card"><span>✧</span><h3>It's quiet out here.</h3><p class="muted">Be the first to leave a SPACE in this little universe.</p></div>
    @else
        <div class="quote-grid">
            @foreach ($quotes as $quote)
                @php
                    $isMine = auth()->check() && $quote->user_id === auth()->id();
                    $isLiked = in_array($quote->id, $likedQuoteIds ?? []);
                @endphp
                <article class="quote-card {{ $isMine ? 'quote-own' : '' }}">
                    <span class="quote-mark">“</span>
                    @if ($isMine && ($canEdit ?? false) && $quote->id === $editingId)
                        <form method="POST" action="{{ route('quotes.update', $quote) }}" class="edit-form">
                            @csrf @method('PUT')
                            <textarea name="content" minlength="3" maxlength="155" required>{{ old('content', $quote->content) }}</textarea>
                            <div class="edit-actions"><button class="button button-dark button-small">Save</button><a class="text-link" href="{{ url()->current() }}">Cancel</a></div>
                        </form>
                    @else
                        <p class="quote-content">{{ $quote->content }}</p>
                        @if ($isMine && $quote->scheduled_at && $quote->scheduled_at->isFuture())
                            <span class="badge-scheduled">✦ Scheduled · {{ $quote->scheduled_at->format('M d, g:i A') }}</span>
                        @endif
                        <div class="quote-footer">
                            <div class="quote-byline"><span class="quote-author"><svg class="author-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="3.5"/><path d="M4.8 20c.6-3.7 3.2-5.7 7.2-5.7s6.6 2 7.2 5.7"/></svg><a href="{{ route('profile.show', $quote->user) }}">{{ $quote->user->name }}</a></span><span class="quote-date">{{ $quote->created_at->format('M d, Y') }}</span></div>
                            <div class="quote-actions">
                                @auth
                                    @if (!$isMine)
                                        <form method="POST" action="{{ route('quotes.like', $quote) }}" data-like-form>@csrf
                                            <button class="like-button {{ $isLiked ? 'is-liked' : '' }}" type="submit" aria-label="{{ $isLiked ? 'Unlike quote' : 'Like quote' }}" title="{{ $isLiked ? 'Unlike' : 'Like' }}">
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21.2c-.3 0-.6-.1-.8-.3C6.4 17 3 13.9 3 9.9 3 7.2 5.1 5 7.7 5c1.7 0 3.3.9 4.3 2.3C13 5.9 14.6 5 16.3 5 18.9 5 21 7.2 21 9.9c0 4-3.4 7.1-8.2 11-.2.2-.5.3-.8.3Z"/></svg>
                                                <span>{{ $quote->liked_by_count }}</span>
                                            </button>
                                        </form>
                                    @else
                                        <span class="like-count" title="Likes"> ♡ {{ $quote->liked_by_count }}</span>
                                    @endif
                                @endauth
                                @if ($isMine)
                                    @if ($canEdit ?? false)
                                        <a class="icon-link" href="{{ route('my-space', ['edit' => $quote->id]) }}" aria-label="Edit quote" title="Edit">✎</a>
                                    @endif
                                    <form method="POST" action="{{ route('quotes.destroy', $quote) }}" onsubmit="return confirm('Delete this quote?')">
                                        @csrf @method('DELETE')<button class="icon-link" aria-label="Delete quote" title="Delete">⌫</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endif
                </article>
            @endforeach
        </div>
    @endif
</section>

@auth
<dialog id="quote-dialog" class="quote-dialog">
    <form method="POST" action="{{ route('quotes.store') }}" class="dialog-inner">
        @csrf
        <div class="dialog-heading"><div><p class="eyebrow">Leave a little light</p><h2>Share a thought</h2></div><button type="button" class="close-dialog" onclick="document.getElementById('quote-dialog').close()" aria-label="Close">×</button></div>
        <label for="quote-content">Your quote</label>
        <textarea id="quote-content" name="content" minlength="3" maxlength="155" required placeholder="Write something worth keeping..." oninput="document.getElementById('char-count').textContent = this.value.length + ' / 155'">{{ old('content') }}</textarea>
        <div class="schedule-row"><button type="button" id="schedule-toggle" class="schedule-toggle" aria-expanded="false" aria-controls="schedule-fields">◷ Schedule</button></div>
        <div id="schedule-fields" class="schedule-fields" hidden>
            <label for="schedule-local">Share it on</label>
            <input id="schedule-local" type="datetime-local">
            <input id="schedule-at" name="scheduled_at" type="hidden">
            <small>It stays hidden until then. Find it anytime in Your SPACE.</small>
        </div>
        <div class="dialog-bottom"><small id="char-count">0 / 155</small><button class="button button-dark">Share with SPACE ↗</button></div>
    </form>
</dialog>
@endauth
@endsection
