@props(['title' => 'Admin'])
<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title }} · Next Chapter Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com/">
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500;600;700&family=Hanken+Grotesk:wght@400;500;600;700&family=Spline+Sans+Mono:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/trix/trix.css') }}">
</head>
<body class="admin">
<div class="ad-shell">
  <aside class="ad-side">
    <div class="ad-brand">
      <div class="t">Next Chapter</div>
      <div class="s">Content admin</div>
    </div>
    @include('admin.partials.nav')
  </aside>
  <main class="ad-main">
    <div class="ad-topbar">
      <h1>{{ $title }}</h1>
      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit" class="btn-sm btn-ghost">Sign out</button>
      </form>
    </div>
    @include('admin.partials.flash')
    {{ $slot }}
  </main>
</div>
<script src="{{ asset('vendor/trix/trix.umd.min.js') }}"></script>
<script>if (window.Trix) { Trix.config.blockAttributes.default.tagName = 'p'; }</script>
</body>
</html>
