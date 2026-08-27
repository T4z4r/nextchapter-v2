@extends('layouts.site')

@section('content')

<!-- ============ HERO ============ -->
@if($hero && $hero->is_active)
<section class="hero" style="padding-top:64px">
  <div class="wrap hero-grid">
    <div>
      @if(session('success'))
        <div class="flash-banner ok">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="flash-banner err">{{ session('error') }}</div>
      @endif
      @if($hero->eyebrow)<span class="eyebrow">{{ $hero->eyebrow }}</span>@endif
      <h1>{!! $hero->heading !!}</h1>
      @if($hero->subheading)<p class="lede">{{ $hero->subheading }}</p>@endif
      @if($hero->data('credit'))
        <p class="credit">
          <svg viewBox="0 0 24 24" fill="none" stroke="#2C7CB8" stroke-width="1.8" aria-hidden="true"><path d="M12 3l8 4v5c0 5-3.5 8-8 9-4.5-1-8-4-8-9V7l8-4z" stroke-linejoin="round"/><path d="M9 12l2 2 4-4" stroke-linecap="round" stroke-linejoin="round"/></svg>
          {{ $hero->data('credit') }}
        </p>
      @endif
      <div class="hero-actions">
        @if($hero->cta1_label)<a href="{{ $hero->cta1_url }}" class="btn btn-primary">{{ $hero->cta1_label }}</a>@endif
        @if($hero->cta2_label)<a href="{{ $hero->cta2_url }}" class="btn btn-ghost">{{ $hero->cta2_label }}</a>@endif
      </div>
      @if($hero->data('note'))<p class="hero-note">{{ $hero->data('note') }}</p>@endif
    </div>

    <div class="balance-stage">
      @if($settings->logo_path)
        <img class="stage-logo" src="{{ asset($settings->logoAssetPath()) }}" alt="Balance Point">
      @endif
      <div class="beam-wrap">
        <svg class="beam" viewBox="0 0 400 300" role="img" aria-label="A balance scale holding the same clear view for both parties.">
          <path d="M200 150 L170 250 L230 250 Z" fill="#459EDF"></path>
          <rect x="150" y="250" width="100" height="8" rx="4" fill="#17242E"></rect>
          <circle cx="200" cy="150" r="7" fill="#58CBDD"></circle>
          <g class="arm">
            <rect x="60" y="147" width="280" height="6" rx="3" fill="#17242E"></rect>
            <g class="pan">
              <line x1="80" y1="150" x2="80" y2="185" stroke="#6FA8CC" stroke-width="2"></line>
              <path d="M56 185 Q80 214 104 185 Z" fill="#fff" stroke="#6FA8CC" stroke-width="2"></path>
              <text x="80" y="238" text-anchor="middle" class="label">Party A</text>
            </g>
            <g class="pan">
              <line x1="320" y1="150" x2="320" y2="185" stroke="#6FA8CC" stroke-width="2"></line>
              <path d="M296 185 Q320 214 344 185 Z" fill="#fff" stroke="#6FA8CC" stroke-width="2"></path>
              <text x="320" y="238" text-anchor="middle" class="label">Party B</text>
            </g>
          </g>
        </svg>
      </div>
      @if($hero->data('stage_caption'))<div class="stage-cap">{{ $hero->data('stage_caption') }}</div>@endif
    </div>
  </div>
</section>
@endif

<div class="disclaimer">
  <div class="wrap">
    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3l8 4v5c0 5-3.5 8-8 9-4.5-1-8-4-8-9V7l8-4z" stroke-linejoin="round"/><path d="M12 8v4M12 16h.01" stroke-linecap="round"/></svg>
    <span>{!! $settings->disclaimer_bar_text !!}</span>
  </div>
</div>

<!-- ============ HOW IT WORKS ============ -->
@if($howSection && $howSection->is_active && count($steps))
<section id="how">
  <div class="wrap">
    <div class="sec-head">
      @if($howSection->eyebrow)<span class="eyebrow">{{ $howSection->eyebrow }}</span>@endif
      <h2>{{ $howSection->heading }}</h2>
      @if($howSection->subheading)<p>{{ $howSection->subheading }}</p>@endif
    </div>
    <div class="steps">
      @foreach($steps as $step)
        <div class="step{{ $step->isHighlight() ? ' hero-step' : '' }}">
          <span class="num">{{ $step->num_label }}</span>
          <h3>{{ $step->title }}</h3>
          @if($step->description)<p>{!! $step->description !!}</p>@endif
          @if(trim((string) $step->bullets) !== '')
            <ul>
              @foreach(preg_split('/\r\n|\r|\n/', $step->bullets) as $bullet)
                @if(trim($bullet) !== '')<li>{!! trim($bullet) !!}</li>@endif
              @endforeach
            </ul>
          @endif
          @if($step->footnote)
            @if($step->isHighlight())
              <div class="save">{!! $step->footnote !!}</div>
            @else
              <p class="muted-note">{!! $step->footnote !!}</p>
            @endif
          @endif
          <div class="rule"></div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- ============ BALANCE POINT SOFTWARE ============ -->
