@extends('layouts.site')

@section('title', 'Legal & Policies')

@section('content')
<section id="privacy">
  <div class="wrap" style="max-width:820px">
    <div class="sec-head">
      <span class="eyebrow">Legal &amp; Policies</span>
      <h2>Privacy, refunds &amp; complaints</h2>
      <p>Placeholder policies — replace with your confirmed legal copy before going live.</p>
    </div>

    <div class="card" style="background:#fff;border:1px solid var(--line);border-radius:14px;padding:30px 34px;margin-bottom:26px">
      <h3 style="font-size:22px;margin-bottom:10px">Privacy &amp; GDPR</h3>
      <p style="color:var(--muted);font-size:15.5px;line-height:1.7">Your data is encrypted and held in your own secure, UK GDPR-compliant portal. It is never stored in a shared inbox or visible to anyone outside your case. You stay in control of it throughout.</p>
    </div>

    <div class="card" id="refunds" style="background:#fff;border:1px solid var(--line);border-radius:14px;padding:30px 34px;margin-bottom:26px">
      <h3 style="font-size:22px;margin-bottom:10px">Refunds</h3>
      <p style="color:var(--muted);font-size:15.5px;line-height:1.7">Fixed-fee packages are refundable in line with your consumer rights up to the point substantive work begins. Contact us to discuss your specific circumstances.</p>
    </div>

    <div class="card" id="complaints" style="background:#fff;border:1px solid var(--line);border-radius:14px;padding:30px 34px">
      <h3 style="font-size:22px;margin-bottom:10px">Complaints</h3>
      <p style="color:var(--muted);font-size:15.5px;line-height:1.7">If something has gone wrong, email <a href="mailto:{{ $settings->contact_email }}" style="color:var(--pine);font-weight:600">{{ $settings->contact_email }}</a> and we will acknowledge within two working days and respond fully within ten.</p>
    </div>
  </div>
</section>
@endsection
