<x-admin-shell title="Site settings">
  <x-admin-form action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
    @method('PUT')
    <div class="form-cols">
      <div class="field">
        <label for="site_name">Site name</label>
        <input id="site_name" type="text" name="site_name" value="{{ old('site_name', $setting->site_name) }}" required>
      </div>
      <div class="field">
        <label for="contact_email">Contact email</label>
        <input id="contact_email" type="email" name="contact_email" value="{{ old('contact_email', $setting->contact_email) }}">
      </div>
      <div class="field">
        <label for="opening_hours">Opening hours</label>
        <input id="opening_hours" type="text" name="opening_hours" value="{{ old('opening_hours', $setting->opening_hours) }}">
      </div>
      <div class="field">
        <label for="location">Location</label>
        <input id="location" type="text" name="location" value="{{ old('location', $setting->location) }}">
      </div>
    </div>

    <h2 style="margin-top:8px">Brand logos</h2>
    <div class="form-cols">
      <div class="field">
        <label>Header logo</label>
        @if($setting->logo_path)
          <div class="brand-current">
            <img src="{{ asset($setting->logo_path) }}" alt="Current header logo">
          </div>
          <label style="display:flex;align-items:center;gap:8px;font-weight:400;margin-top:6px">
            <input type="checkbox" name="remove_logo" value="1"> Remove current header logo
          </label>
        @endif
        <input type="file" name="logo" accept=".png,.jpg,.jpeg,.webp,.svg,image/*">
        <span class="hint">PNG, JPG, WEBP or SVG, max 2&nbsp;MB. Replaces any current logo.</span>
      </div>
      <div class="field">
        <label>Footer logo</label>
        @if($setting->footer_logo_path)
          <div class="brand-current brand-current-dark">
            <img src="{{ asset($setting->footer_logo_path) }}" alt="Current footer logo">
          </div>
          <label style="display:flex;align-items:center;gap:8px;font-weight:400;margin-top:6px">
            <input type="checkbox" name="remove_footer_logo" value="1"> Remove current footer logo
          </label>
        @endif
        <input type="file" name="footer_logo" accept=".png,.jpg,.jpeg,.webp,.svg,image/*">
        <span class="hint">Shown on the dark footer — a light/white version usually works best.</span>
      </div>
    </div>

    <h2 style="margin-top:8px">Brand colors</h2>
    <p class="hint" style="margin-bottom:10px">Leave a field empty to keep the default. Colors apply across the whole site instantly.</p>
    @foreach([
        'color_primary' => ['Primary', 'Buttons, links, accents'],
        'color_deep' => ['Deep accent', 'Hover states, headings emphasis'],
        'color_ink' => ['Dark / ink', 'Dark bands, main text'],
        'color_accent' => ['Secondary accent', 'Gradients paired with primary'],
    ] as $key => [$label, $usage])
      @php $default = $colorDefaults[$key]; $current = old($key, $setting->{$key}); @endphp
      <div class="form-cols">
        <div class="field">
          <label for="{{ $key }}">{{ $label }} <small style="font-weight:400;color:var(--muted)">({{ $usage }})</small></label>
          <div style="display:flex;gap:8px;align-items:center">
            <input type="color" class="brand-swatch" data-for="{{ $key }}" value="{{ $current ?: $default }}"
                   aria-label="{{ $label }} picker" style="width:44px;height:38px;padding:2px;border:1px solid var(--line);border-radius:8px;background:none;cursor:pointer">
            <input id="{{ $key }}" type="text" name="{{ $key }}" value="{{ $current }}"
                   placeholder="e.g. {{ $default }}" maxlength="7"
                   pattern="#?[0-9a-fA-F]{6}" style="max-width:140px">
          </div>
          <span class="hint">Hex code, or use the swatch. Default {{ strtoupper($default) }}.</span>
        </div>
      </div>
    @endforeach

    <h2 style="margin-top:8px">Compliance &amp; footer</h2>
    <div class="field">
      <label for="disclaimer_bar_text">Disclaimer bar text</label>
      <textarea id="disclaimer_bar_text" name="disclaimer_bar_text" rows="5">{{ old('disclaimer_bar_text', $setting->disclaimer_bar_text) }}</textarea>
      <span class="hint">The long notice under the hero. Basic HTML allowed, e.g. &lt;strong&gt;.</span>
    </div>
    <div class="form-cols">
      <div class="field">
        <label for="footer_blurb">Footer blurb</label>
        <textarea id="footer_blurb" name="footer_blurb" rows="3">{{ old('footer_blurb', $setting->footer_blurb) }}</textarea>
      </div>
      <div>
        <div class="field">
          <label for="copyright_holder">Copyright holder</label>
          <input id="copyright_holder" type="text" name="copyright_holder" value="{{ old('copyright_holder', $setting->copyright_holder) }}">
        </div>
        <div class="field">
          <label for="legal_footnote">Footer legal footnote</label>
          <input id="legal_footnote" type="text" name="legal_footnote" value="{{ old('legal_footnote', $setting->legal_footnote) }}">
        </div>
      </div>
    </div>
    <div class="field">
      <label for="meta_description">Meta description</label>
      <textarea id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $setting->meta_description) }}</textarea>
    </div>
  </x-admin-form>

  <script>
    document.querySelectorAll('.brand-swatch').forEach(function (swatch) {
      var target = document.getElementById(swatch.dataset.for);
      if (!target) return;
      swatch.addEventListener('input', function () { target.value = swatch.value; });
      target.addEventListener('input', function () {
        if (/^#[0-9a-fA-F]{6}$/.test(target.value)) { swatch.value = target.value; }
      });
    });
  </script>
</x-admin-shell>
