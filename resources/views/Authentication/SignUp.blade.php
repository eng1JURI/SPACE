@extends('Layout.app')

@section('title', 'Join SPACE')
@section('content')
<section class="auth-wrap">
    <div class="auth-card glass-card">
        <p class="eyebrow">A little corner of the universe</p>
        <h1>Find your SPACE.</h1>
        <p class="muted">Create an account and start collecting words that stay with you.</p>

        @if ($errors->any())
            <div class="alert alert-error"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <form method="POST" action="{{ route('signup.store') }}" class="form-stack">
            @csrf
            <label for="name">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" minlength="2" maxlength="50" required autocomplete="name" placeholder="Your name">
            <small>2–50 characters. Letters and spaces only.</small>

            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" placeholder="you@example.com">

            <label for="password">Password</label>
            <input id="password" name="password" type="password" minlength="8" required autocomplete="new-password" placeholder="At least 8 characters">
            <small>Use at least 8 characters.</small>

            <button class="button button-dark button-full" type="submit">Create my SPACE <span>↗</span></button>
        </form>
        <p class="auth-switch">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
    </div>
</section>
@endsection
