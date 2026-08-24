<x-admin-shell title="{{ $item->exists ? 'Edit step' : 'New step' }}">
  <x-admin-form back="{{ route('admin.steps.index') }}" action="{{ $item->exists ? route('admin.steps.update', $item->id) : route('admin.steps.store') }}">
    @if($item->exists)@method('PUT')@endif
    <div class="form-cols">
      <div class="field">
        <label for="num_label">Number label</label>
        <input id="num_label" type="text" name="num_label" value="{{ old('num_label', $item->num_label) }}" required placeholder="STEP 01 · THE ENGINE">
      </div>
      <div class="field">
        <label for="title">Title</label>
        <input id="title" type="text" name="title" value="{{ old('title', $item->title) }}" required>
      </div>
    </div>
    <x-wysiwyg name="description" label="Description" :value="$item->description">
      <span class="hint">Lead paragraph under the title. Rich text supported.</span>
    </x-wysiwyg>
    <div class="field">
      <label for="bullets">Bullet points (one per line)</label>
      <textarea id="bullets" name="bullets" rows="5">{{ old('bullets', $item->bullets) }}</textarea>
      <span class="hint">Basic HTML allowed, e.g. &lt;strong&gt; for emphasis.</span>
    </div>
    <div class="form-cols">
      <div class="field">
        <label for="footnote">Footnote</label>
        <textarea id="footnote" name="footnote" rows="2">{{ old('footnote', $item->footnote) }}</textarea>
        <span class="hint">Shown as the accent “save” line on highlighted steps, or as a muted note on normal steps.</span>
      </div>
      <div class="field">
        <label for="style">Card style</label>
        <select id="style" name="style">
          <option value="normal" {{ old('style', $item->style) === 'normal' ? 'selected' : '' }}>Normal</option>
          <option value="highlight" {{ old('style', $item->style) === 'highlight' ? 'selected' : '' }}>Highlighted (dark engine card)</option>
        </select>
        <span class="hint">Only one step should normally be highlighted.</span>
      </div>
    </div>
    <div class="form-cols">
      <div class="field">
        <label for="sort">Sort order</label>
        <input id="sort" type="number" name="sort" value="{{ old('sort', $item->sort ?? 0) }}" min="0">
      </div>
      <div class="check-row" style="margin-top:30px">
        <input id="is_active" type="checkbox" name="is_active" value="1" {{ old('is_active', $item->is_active ?? true) ? 'checked' : '' }}>
        <label for="is_active">Visible on site</label>
      </div>
    </div>
  </x-admin-form>
</x-admin-shell>
