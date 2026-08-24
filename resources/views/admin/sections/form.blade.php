<x-admin-shell title="Edit section: {{ $section->name }}">
  <x-admin-form back="{{ route('admin.sections.index') }}" action="{{ route('admin.sections.update', $section) }}">
    @method('PUT')
    <div class="field">
      <label for="eyebrow">Eyebrow</label>
      <input id="eyebrow" type="text" name="eyebrow" value="{{ old('eyebrow', $section->eyebrow) }}">
      <span class="hint">The small uppercase label above the heading.</span>
    </div>
    <div class="field">
      <label for="heading">Heading</label>
      <textarea id="heading" name="heading" rows="2">{{ old('heading', $section->heading) }}</textarea>
      <span class="hint">Basic inline HTML allowed in some sections, e.g. &lt;em&gt;clarity&lt;/em&gt; in the hero heading.</span>
    </div>
    <div class="field">
      <label for="subheading">Subheading</label>
      <textarea id="subheading" name="subheading" rows="3">{{ old('subheading', $section->subheading) }}</textarea>
    </div>
    <x-wysiwyg name="body" label="Body copy" :value="$section->body">
      <span class="hint">
        @if($section->key === 'platform') Small print shown at the bottom of the dark band.
        @else Optional extra copy where the section supports it. Rich text (bold, lists, links) supported. @endif
      </span>
    </x-wysiwyg>

    <h2 style="margin-top:8px">Buttons</h2>
    <div class="form-cols">
      <div class="field">
        <label for="cta1_label">Button 1 label</label>
        <input id="cta1_label" type="text" name="cta1_label" value="{{ old('cta1_label', $section->cta1_label) }}">
      </div>
      <div class="field">
        <label for="cta1_url">Button 1 link</label>
        <input id="cta1_url" type="text" name="cta1_url" value="{{ old('cta1_url', $section->cta1_url) }}">
      </div>
      <div class="field">
        <label for="cta2_label">Button 2 label</label>
        <input id="cta2_label" type="text" name="cta2_label" value="{{ old('cta2_label', $section->cta2_label) }}">
      </div>
      <div class="field">
        <label for="cta2_url">Button 2 link</label>
        <input id="cta2_url" type="text" name="cta2_url" value="{{ old('cta2_url', $section->cta2_url) }}">
      </div>
    </div>

    @if($section->key === 'demo')
      <h2 style="margin-top:8px">Demo &amp; tutorials extras</h2>
      <div class="field">
        <label for="video_url">Demo video URL (mp4)</label>
        <input id="video_url" type="url" name="video_url" value="{{ old('video_url', $section->video_url) }}">
      </div>
    @endif

    <div class="field">
      <label for="data_json">Extra structured data (JSON)</label>
      <textarea id="data_json" name="data_json" rows="10">{{ old('data_json', json_encode($section->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)) }}</textarea>
      <span class="hint">
        Section-specific fields:
        @if($section->key === 'hero') credit, note, stage_caption.
        @elseif($section->key === 'header') links: [{"label": "...", "url": "#..."}].
        @elseif($section->key === 'demo') video_heading, video_body, tutorials_lead, tutorials_sub, tutorials_note.
        @elseif($section->key === 'pricing') joint_note, upgrade_banner_text.
        @elseif($section->key === 'about') sig (the italic signature line).
        @elseif($section->key === 'professionals') tags: ["Law firms", ...].
        @elseif($section->key === 'footer') columns: [{"title": "...", "links": [...]}].
        @else none for this section — leave as {} or null. @endif
      </span>
    </div>

    <div class="check-row">
      <input id="is_active" type="checkbox" name="is_active" value="1" {{ old('is_active', $section->is_active ?? true) ? 'checked' : '' }}>
      <label for="is_active">Section visible on site</label>
    </div>
  </x-admin-form>
</x-admin-shell>
