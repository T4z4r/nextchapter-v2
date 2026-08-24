<x-admin-shell title="{{ $item->exists ? 'Edit FAQ' : 'New FAQ' }}">
  <x-admin-form back="{{ route('admin.faqs.index') }}" action="{{ $item->exists ? route('admin.faqs.update', $item->id) : route('admin.faqs.store') }}">
    @if($item->exists)@method('PUT')@endif
    <div class="field">
      <label for="question">Question</label>
      <input id="question" type="text" name="question" value="{{ old('question', $item->question) }}" required>
    </div>
    <x-wysiwyg name="answer" label="Answer" :value="$item->answer"/>
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
