@props(['title' => 'Admin', 'bare' => false])
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
  @unless($bare)
  <aside class="ad-side">
    <div class="ad-brand">
      <div class="t">Next Chapter</div>
      <div class="s">Content admin</div>
    </div>
    @include('admin.partials.nav')
  </aside>
  @endunless
  <main class="ad-main">
    @unless($bare)
    <div class="ad-topbar">
      <h1>{{ $title }}</h1>
      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit" class="btn-sm btn-ghost"><x-ad-icon name="logout"/>Sign out</button>
      </form>
    </div>
    @endunless
    @include('admin.partials.flash')
    {{ $slot }}
  </main>
</div>
<script src="{{ asset('vendor/trix/trix.umd.min.js') }}"></script>
<script>if (window.Trix) { Trix.config.blockAttributes.default.tagName = 'p'; }</script>
<script>
  (function () {
    function humanSize(bytes) {
      if (bytes >= 1048576) return (bytes / 1048576).toFixed(1) + ' MB';
      if (bytes >= 1024) return (bytes / 1024).toFixed(0) + ' KB';
      return bytes + ' B';
    }
    function showFile(zone, input, file) {
      var box = zone.querySelector('.dz-file');
      var isImage = file.type.indexOf('image/') === 0;
      var isVideo = file.type.indexOf('video/') === 0;
      var media = '';
      if (isImage) {
        media = '<img src="' + URL.createObjectURL(file) + '" alt="">';
      } else if (isVideo) {
        media = '<video src="' + URL.createObjectURL(file) + '" muted preload="metadata"></video>';
      }
      box.innerHTML = media +
        '<span class="n"><span class="fname">' + file.name + '</span><span class="fsize">' + humanSize(file.size) + '</span></span>' +
        '<button type="button" class="dz-clear" aria-label="Remove selected file">Remove</button>';
      box.hidden = false;
      zone.classList.add('dz-has');
    }
    function clearFile(zone, input) {
      input.value = '';
      var box = zone.querySelector('.dz-file');
      box.innerHTML = '';
      box.hidden = true;
      zone.classList.remove('dz-has');
      input.dispatchEvent(new Event('change', { bubbles: true }));
    }
    document.querySelectorAll('.dropzone').forEach(function (zone) {
      var input = zone.querySelector('.dz-input');
      if (!input) return;
      input.addEventListener('click', function (e) { e.stopPropagation(); });
      function open() { input.click(); }
      zone.addEventListener('click', open);
      zone.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); open(); }
      });
      ['dragenter', 'dragover'].forEach(function (ev) {
        zone.addEventListener(ev, function (e) {
          e.preventDefault();
          zone.classList.add('dz-over');
        });
      });
      ['dragleave', 'drop'].forEach(function (ev) {
        zone.addEventListener(ev, function () { zone.classList.remove('dz-over'); });
      });
      zone.addEventListener('drop', function (e) {
        e.preventDefault();
        if (!e.dataTransfer || !e.dataTransfer.files || !e.dataTransfer.files.length) return;
        input.files = e.dataTransfer.files;
        showFile(zone, input, e.dataTransfer.files[0]);
        input.dispatchEvent(new Event('change', { bubbles: true }));
      });
      input.addEventListener('change', function () {
        var file = input.files && input.files[0];
        if (file) { showFile(zone, input, file); }
        else { clearFile(zone, input); }
      });
      zone.addEventListener('click', function (e) {
        var btn = e.target.closest('.dz-clear');
        if (btn) { e.stopPropagation(); clearFile(zone, input); }
      });
    });
  })();
</script>
</body>
</html>
