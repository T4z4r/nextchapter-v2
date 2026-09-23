@extends('layouts.site')

@section('title', 'Checkout: ' . $plan->name . ' | ' . $settings->site_name)

@section('content')
<main class="checkout-page" data-package-slug="{{ $plan->slug }}" data-purchase-url="{{ route('api.packages.purchase') }}">
  <section class="checkout-hero">
    <div class="wrap checkout-grid">
      <div class="checkout-copy">
        <a href="{{ route('home') }}#pricing" class="back-link">Back to pricing</a>
        <span class="eyebrow">Secure checkout</span>
        <h1>{{ $plan->name }}</h1>
        @if($plan->duration_label)<p class="checkout-duration">{{ $plan->duration_label }}</p>@endif
        <p class="lede">Choose how this package will be billed, enter your email, and continue to Stripe to complete payment.</p>
      </div>

      <form class="checkout-panel" id="checkoutForm">
        <div class="checkout-summary">
          <span class="pk">{{ $plan->tier_label }}</span>
          <h2>{{ $plan->name }}</h2>
          <div class="checkout-price">
            <span>£</span>
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
            <span>
              <strong>Individual</strong>
              <small>£{{ number_format($plan->price_ind) }}</small>
            </span>
          </label>
          <label class="checkout-option">
            <input type="radio" name="billing_variant" value="joint" {{ $selectedMode === 'joint' ? 'checked' : '' }}>
            <span>
              <strong>Joint application</strong>
              <small>£{{ number_format($plan->price_joint) }}</small>
            </span>
          </label>
        </div>

        <div class="checkout-field">
          <label for="customerEmail">Email address</label>
          <input id="customerEmail" type="email" name="customer_email" autocomplete="email" required placeholder="client@example.com">
        </div>

        <div class="checkout-message" id="checkoutMessage" hidden></div>

        <button type="submit" class="btn btn-primary checkout-submit">Continue to Stripe</button>
        <p class="checkout-note">Payment is processed securely by Stripe. Balance Point does not store card details.</p>
      </form>
    </div>
  </section>

  <section class="checkout-details">
    <div class="wrap checkout-detail-grid">
      <div>
        <h2>Included</h2>
        <ul class="checkout-features">
          @foreach($plan->featureList() as $featureLine)
            <li>
              <svg viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
              <span data-ind="{{ $featureLine['ind'] }}" data-joint="{{ $featureLine['joint'] }}">{{ $selectedMode === 'joint' ? $featureLine['joint'] : $featureLine['ind'] }}</span>
            </li>
          @endforeach
        </ul>
      </div>
      <div class="checkout-help">
        <h2>Need help first?</h2>
        <p>Send a note if you are unsure which package fits your case. We reply within one working day.</p>
        <a href="{{ route('home') }}#contact" class="btn btn-ghost">Contact us</a>
      </div>
    </div>
  </section>
</main>
@endsection
