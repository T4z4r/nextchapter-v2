<x-admin-shell title="{{ $item->exists ? 'Edit package' : 'New package' }}">
  <x-admin-form back="{{ route('admin.plans.index') }}" action="{{ $item->exists ? route('admin.plans.update', $item->id) : route('admin.plans.store') }}">
    @if($item->exists)@method('PUT')@endif
    <div class="form-cols">
      <div class="field">
        <label for="tier_label">Tier label</label>
        <input id="tier_label" type="text" name="tier_label" value="{{ old('tier_label', $item->tier_label) }}" required placeholder="Tier 2 · Standard">
      </div>
      <div class="field">
        <label for="name">Package name</label>
        <input id="name" type="text" name="name" value="{{ old('name', $item->name) }}" required>
      </div>
    </div>
    <div class="form-cols">
      <div class="field">
        <label for="slug">Slug (used by checkout buttons)</label>
        <input id="slug" type="text" name="slug" value="{{ old('slug', $item->slug) }}" required pattern="[a-z0-9-]+">
        <span class="hint">Lowercase letters, numbers and hyphens only.</span>
      </div>
      <div class="field">
        <label for="duration_label">Duration label</label>
        <input id="duration_label" type="text" name="duration_label" value="{{ old('duration_label', $item->duration_label) }}" placeholder="Up to 6 months">
      </div>
    </div>
    <div class="form-cols-3">
      <div class="field">
        <label for="price_ind">Price — individual (£)</label>
        <input id="price_ind" type="number" step="1" min="0" name="price_ind" value="{{ old('price_ind', $item->price_ind ?? 0) }}" required>
      </div>
      <div class="field">
        <label for="price_joint">Price — joint (£)</label>
        <input id="price_joint" type="number" step="1" min="0" name="price_joint" value="{{ old('price_joint', $item->price_joint ?? 0) }}" required>
      </div>
      <div class="field">
        <label for="cta_label">Button label</label>
        <input id="cta_label" type="text" name="cta_label" value="{{ old('cta_label', $item->cta_label ?? 'Choose') }}" required>
      </div>
    </div>
    <div class="form-cols">
      <div class="field">
        <label for="sub_ind">Subtitle — individual</label>
        <textarea id="sub_ind" name="sub_ind" rows="2">{{ old('sub_ind', $item->sub_ind) }}</textarea>
      </div>
      <div class="field">
        <label for="sub_joint">Subtitle — joint</label>
        <textarea id="sub_joint" name="sub_joint" rows="2">{{ old('sub_joint', $item->sub_joint) }}</textarea>
      </div>
    </div>
    <div class="field">
      <label for="features">Feature list (one per line)</label>
      <textarea id="features" name="features" rows="6">{{ old('features', $item->features) }}</textarea>
      <span class="hint">If a line differs between individual/joint, write “individual text|joint text” separated by a pipe.</span>
    </div>
    <div class="form-cols">
      <div class="field">
        <label for="badge">Badge text (e.g. Most popular)</label>
        <input id="badge" type="text" name="badge" value="{{ old('badge', $item->badge) }}">
      </div>
      <div>
        <div class="check-row">
          <input id="featured" type="checkbox" name="featured" value="1" {{ old('featured', $item->featured ?? false) ? 'checked' : '' }}>
          <label for="featured">Featured card (highlighted border)</label>
        </div>
        <div class="check-row">
          <input id="is_active" type="checkbox" name="is_active" value="1" {{ old('is_active', $item->is_active ?? true) ? 'checked' : '' }}>
          <label for="is_active">Visible on site</label>
        </div>
      </div>
    </div>
    <div class="field" style="max-width:220px">
      <label for="sort">Sort order</label>
      <input id="sort" type="number" name="sort" value="{{ old('sort', $item->sort ?? 0) }}" min="0">
    </div>
  </x-admin-form>
</x-admin-shell>
