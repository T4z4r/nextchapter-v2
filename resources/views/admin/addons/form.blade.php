<x-admin-shell title="{{ $item->exists ? 'Edit add-on' : 'New add-on' }}">
  <x-admin-form back="{{ route('admin.addons.index') }}" action="{{ $item->exists ? route('admin.addons.update', $item->id) : route('admin.addons.store') }}">
    @if($item->exists)@method('PUT')@endif
    <div class="field">
      <label for="name">Name</label>
      <input id="name" type="text" name="name" value="{{ old('name', $item->name) }}" required>
    </div>
    <x-wysiwyg name="description" label="Description" :value="$item->description"/>
    <div class="form-cols-3">
      <div class="field">
        <label for="price_ind">Price — individual (£)</label>
        <input id="price_ind" type="number" step="1" min="0" name="price_ind" value="{{ old('price_ind', $item->price_ind ?? 0) }}" required>
      </div>
      <div class="field">
        <label for="price_joint">Price — joint (£)</label>
        <input id="price_joint" type="number" step="1" min="0" name="price_joint" value="{{ old('price_joint', $item->price_joint) }}">
        <span class="hint">Leave empty if same as individual.</span>
      </div>
      <div class="field">
        <label for="price_suffix">Price suffix</label>
        <input id="price_suffix" type="text" name="price_suffix" value="{{ old('price_suffix', $item->price_suffix) }}" placeholder="per session / per hour">
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
