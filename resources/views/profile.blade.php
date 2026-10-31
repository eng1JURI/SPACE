@extends('Layout.app')

@section('title', $user->name . ' — SPACE')
@section('content')
<section class="profile-wrap">
    @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <div class="glass-card profile-card">
        <div class="profile-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</div>
        <p class="eyebrow">Joined {{ $user->created_at->format('F Y') }}</p>
        <h1>{{ $user->name }}</h1>
        @if ($user->bio || $isMe)
            <p class="profile-bio">{{ $user->bio ?: 'Add a few words about you.' }}</p>
        @endif
        <div class="profile-stats">
            <div><strong>{{ $stats['spaces'] }}</strong><span>Spaces</span></div>
            <div><strong>{{ $stats['received'] }}</strong><span>Likes received</span></div>
            <div><strong>{{ $stats['given'] }}</strong><span>Likes given</span></div>
        </div>

        @if ($isMe)
            <details class="edit-profile" @if ($errors->any()) open @endif>
                <summary class="button button-soft">Edit profile</summary>
                <form method="POST" action="{{ route('profile.update') }}" class="form-stack">
                    @csrf @method('PUT')
                    @if ($errors->any())
                        <div class="alert alert-error"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                    @endif
                    <label for="name">Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" minlength="2" maxlength="50" required>
                    <label for="bio">Bio</label>
                    <input id="bio" name="bio" type="text" value="{{ old('bio', $user->bio) }}" maxlength="120" placeholder="A few words about you">
                    <button class="button button-dark button-full" type="submit">Save</button>
                </form>
            </details>
        @endif
    </div>

    @if ($isMe)
        <div class="profile-tabs" role="tablist">
            <a class="tab {{ $tab === 'spaces' ? 'on' : '' }}" href="{{ route('profile') }}">My Spaces</a>
            <a class="tab {{ $tab === 'liked' ? 'on' : '' }}" href="{{ route('profile', ['tab' => 'liked']) }}">Liked</a>
            <a class="tab {{ $tab === 'scheduled' ? 'on' : '' }}" href="{{ route('profile', ['tab' => 'scheduled']) }}">Scheduled</a>
        </div>
    @endif

    @if ($quotes->isEmpty())
        <div class="empty-state glass-card"><span>✧</span><h3>It's quiet out here.</h3><p class="muted">Nothing here yet.</p></div>
    @else
        <div class="quote-grid">
            @foreach ($quotes as $quote)
                <article class="quote-card {{ $quote->user_id === auth()->id() ? 'quote-own' : '' }}">
                    <span class="quote-mark">“</span>
                    <p class="quote-content">{{ $quote->content }}</p>
                    @if ($tab === 'scheduled')
                        <span class="badge-scheduled">✦ Scheduled · {{ $quote->scheduled_at->format('M d, g:i A') }}</span>
                    @endif
                    <div class="quote-footer">
                        <div class="quote-byline">
                            <a class="quote-author" href="{{ route('profile.show', $quote->user) }}">{{ $quote->user->name }}</a>
                            <span class="quote-date">{{ $quote->created_at->format('M d, Y') }}</span>
                        </div>
                        <span class="like-count">♡ {{ $quote->liked_by_count }}</span>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</section>
@endsection
