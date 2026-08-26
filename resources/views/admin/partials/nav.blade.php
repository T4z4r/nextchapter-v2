@php($current = request()->routeIs('admin.dashboard') ? 'dashboard' : (request()->route()->getName() ?? ''))
<nav class="ad-nav">
  <a href="{{ route('admin.dashboard') }}" class="{{ str_starts_with($current, 'admin.dashboard') ? 'active' : '' }}">
    <x-ad-icon name="grid"/>Dashboard
  </a>

  <span class="sep">Content sections</span>
  <a href="{{ route('admin.sections.index') }}" class="{{ str_starts_with($current, 'admin.sections') ? 'active' : '' }}">
    <x-ad-icon name="type"/>Section headings
  </a>
  <a href="{{ route('admin.steps.index') }}" class="{{ str_starts_with($current, 'admin.steps') ? 'active' : '' }}">
    <x-ad-icon name="list"/>How-it-works steps
  </a>
  <a href="{{ route('admin.features.index') }}" class="{{ str_starts_with($current, 'admin.features') ? 'active' : '' }}">
    <x-ad-icon name="zap"/>Platform features
  </a>
  <a href="{{ route('admin.tutorials.index') }}" class="{{ str_starts_with($current, 'admin.tutorials') ? 'active' : '' }}">
    <x-ad-icon name="play"/>Tutorials
  </a>
  <a href="{{ route('admin.faqs.index') }}" class="{{ str_starts_with($current, 'admin.faqs') ? 'active' : '' }}">
    <x-ad-icon name="help"/>FAQs
  </a>

  <span class="sep">Commerce</span>
  <a href="{{ route('admin.plans.index') }}" class="{{ str_starts_with($current, 'admin.plans') ? 'active' : '' }}">
    <x-ad-icon name="package"/>Packages
  </a>
  <a href="{{ route('admin.addons.index') }}" class="{{ str_starts_with($current, 'admin.addons') ? 'active' : '' }}">
    <x-ad-icon name="plus-square"/>Add-ons
  </a>
  <a href="{{ route('admin.messages.index') }}" class="{{ str_starts_with($current, 'admin.messages') ? 'active' : '' }}">
    <x-ad-icon name="mail"/>Enquiries
  </a>

  <span class="sep">Site-wide</span>
  <a href="{{ route('admin.values.index') }}" class="{{ str_starts_with($current, 'admin.values') ? 'active' : '' }}">
    <x-ad-icon name="award"/>About values
  </a>
  <a href="{{ route('admin.settings.edit') }}" class="{{ str_starts_with($current, 'admin.settings') ? 'active' : '' }}">
    <x-ad-icon name="sliders"/>Settings
  </a>
  <a href="{{ route('home') }}" target="_blank">
    <x-ad-icon name="external"/>View site ↗
  </a>
</nav>
