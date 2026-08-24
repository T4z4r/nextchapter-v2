@php($current = request()->routeIs('admin.dashboard') ? 'dashboard' : (request()->route()->getName() ?? ''))
<nav class="ad-nav">
  <a href="{{ route('admin.dashboard') }}" class="{{ str_starts_with($current, 'admin.dashboard') ? 'active' : '' }}">Dashboard</a>

  <span class="sep">Content sections</span>
  <a href="{{ route('admin.sections.index') }}" class="{{ str_starts_with($current, 'admin.sections') ? 'active' : '' }}">Section headings</a>
  <a href="{{ route('admin.steps.index') }}" class="{{ str_starts_with($current, 'admin.steps') ? 'active' : '' }}">How-it-works steps</a>
  <a href="{{ route('admin.features.index') }}" class="{{ str_starts_with($current, 'admin.features') ? 'active' : '' }}">Platform features</a>
  <a href="{{ route('admin.tutorials.index') }}" class="{{ str_starts_with($current, 'admin.tutorials') ? 'active' : '' }}">Tutorials</a>
  <a href="{{ route('admin.faqs.index') }}" class="{{ str_starts_with($current, 'admin.faqs') ? 'active' : '' }}">FAQs</a>

  <span class="sep">Commerce</span>
  <a href="{{ route('admin.plans.index') }}" class="{{ str_starts_with($current, 'admin.plans') ? 'active' : '' }}">Packages</a>
  <a href="{{ route('admin.addons.index') }}" class="{{ str_starts_with($current, 'admin.addons') ? 'active' : '' }}">Add-ons</a>
  <a href="{{ route('admin.messages.index') }}" class="{{ str_starts_with($current, 'admin.messages') ? 'active' : '' }}">Enquiries</a>

  <span class="sep">Site-wide</span>
  <a href="{{ route('admin.values.index') }}" class="{{ str_starts_with($current, 'admin.values') ? 'active' : '' }}">About values</a>
  <a href="{{ route('admin.settings.edit') }}" class="{{ str_starts_with($current, 'admin.settings') ? 'active' : '' }}">Settings</a>
  <a href="{{ route('home') }}" target="_blank">View site ↗</a>
</nav>
