@extends('layouts.admin')

@section('admin-content')
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
      <h1>Dashboard</h1>
      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit" class="btn-sm btn-ghost">Sign out</button>
      </form>
    </div>

    @include('admin.partials.flash')

    <div class="stat-grid">
      <div class="stat"><div class="n">{{ $totalMessages }}</div><div class="l">Enquiries &amp; checkout intents</div></div>
      <div class="stat"><div class="n">{{ $unreadMessages }}</div><div class="l">Unread messages</div></div>
    </div>

    <div class="card">
      <h2>Manage site content</h2>
      <p style="color:#5A6B77;margin:0">Every section of the public page is editable from the menu on the left — section headings, steps, platform features, tutorials, packages, add-ons, values, FAQs, navigation and global settings.</p>
    </div>
  </main>
</div>
@endsection
