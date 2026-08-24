@props(['name', 'label' => null, 'value' => null, 'placeholder' => null])
<div class="field wysiwyg" {{ $attributes }}>
  @if($label)<label for="editor-{{ $name }}">{{ $label }}</label>@endif
  <input id="editor-{{ $name }}" type="hidden" name="{{ $name }}" value="{{ old($name, $value) }}">
  <trix-editor input="editor-{{ $name }}" @if($placeholder) placeholder="{{ $placeholder }}" @endif></trix-editor>
  @unless($slot->isEmpty()){{ $slot }}@endunless
</div>
