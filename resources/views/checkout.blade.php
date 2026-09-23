@extends('layouts.site')

@section('title', 'Checkout: ' . $plan->name . ' | ' . $settings->site_name)

@section('content')
<main class="checkout-page" data-package-slug="{{ $plan->slug }}" data-purchase-url="{{ route('api.packages.purchase') }}">
  <section class="checkout-hero">
    <div class="wrap checkout-grid">
      <div class="checkout-copy">
        <a href="{{ route('home') }}#pricing" class="back-link">
          <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M19 12H5m6-6-6 6 6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
          Back to pricing
        </a>
        <span class="checkout-eyebrow">Secure checkout</span>
        <h1><span>{{ $plan->name }}</span></h1>
        @if($plan->duration_label)
          <p class="checkout-duration">
            <span class="checkout-duration-dot" aria-hidden="true"></span>
            {{ $plan->duration_label }}
          </p>
        @endif
        <p class="lede">Choose how this package will be billed, enter your email, and continue to Stripe to complete payment.</p>

        <div class="checkout-trust" aria-label="Checkout assurances">
          <div class="checkout-trust-item">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3 5 6v5c0 4.4 2.9 7.4 7 9 4.1-1.6 7-4.6 7-9V6l-7-3Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="m9 12 2 2 4-4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span>Encrypted</span>
          </div>
          <div class="checkout-trust-item">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="5" y="10" width="14" height="10" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M8 10V7a4 4 0 0 1 8 0v3" stroke="currentColor" stroke-width="1.7"/><circle cx="12" cy="15" r="1.3" fill="currentColor"/></svg>
            <span>Stripe secured</span>
          </div>
          <div class="checkout-trust-item">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 7.5h16M4 12h16M4 16.5h10" stroke="currentColor" stroke-linecap="round"/></svg>
            <span>No card stored</span>
          </div>
        </div>
      </div>

      <form class="checkout-panel" id="checkoutForm">
        <div class="checkout-panel-accent" aria-hidden="true"></div>
        <div class="checkout-summary">
          <div class="checkout-summary-top">
            <span class="pk">{{ $plan->tier_label }}</span>
            <span class="checkout-summary-status">
              <span class="checkout-summary-status-dot" aria-hidden="true"></span>
              Ready to checkout
            </span>
          </div>
          <h2>{{ $plan->name }}</h2>
          <div class="checkout-price">
            <span class="checkout-currency">£</span>
            <strong id="checkoutAmount"
              data-ind="{{ number_format($plan->price_ind) }}"
              data-joint="{{ number_format($plan->price_joint) }}">{{ number_format($plan->priceFor($selectedMode)) }}</strong>
          </div>
          <p id="checkoutSub"
            data-ind="{{ $plan->sub_ind }}"
            data-joint="{{ $plan->sub_joint }}">{{ $selectedMode === 'joint' ? $plan->sub_joint : $plan->sub_ind }}</p>
        </div>

        <div class="checkout-options" role="radiogroup" aria-label="Billing option">
          <label class="checkout-option">
            <input type="radio" name="billing_variant" value="individual" {{ $selectedMode === 'individual' ? 'checked' : '' }}>
            <span class="checkout-option-body">
              <span>Individual</span>
              <strong>£{{ number_format($plan->price_ind) }}</strong>
            </span>
          </label>
          <label class="checkout-option">
            <input type="radio" name="billing_variant" value="joint" {{ $selectedMode === 'joint' ? 'checked' : '' }}>
            <span class="checkout-option-body">
              <span>Joint application</span>
              <strong>£{{ number_format($plan->price_joint) }}</strong>
            </span>
          </label>
        </div>

        <div class="checkout-field">
          <label for="customerEmail">Email address <span class="checkout-field-hint">For your receipt</span></label>
          <div class="checkout-input-wrap">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 6.5h16v11H4v-11Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="m4.5 7 7.5 6 7.5-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <input id="customerEmail" type="email" name="customer_email" autocomplete="email" required placeholder="client@example.com">
          </div>
        </div>

        <div class="checkout-message" id="checkoutMessage" hidden></div>
        <button type="submit" class="btn btn-primary checkout-submit">Continue to Stripe
          <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
        <p class="checkout-note"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3 5 6v5c0 4.4 2.9 7.4 7 9 4.1-1.6 7-4.6 7-9V6l-7-3Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M12 8v4m0 3h.01" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg><span>Payment is processed securely by Stripe. Balance Point does not store card details.</span></p>
      </form>
    </div>
  </section>

  <section class="checkout-details">
    <div class="wrap checkout-detail-grid">
      <div class="checkout-features-card">
        <span class="checkout-section-label">What is included</span>
        <h2>Everything you need to move forward</h2>
        <ul class="checkout-features">
          @foreach($plan->featureList() as $featureLine)
            <li>
              <span class="checkout-feature-check" aria-hidden="true">
                <svg viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
              </span>
              <span data-ind="{{ $featureLine['ind'] }}" data-joint="{{ $featureLine['joint'] }}">{{ $selectedMode === 'joint' ? $featureLine['joint'] : $featureLine['ind'] }}</span>
            </li>
          @endforeach
        </ul>
      </div>
      <div class="checkout-help">
        <div class="checkout-help-icon">
          <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 6.5h16v11H4v-11Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="m4.5 7 7.5 6 7.5-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <span class="checkout-section-label">Still deciding?</span>
        <h2>Need help first?</h2>
        <p>Send a note if you are unsure which package fits your case. We reply within one working day.</p>
        <a href="{{ route('home') }}#contact" class="btn btn-ghost checkout-help-btn">Contact us
          <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
      </div>
    </div>
  </section>
</main>
@endsection
