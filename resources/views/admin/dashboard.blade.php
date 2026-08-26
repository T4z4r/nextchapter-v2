<x-admin-shell title="Dashboard">
  <div class="card dash-intro">
    <h2 style="margin:0 0 6px">Welcome back</h2>
    <p style="color:#5A6B77;margin:0">
      This panel controls every part of the public site — the copy in each section, how-it-works
      steps, platform features, tutorials with video uploads, pricing packages and add-ons, FAQs,
      brand logos &amp; colors, and global settings. Anything you change here appears on the site
      immediately. Recent changes are tracked below so you can see what happened and when.
    </p>
  </div>

  <div class="stat-grid">
    <div class="stat"><div class="n">{{ $totalMessages }}</div><div class="l">Enquiries &amp; checkout intents</div><div class="s">{{ $enquiries }} enquiries · {{ $intents }} intents</div></div>
    <div class="stat{{ $unreadMessages ? ' stat-alert' : '' }}"><div class="n">{{ $unreadMessages }}</div><div class="l">Unread messages</div><div class="s">waiting for a reply</div></div>
    <div class="stat"><div class="n">{{ $tutorials }}</div><div class="l">Tutorials published</div><div class="s">{{ $lockedTutorials }} locked · {{ $tutorials - $lockedTutorials }} free</div></div>
    <div class="stat"><div class="n">{{ $plans }}</div><div class="l">Live packages</div><div class="s">{{ $addons }} active add-ons</div></div>
    <div class="stat"><div class="n">{{ $faqs }}</div><div class="l">FAQs online</div><div class="s">shown on the public page</div></div>
  </div>

  <div class="dash-cols">
    <div class="card">
      <h2>Recent activity</h2>
      @if($recent->isEmpty())
        <p class="hint">No activity recorded yet. Changes you make across the admin will appear here.</p>
      @else
        <ul class="activity-feed">
          @foreach($recent as $log)
            <li>
              <span class="badge b-{{ $log->verbGroup() }}">{{ $log->verbGroup() }}</span>
              <span class="a-body">
                <span class="a-desc">{{ $log->description }}</span>
                <span class="a-meta">
                  {{ $log->user?->email ?? 'system' }}
                  &middot; {{ $log->ago() }}
                  @if($log->ip) &middot; {{ $log->ip }} @endif
                </span>
              </span>
            </li>
          @endforeach
        </ul>
        <p class="hint" style="margin-top:10px">Tracker covers content edits, settings changes, enquiries, checkout intents and admin sign-ins.</p>
      @endif
    </div>

    <div class="card">
      <h2>Quick links</h2>
      <div class="quick-grid">
        <a href="{{ route('admin.tutorials.index') }}"><x-ad-icon name="play"/>Tutorials<small>Add or update videos</small></a>
        <a href="{{ route('admin.plans.index') }}"><x-ad-icon name="package"/>Packages<small>Edit pricing tiers</small></a>
        <a href="{{ route('admin.messages.index') }}"><x-ad-icon name="mail"/>Enquiries<small>{{ $unreadMessages }} unread</small></a>
        <a href="{{ route('admin.settings.edit') }}"><x-ad-icon name="sliders"/>Settings<small>Logos &amp; brand colors</small></a>
        <a href="{{ route('admin.faqs.index') }}"><x-ad-icon name="help"/>FAQs<small>Answer common questions</small></a>
        <a href="{{ route('home') }}" target="_blank"><x-ad-icon name="external"/>View site<small>See changes live</small></a>
      </div>
    </div>
  </div>
</x-admin-shell>
