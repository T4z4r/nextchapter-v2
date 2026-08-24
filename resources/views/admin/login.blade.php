@extends('layouts.admin')

@section('title', 'Sign in')

@section('admin-content')
<div class="login-wrap">
  <div class="login-card">
    <h1>Next Chapter admin</h1>
    <p class="sub">Sign in with an administrator account.</p>

    @if(session('status'))<div class="alert ok">{{ session('status') }}</div>@endif

    <form method="POST" action="{{ route('admin.login.attempt') }}">
      @csrf
      <div class="field">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
        @error('email')<span class="hint" style="color:#B3402D">{{ $message }}</span>@enderror
      </div>
      <div class="field">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
        @error('password')<span class="hint" style="color:#B3402D">{{ $message }}</span>@enderror
      </div>
      <div class="check-row">
        <input id="remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
        <label for="remember">Remember me</label>
      </div>
      <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">Sign in</button>
    </form>
  </div>
</div>
@endsection
