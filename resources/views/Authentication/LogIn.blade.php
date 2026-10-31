@extends('Layout.app')

@section('title', 'Log in to SPACE')
@section('content')
<section class="auth-wrap">
    <div class="auth-card glass-card">
        <p class="eyebrow">Welcome back</p>
        <h1>Your SPACE missed you.</h1>
        <p class="muted">Log in to revisit your favorite words.</p>

        @if ($errors->any())
            <div class="alert alert-error"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <form method="POST" action="{{ route('login.store') }}" class="form-stack">
            @csrf
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" placeholder="you@example.com">

            <label for="password">Password</label>
            <input id="password" name="password" type="password" minlength="8" required autocomplete="current-password" placeholder="Your password">

            <button class="button button-dark button-full" type="submit">Log in <span>↗</span></button>
        </form>
        <p class="auth-switch">New to SPACE? <a href="{{ route('signup') }}">Create an account</a></p>
    </div>
</section>
@endsection
