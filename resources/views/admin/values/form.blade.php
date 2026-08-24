<x-admin-shell title="{{ $item->exists ? 'Edit value card' : 'New value card' }}">
  <x-admin-form back="{{ route('admin.values.index') }}" action="{{ $item->exists ? route('admin.values.update', $item->id) : route('admin.values.store') }}">
    @if($item->exists)@method('PUT')@endif
    <div class="form-cols">
      <div class="field">
        <label for="title">Title</label>
        <input id="title" type="text" name="title" value="{{ old('title', $item->title) }}" required>
      </div>
      <div class="field">
        <label for="icon">Icon</label>
        <select id="icon" name="icon">
          @foreach(['' => 'None', 'shield' => 'Shield', 'scales' => 'Scales', 'clock' => 'Clock', 'chart' => 'Chart', 'database' => 'Database', 'document' => 'Document', 'check' => 'Check'] as $value => $text)
            <option value="{{ $value }}" {{ old('icon', $item->icon) === $value ? 'selected' : '' }}>{{ $text }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <x-wysiwyg name="description" label="Description" :value="$item->description"/>
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
