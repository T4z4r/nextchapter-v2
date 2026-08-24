<x-admin-shell title="{{ $item->exists ? 'Edit platform feature' : 'New platform feature' }}">
  <x-admin-form back="{{ route('admin.features.index') }}" action="{{ $item->exists ? route('admin.features.update', $item->id) : route('admin.features.store') }}">
    @if($item->exists)@method('PUT')@endif
    <div class="form-cols-3">
      <div class="field">
        <label for="type">Card type</label>
        <select id="type" name="type">
          @foreach(\App\Models\PlatformFeature::TYPES as $value => $text)
            <option value="{{ $value }}" {{ old('type', $item->type) === $value ? 'selected' : '' }}>{{ $text }}</option>
          @endforeach
        </select>
        <span class="hint">Lead = USP pillar, Feature = second pillar, Pair = small prep card (pairs render side by side).</span>
      </div>
      <div class="field">
        <label for="pip">Pip label</label>
        <input id="pip" type="text" name="pip" value="{{ old('pip', $item->pip) }}" placeholder="The USP / Unique">
      </div>
      <div class="field">
        <label for="tag">Tag text</label>
        <input id="tag" type="text" name="tag" value="{{ old('tag', $item->tag) }}" placeholder="Settlement engine">
      </div>
    </div>
    <div class="field">
      <label for="title">Title</label>
      <input id="title" type="text" name="title" value="{{ old('title', $item->title) }}" required>
    </div>
    <x-wysiwyg name="description" label="Description" :value="$item->description">
      <span class="hint">Lead paragraph under the title. Rich text (bold, lists, links) supported.</span>
    </x-wysiwyg>
    <div class="field">
      <label for="bullets">Bullets (one per line)</label>
      <textarea id="bullets" name="bullets" rows="4">{{ old('bullets', $item->bullets) }}</textarea>
    </div>
    <div class="form-cols-3">
      <div class="field">
        <label for="visual">Visual</label>
        <select id="visual" name="visual">
          @foreach(\App\Models\PlatformFeature::VISUALS as $value => $text)
            <option value="{{ $value }}" {{ old('visual', $item->visual ?? 'none') === $value ? 'selected' : '' }}>{{ $text }}</option>
          @endforeach
        </select>
      </div>
      <div class="field">
        <label for="icon">Icon (pair cards)</label>
        <select id="icon" name="icon">
          @foreach(['' => 'None', 'database' => 'Database', 'document' => 'Document', 'shield' => 'Shield', 'scales' => 'Scales', 'clock' => 'Clock', 'chart' => 'Chart', 'check' => 'Check'] as $value => $text)
            <option value="{{ $value }}" {{ old('icon', $item->icon) === $value ? 'selected' : '' }}>{{ $text }}</option>
          @endforeach
        </select>
      </div>
      <div class="field">
        <label for="kicker">Caption under visual</label>
        <input id="kicker" type="text" name="kicker" value="{{ old('kicker', $item->kicker) }}">
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
