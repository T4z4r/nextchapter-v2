@php
  $hour = (int) now()->format('G');
  $greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
@endphp

<x-admin-shell title="Dashboard">
  <div class="dash-hero">
    <div class="dash-hero-body">
      <h1>{{ $greeting }} <span class="wave">&#128075;</span></h1>
      <p>Everything on the public site — copy, tutorials, pricing, branding — is managed from here.
         Changes go live immediately and are tracked in the activity feed below.</p>
      <a href="{{ route('home') }}" target="_blank" class="btn btn-primary"><x-ad-icon name="external"/>View live site</a>
    </div>
    <div class="dash-hero-art">
      <div class="dash-hero-ring"></div>
    </div>
  </div>

  <div class="stat-grid">
    <a href="{{ route('admin.messages.index') }}" class="stat{{ $unreadMessages ? ' stat-alert' : '' }}">
      <span class="stat-ico"><x-ad-icon name="mail"/></span>
      <div class="stat-body">
        <div class="n">{{ $totalMessages }}</div>
        <div class="l">Enquiries &amp; intents</div>
        <div class="s">@if($unreadMessages)<strong>{{ $unreadMessages }} unread</strong> · @endif{{ $enquiries }} enquiry · {{ $intents }} intent{{ $intents !== 1 ? 's' : '' }}</div>
      </div>
    </a>

    <a href="{{ route('admin.tutorials.index') }}" class="stat">
      <span class="stat-ico"><x-ad-icon name="play"/></span>
      <div class="stat-body">
        <div class="n">{{ $tutorials }}</div>
        <div class="l">Tutorials</div>
        <div class="s">{{ $lockedTutorials }} locked · {{ $tutorials - $lockedTutorials }} free</div>
      </div>
    </a>

    <a href="{{ route('admin.plans.index') }}" class="stat">
      <span class="stat-ico"><x-ad-icon name="package"/></span>
      <div class="stat-body">
        <div class="n">{{ $plans }}</div>
        <div class="l">Packages</div>
        <div class="s">{{ $addons }} active add-on{{ $addons !== 1 ? 's' : '' }}</div>
      </div>
    </a>

    <a href="{{ route('admin.faqs.index') }}" class="stat">
      <span class="stat-ico"><x-ad-icon name="help"/></span>
      <div class="stat-body">
        <div class="n">{{ $faqs }}</div>
        <div class="l">FAQs</div>
        <div class="s">live on the public page</div>
      </div>
    </a>
  </div>

  <div class="dash-cols">
    <div class="card dash-activity">
      <h2>Recent activity</h2>
      @if($recent->isEmpty())
        <p class="hint">No activity yet — edits you make will appear here in real time.</p>
      @else
        <ul class="timeline">
          @foreach($recent as $log)
            <li class="tl-item">
              <span class="tl-dot b-{{ $log->verbGroup() }}"></span>
              <div class="tl-body">
                <span class="tl-head">
                  <span class="tl-desc">{{ $log->description }}</span>
                  <span class="tl-time">{{ $log->ago() }}</span>
                </span>
                <span class="tl-meta">
                  <span class="tl-avatar">{{ strtoupper(mb_substr($log->user?->name ?? $log->user?->email ?? 'sys', 0, 1)) }}</span>
                  {{ $log->user?->name ?? $log->user?->email ?? 'System' }}
                  @if($log->ip) <span class="tl-ip">{{ $log->ip }}</span> @endif
                </span>
              </div>
            </li>
          @endforeach
        </ul>
        <p class="hint" style="margin-top:12px">Tracks content edits, settings, enquiries, checkout intents &amp; admin sign-ins.</p>
      @endif
    </div>

    <div class="dash-quick-wrap">
      <h2 style="font-size:16px;margin:0 0 10px">Quick actions</h2>
      <div class="dash-quick">
        <a href="{{ route('admin.tutorials.create') }}" class="dq-card"><span class="dq-ico"><x-ad-icon name="play"/></span><span class="dq-text"><strong>Add tutorial</strong><small>Video + thumbnail</small></span></a>
        <a href="{{ route('admin.faqs.create') }}" class="dq-card"><span class="dq-ico"><x-ad-icon name="help"/></span><span class="dq-text"><strong>Add FAQ</strong><small>Answer a question</small></span></a>
        <a href="{{ route('admin.plans.create') }}" class="dq-card"><span class="dq-ico"><x-ad-icon name="package"/></span><span class="dq-text"><strong>Add package</strong><small>New pricing tier</small></span></a>
        <a href="{{ route('admin.settings.edit') }}" class="dq-card"><span class="dq-ico"><x-ad-icon name="sliders"/></span><span class="dq-text"><strong>Brand settings</strong><small>Logos &amp; colors</small></span></a>
        <a href="{{ route('admin.messages.index') }}" class="dq-card"><span class="dq-ico"><x-ad-icon name="mail"/></span><span class="dq-text"><strong>Enquiries</strong><small>{{ $unreadMessages }} unread</small></span></a>
        <a href="{{ route('admin.steps.index') }}" class="dq-card"><span class="dq-ico"><x-ad-icon name="list"/></span><span class="dq-text"><strong>How-it-works</strong><small>Edit steps</small></span></a>
      </div>
    </div>
  </div>
</x-admin-shell>
