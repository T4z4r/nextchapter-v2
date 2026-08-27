<!DOCTYPE html>
<html lang="en-GB">
<head>
<meta charset="UTF-8">
<meta name="theme-color" content="#459EDF">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', $settings->site_name . ': Financial clarity for separation and divorce')</title>
<meta name="description" content="{{ $settings->meta_description }}">
<link rel="icon" type="image/png" href="{{ asset($settings->logoAssetPath()) }}">
<link rel="preconnect" href="https://fonts.googleapis.com/">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
<link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Hanken+Grotesk:wght@400;500;600;700&family=Spline+Sans+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/site.css') }}">
<link rel="stylesheet" href="{{ asset('css/extra.css') }}">
@if($brandCss = $settings->palette())
<style>{{ $brandCss }}</style>
@endif
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body data-checkout-url="{{ route('checkout.intent') }}">

<!-- ============ HEADER ============ -->
<header id="top" class="scrolled">
  <div class="wrap nav">
    <a href="{{ route('home') }}#top" class="brand" aria-label="{{ $settings->site_name }} home">
      @if($settings->logo_path)
        <img class="brand-logo" src="{{ asset($settings->logoAssetPath()) }}" alt="{{ $settings->site_name }}">
      @else
        <span style="font-family:'Exo 2';font-weight:700">{{ $settings->site_name }}</span>
      @endif
    </a>
    <nav class="nav-links" id="navlinks">
      @foreach(($header?->data('links') ?? []) as $link)
        <a href="{{ str_starts_with($link['url'], '/') || str_starts_with($link['url'], 'http') ? $link['url'] : route('home') . $link['url'] }}">{{ $link['label'] }}</a>
      @endforeach
    </nav>
    <div class="nav-cta">
      @if($header?->cta1_label)
        <a href="{{ $header->cta1_url ?: '#pricing' }}" class="btn btn-primary">{{ $header->cta1_label }}</a>
      @endif
      <button class="menu-btn" id="menuBtn" aria-label="Menu" aria-expanded="false">
        <svg viewBox="0 0 24 24" fill="none" stroke="{{ $settings->color_ink ?: '#17242E' }}" stroke-width="2"><path d="M4 7h16M4 12h16M4 17h16" stroke-linecap="round"/></svg>
      </button>
    </div>
  </div>
</header>

@yield('content')

<!-- ============ FOOTER ============ -->
<footer>
  <div class="wrap">
    @if($settings->footer_logo_path)
      <img class="foot-logo" src="{{ asset($settings->footer_logo_path) }}" alt="{{ $settings->site_name }}">
    @endif
    <div class="foot-grid">
      <div class="foot-brand">
        <p>{!! $settings->footer_blurb !!}</p>
      </div>
      @foreach(($footer?->data('columns') ?? []) as $column)
        <div>
          <h5>{{ $column['title'] }}</h5>
          <ul>
            @foreach($column['links'] as $link)
              <li><a href="{{ str_starts_with($link['url'], 'http') || str_starts_with($link['url'], '/') ? $link['url'] : route('home') . $link['url'] }}">{{ $link['label'] }}</a></li>
            @endforeach
          </ul>
        </div>
      @endforeach
    </div>
    <div class="foot-bottom">
      <span>&copy; <span id="yr">{{ date('Y') }}</span> {{ $settings->copyright_holder }}. All rights reserved. &nbsp;&middot;&nbsp; <a href="{{ route('legal') }}" style="color:#fff">Legal &amp; Policies</a></span>
      <span>{{ $settings->legal_footnote }}</span>
    </div>
  </div>
</footer>

<script src="{{ asset('js/site.js') }}"></script>
</body>
</html>
