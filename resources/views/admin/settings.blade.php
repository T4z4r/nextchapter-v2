<x-admin-shell title="Site settings">
  <x-admin-form action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" test testHint="Saves the form first, then attempts to send a test email to your account address so you can verify the SMTP configuration.">
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
            <img src="{{ asset($setting->logoAssetPath()) }}" alt="Current header logo">
          </div>
          <label style="display:flex;align-items:center;gap:8px;font-weight:400;margin-top:6px">
            <input type="checkbox" name="remove_logo" value="1"> Remove current header logo
          </label>
        @endif
        <x-dropzone name="logo" label="Drop logo image here" accept=".png,.jpg,.jpeg,.webp,.svg,image/*" hint="PNG, JPG, WEBP or SVG — max 2 MB"/>
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
        <x-dropzone name="footer_logo" label="Drop footer logo here" accept=".png,.jpg,.jpeg,.webp,.svg,image/*" hint="PNG, JPG, WEBP or SVG — max 2 MB"/>
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

    <div style="display:flex;align-items:baseline;gap:10px;margin-top:8px">
      <h2 style="margin:0">Email (SMTP)</h2>
      @if($setting->mailConfigured())
        <span class="badge on">Configured</span>
      @else
        <span class="badge off">Using log driver — emails not delivered</span>
      @endif
    </div>
    <p class="hint" style="margin-bottom:10px">
      Used as the default mailer for this site (notifications, contact forms). Choose <strong>Log</strong> to write emails to the log for debugging instead of sending them.
    </p>
    <div class="form-cols">
      <div class="field">
        <label for="mail_driver">Mail driver</label>
        <select id="mail_driver" name="mail_driver">
          <option value="smtp" @selected(old('mail_driver', $setting->mail_driver ?? 'smtp') === 'smtp')>SMTP — actually send emails</option>
          <option value="log" @selected(old('mail_driver', $setting->mail_driver ?? 'smtp') === 'log')>Log — write to log, don't send</option>
        </select>
      </div>
      <div class="field">
        <label for="mail_host">SMTP host</label>
        <input id="mail_host" type="text" name="mail_host" value="{{ old('mail_host', $setting->mail_host) }}" placeholder="smtp.example.com">
        @error('mail_host')<span class="hint" style="color:#B3402D">{{ $message }}</span>@enderror
      </div>
      <div class="field">
        <label for="mail_port">Port</label>
        <input id="mail_port" type="text" name="mail_port" value="{{ old('mail_port', $setting->mail_port) }}" placeholder="587">
      </div>
      <div class="field">
        <label for="mail_encryption">Encryption</label>
        <select id="mail_encryption" name="mail_encryption">
          <option value="tls" @selected(old('mail_encryption', $setting->mail_encryption) === 'tls')>TLS (recommended)</option>
          <option value="ssl" @selected(old('mail_encryption', $setting->mail_encryption) === 'ssl')>SSL</option>
          <option value="" @selected(old('mail_encryption', $setting->mail_encryption) === '')>None</option>
        </select>
      </div>
      <div class="field">
        <label for="mail_username">Username</label>
        <input id="mail_username" type="text" name="mail_username" value="{{ old('mail_username', $setting->mail_username) }}" placeholder="you@example.com" autocomplete="off">
      </div>
      <div class="field">
        <label for="mail_password">Password</label>
        <input id="mail_password" type="password" name="mail_password" value="{{ old('mail_password', $setting->mail_password) }}" placeholder="SMTP password" autocomplete="new-password">
      </div>
      <div class="field">
        <label for="mail_from_address">From address</label>
        <input id="mail_from_address" type="email" name="mail_from_address" value="{{ old('mail_from_address', $setting->mail_from_address) }}" placeholder="noreply@nextchapter.uk">
      </div>
      <div class="field">
        <label for="mail_from_name">From name</label>
        <input id="mail_from_name" type="text" name="mail_from_name" value="{{ old('mail_from_name', $setting->mail_from_name) }}" placeholder="Next Chapter">
      </div>
    </div>

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
