<x-admin-shell title="Sign in" bare>
  <div class="login-bg">
    <div class="login-card">
      <div class="login-logo">
        <img src="{{ asset('images/balancepoint-logo.png') }}" alt="Next Chapter" width="180">
      </div>
      <h1>Welcome back</h1>
      <p class="sub">Sign in to manage your site content.</p>

      @if(session('status'))<div class="alert ok">{{ session('status') }}</div>@endif

      <form method="POST" action="{{ route('admin.login.attempt') }}">
        @csrf
        <div class="field">
          <label for="email">Email address</label>
          <input id="email" type="email" name="email" placeholder="admin@nextchapter.uk" value="{{ old('email') }}" required autofocus>
          @error('email')<span class="hint" style="color:#B3402D">{{ $message }}</span>@enderror
        </div>
        <div class="field">
          <label for="password">Password</label>
          <div class="pw-wrap">
            <input id="password" type="password" name="password" placeholder="Enter your password" required autocomplete="current-password">
            <button type="button" class="pw-toggle" data-toggle-password="password"
                    aria-label="Show password" aria-pressed="false">
              <x-ad-icon name="eye" class="i-eye"/>
              <x-ad-icon name="eye-off" class="i-eyeoff" style="display:none"/>
            </button>
          </div>
          @error('password')<span class="hint" style="color:#B3402D">{{ $message }}</span>@enderror
        </div>
        <div class="check-row">
          <input id="remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
          <label for="remember">Remember me</label>
        </div>
        <button type="submit" class="btn btn-primary login-btn"><x-ad-icon name="login"/>Sign in</button>
      </form>
    </div>
    <p class="login-foot">&copy; {{ date('Y') }} Next Chapter. All rights reserved.</p>
  </div>

  <script>
    document.querySelectorAll('[data-toggle-password]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var input = document.getElementById(btn.dataset.togglePassword);
        if (!input) return;
        var show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        btn.setAttribute('aria-pressed', String(show));
        btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
        var eye = btn.querySelector('.i-eye');
        var eyeOff = btn.querySelector('.i-eyeoff');
        if (eye) { eye.style.display = show ? 'none' : ''; }
        if (eyeOff) { eyeOff.style.display = show ? '' : 'none'; }
      });
    });
  </script>
</x-admin-shell>