@if($platform && $platform->is_active && count($features))
<section id="software" class="band-dark">
  <div class="wrap">
    <div class="sec-head">
      @if($platform->eyebrow)<span class="eyebrow">{{ $platform->eyebrow }}</span>@endif
      <img class="bp-logo" src="{{ asset('images/balancepoint-logo.png') }}" alt="Balance Point">
      <h2>{{ $platform->heading }}</h2>
      @if($platform->subheading)<p>{{ $platform->subheading }}</p>@endif
    </div>

    <div class="pillars">
      @foreach($features as $feature)
        @continue(!in_array($feature->type, ['lead','feature','pair']))
        @if(in_array($feature->type, ['lead','feature']))
          <div class="pillar {{ $feature->type === 'lead' ? 'lead-pillar' : 'diff-pillar' }}">
            @if($feature->type === 'lead')
              <div class="pillar-body">
                @include('partials.pillar-body', ['feature' => $feature])
              </div>
              <div class="pillar-visual">
                @include('partials.pillar-visual', ['feature' => $feature])
              </div>
            @else
              <div class="pillar-visual">
                @include('partials.pillar-visual', ['feature' => $feature])
              </div>
              <div class="pillar-body">
                @include('partials.pillar-body', ['feature' => $feature])
              </div>
            @endif
          </div>
        @elseif($loop->first || $features[$loop->index - 1]->type !== 'pair')
          <div class="pair-row">
            @include('partials.pair-cards', ['items' => $features->slice($loop->index)->takeWhile(fn ($f) => $f->type === 'pair')])
        @endif
        @if($feature->type === 'pair' && ($loop->last || $features[$loop->index + 1]->type !== 'pair'))
          </div>
        @endif
      @endforeach
    </div>

    @if($platform->body)
      <p style="text-align:center;margin-top:30px;font-size:14.5px;color:var(--sage-soft)">{!! $platform->body !!}</p>
    @endif
  </div>
</section>
@endif

