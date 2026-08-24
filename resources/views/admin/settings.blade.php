<x-admin-shell title="Site settings">
  <x-admin-form action="{{ route('admin.settings.update') }}">
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
      <div class="field">
        <label for="logo_path">Header logo path</label>
        <input id="logo_path" type="text" name="logo_path" value="{{ old('logo_path', $setting->logo_path) }}" placeholder="images/nextchapter-logo.png">
      </div>
      <div class="field">
        <label for="footer_logo_path">Footer logo path</label>
        <input id="footer_logo_path" type="text" name="footer_logo_path" value="{{ old('footer_logo_path', $setting->footer_logo_path) }}" placeholder="images/nextchapter-footer.png">
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
</x-admin-shell>