<!-- ============ DEMO & TUTORIALS ============ -->
@if($demo && $demo->is_active)
<section id="demo">
  <div class="wrap">
    <div class="sec-head center">
      @if($demo->eyebrow)<span class="eyebrow" style="justify-content:center">{{ $demo->eyebrow }}</span>@endif
      <h2>{{ $demo->heading }}</h2>
      @if($demo->subheading)<p>{{ $demo->subheading }}</p>@endif
    </div>

    @if($demo->video_url)
    <div class="demo-main">
      <div class="video-frame">
        <video id="demoVideo" poster="" preload="metadata" playsinline>
          <source src="{{ $demo->video_url }}" type="video/mp4">
        </video>
        <div class="play" id="demoPlay" role="button" tabindex="0" aria-label="Play demo video">
          <span><svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg></span>
        </div>
      </div>
      <div class="demo-copy">
        <h3>{{ $demo->data('video_heading') }}</h3>
        <p>{!! $demo->data('video_body') !!}</p>
        <a href="{{ $hero?->cta1_url ?: '#pricing' }}" class="btn btn-dark">Choose a package</a>
      </div>
    </div>
    @endif

    @if(count($tutorials))
    <div class="tut-lead">
      <h3>{{ $demo->data('tutorials_lead', 'The complete tutorial library') }}</h3>
      <p>{{ $demo->data('tutorials_sub', 'Included with every package') }}</p>
    </div>
    <div class="tut-grid" id="tutGrid">
      @foreach($tutorials as $i => $tut)
        <div class="tut{{ $tut->is_locked ? ' locked' : '' }}" @if(! $tut->is_locked && $tut->videoUrl())data-video-src="{{ $tut->videoUrl() }}"@endif>
          <div class="thumb">
            @if($tut->imageUrl())<img class="thumb-img" src="{{ $tut->imageUrl() }}" alt="">@endif
            <div class="pl">
              @if($tut->is_locked)
                <svg viewBox="0 0 24 24" fill="none"><rect x="6" y="11" width="12" height="9" rx="1.5"/><path d="M9 11V8a3 3 0 016 0v3" stroke-linecap="round"/></svg>
              @else
                <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
              @endif
            </div>
            @if($tut->duration)<span class="dur">{{ $tut->duration }}</span>@endif
          </div>
          <div class="body">
            <span class="k">TUTORIAL {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
            <h4>{{ $tut->title }}</h4>
            @if($tut->description)<div class="rt">{!! $tut->description !!}</div>@endif
          </div>
        </div>
      @endforeach
    </div>
    @if($demo->data('tutorials_note'))
      <p style="text-align:center;margin-top:22px;font-size:14px;color:var(--muted)">{!! $demo->data('tutorials_note') !!}</p>
    @endif
    @endif
  </div>
</section>
@endif

<!-- ============ PRICING ============ -->
@if($pricing && $pricing->is_active)
<section id="pricing" class="band-paper2">
  <div class="wrap">
    <div class="sec-head center">
      @if($pricing->eyebrow)<span class="eyebrow" style="justify-content:center">{{ $pricing->eyebrow }}</span>@endif
      <h2>{{ $pricing->heading }}</h2>
      @if($pricing->subheading)<p>{{ $pricing->subheading }}</p>@endif
    </div>

    <div style="text-align:center">
      <div class="toggle" id="toggle" role="tablist" aria-label="Individual or joint pricing">
        <span class="slide" id="slide"></span>
        <button class="active" data-mode="individual" role="tab" aria-selected="true">Individual</button>
        <button data-mode="joint" role="tab" aria-selected="false">Joint application</button>
      </div>
      <p class="joint-note">{!! $pricing->data('joint_note') !!}</p>
    </div>

    @if($pricing->data('upgrade_banner_text'))
    <div class="upgrade-banner">
      <div class="ub-ico"><svg viewBox="0 0 24 24"><path d="M12 19V5M6 11l6-6 6 6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
      <p>{!! $pricing->data('upgrade_banner_text') !!}</p>
    </div>
    @endif

    <div class="price-grid">
      @foreach($plans as $plan)
        <div class="plan{{ $plan->featured ? ' featured' : '' }}">
          @if($plan->badge)<span class="flag">{{ $plan->badge }}</span>@endif
          <span class="pk">{{ $plan->tier_label }}</span>
          <h3>{{ $plan->name }}</h3>
          @if($plan->duration_label)<div class="dur">{{ $plan->duration_label }}</div>@endif
          <div class="price">
            <span class="cur">£</span>
            <span class="amt" data-ind="{{ number_format($plan->price_ind) }}" data-joint="{{ number_format($plan->price_joint) }}">{{ number_format($plan->price_ind) }}</span>
          </div>
          <div class="subprice">
            <span data-ind="{{ $plan->sub_ind }}" data-joint="{{ $plan->sub_joint }}">{{ $plan->sub_ind }}</span>
          </div>
          <ul>
            @foreach($plan->featureList() as $featureLine)
              <li>
                <svg viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                @if(trim($featureLine['ind']) !== trim($featureLine['joint']))
                  <span data-ind="{{ $featureLine['ind'] }}" data-joint="{{ $featureLine['joint'] }}">{{ $featureLine['ind'] }}</span>
                @else
                  {!! $featureLine['ind'] !!}
                @endif
              </li>
            @endforeach
          </ul>
          <button class="btn {{ $plan->featured ? 'btn-primary' : 'btn-ghost' }} buy" data-package="{{ $plan->slug }}">{{ $plan->cta_label }}</button>
        </div>
      @endforeach
    </div>

    @if(count($addons))
    <div class="addons">
      @foreach($addons as $addon)
        <div class="addon">
          <div>
            <h4>{{ $addon->name }}</h4>
            <div class="rt">{!! $addon->description !!}</div>
          </div>
          <div class="cost">
            <span data-ind="{{ $addon->formattedInd() }}" data-joint="{{ $addon->formattedInd() }}">£{{ $addon->formattedInd() }}</span>
            <small>
              @if($addon->hasJointVariant())
                ind &middot; joint £<span data-ind="{{ $addon->formattedJoint() }}" data-joint="{{ $addon->formattedJoint() }}">{{ $addon->formattedJoint() }}</span>
              @else
                {{ $addon->price_suffix }}
              @endif
            </small>
          </div>
        </div>
      @endforeach
    </div>
    @endif

    @if($professionals && $professionals->is_active)
    <div class="pro">
      <div>
        @if($professionals->eyebrow)<span class="eyebrow" style="color:var(--sage-soft)">{{ $professionals->eyebrow }}</span>@endif
        <h3 style="margin-top:14px">{{ $professionals->heading }}</h3>
        @if($professionals->body)<div class="rt">{!! $professionals->body !!}</div>@endif
        <div class="pro-tags">
          @foreach(($professionals->data('tags') ?? []) as $tag)<span>{{ $tag }}</span>@endforeach
        </div>
      </div>
      <div class="pro-act">
        @if($professionals->cta1_label)
          <a href="{{ $professionals->cta1_url ?: '#contact' }}" class="btn btn-primary">{{ $professionals->cta1_label }}</a>
        @endif
      </div>
    </div>
    @endif
  </div>
</section>
@endif

<!-- ============ ABOUT ============ -->
@if($about && $about->is_active)
<section id="about">
  <div class="wrap about-grid">
    <div class="about-copy">
      @if($about->eyebrow)<span class="eyebrow">{{ $about->eyebrow }}</span>@endif
      <h2>{!! nl2br(e($about->heading)) !!}</h2>
      <div class="rt">{!! $about->body !!}</div>
      @if($about->data('sig'))<p class="sig">{{ $about->data('sig') }}</p>@endif
    </div>
    @if(count($values))
    <div class="values">
      @foreach($values as $value)
        <div class="value">
          <div class="ico">@include('partials.icon', ['name' => $value->icon])</div>
          <h4>{{ $value->title }}</h4>
          <div class="rt">{!! $value->description !!}</div>
        </div>
      @endforeach
    </div>
    @endif
  </div>
</section>
@endif

<!-- ============ FAQ ============ -->
@if($faqSection && $faqSection->is_active && count($faqs))
<section id="faq" class="band-paper2">
  <div class="wrap">
    <div class="sec-head center">
      @if($faqSection->eyebrow)<span class="eyebrow" style="justify-content:center">{{ $faqSection->eyebrow }}</span>@endif
      <h2>{{ $faqSection->heading }}</h2>
    </div>
    <div class="faq-grid">
      @foreach($faqs as $faq)
        <div class="faq">
          <button aria-expanded="false">{{ $faq->question }}<span class="pm"></span></button>
          <div class="ans">{!! $faq->answer !!}</div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- ============ FINAL CTA / CONTACT ============ -->
@if($contact && $contact->is_active)
<section id="contact" class="cta-final">
  <div class="wrap">
    @if($contact->eyebrow)<span class="eyebrow" style="justify-content:center;color:var(--sage-soft)">{{ $contact->eyebrow }}</span>@endif
    <h2 style="margin-top:16px">{{ $contact->heading }}</h2>
    @if($contact->subheading)<p>{{ $contact->subheading }}</p>@endif
    @if(session('success'))
      <div class="flash-banner ok">{{ session('success') }}</div>
    @endif
    <div class="cta-actions">
      @if($contact->cta1_label)<a href="{{ $contact->cta1_url }}" class="btn btn-primary">{{ $contact->cta1_label }}</a>@endif
      @if($contact->cta2_label)<a href="{{ $contact->cta2_url }}" class="btn btn-ghost" style="color:#fff;border-color:rgba(255,255,255,.3)">{{ $contact->cta2_label }}</a>@endif
    </div>
    <div class="contact-info">
      @if($settings->contact_email)<span>Email <a href="mailto:{{ $settings->contact_email }}">{{ $settings->contact_email }}</a></span>@endif
      @if($settings->opening_hours)<span>{{ $settings->opening_hours }}</span>@endif
      @if($settings->location)<span>{{ $settings->location }}</span>@endif
    </div>

    <form class="enquiry-form" method="POST" action="{{ route('enquiries.store') }}">
      @csrf
      <h3>Send us a message</h3>
      <p class="form-note">Tell us where you are in the process and what you need. We reply within one working day.</p>
      @if($errors->any())
        <div class="flash-banner err" style="margin-bottom:18px">Please check the highlighted fields.</div>
      @endif
      <div class="form-grid">
        <div class="form-field">
          <label for="ef-name">Name</label>
          <input id="ef-name" type="text" name="name" value="{{ old('name') }}" required>
          @error('name')<span class="field-error">{{ $message }}</span>@enderror
        </div>
        <div class="form-field">
          <label for="ef-email">Email</label>
          <input id="ef-email" type="email" name="email" value="{{ old('email') }}" required>
          @error('email')<span class="field-error">{{ $message }}</span>@enderror
        </div>
        <div class="form-field">
          <label for="ef-phone">Phone (optional)</label>
          <input id="ef-phone" type="text" name="phone" value="{{ old('phone') }}">
        </div>
        <div class="form-field">
          <label for="ef-package">Interested in</label>
          <select id="ef-package" name="package">
            <option value="">Not sure yet</option>
            @foreach($plans as $plan)
              <option value="{{ $plan->slug }}" {{ old('package') === $plan->slug ? 'selected' : '' }}>{{ $plan->tier_label }} — {{ $plan->name }}</option>
            @endforeach
            @foreach($addons as $addon)
              <option value="{{ $addon->name }}" {{ old('package') === $addon->name ? 'selected' : '' }}>{{ $addon->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-field full">
          <label for="ef-message">Message</label>
          <textarea id="ef-message" name="message" required>{{ old('message') }}</textarea>
          @error('message')<span class="field-error">{{ $message }}</span>@enderror
        </div>
      </div>
      <div class="form-actions">
        <span class="form-note" style="margin-bottom:0">We offer no advice of any kind, financial or legal.</span>
        <button type="submit" class="btn btn-primary">Send message</button>
      </div>
    </form>
  </div>
</section>
@endif

@endsection
