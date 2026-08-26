@props(['name', 'accept' => null, 'label' => 'Drag & drop a file here', 'hint' => null])
<div class="dropzone" data-dropzone data-target="{{ $name }}" tabindex="0" role="button"
     aria-label="{{ $label }} — click to browse or drop a file">
  <input id="{{ $name }}" type="file" name="{{ $name }}" class="dz-input"
         @if($accept)accept="{{ $accept }}"@endif>
  <div class="dz-hint">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
      <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
    </svg>
    <span class="dz-title">{{ $label }}</span>
    <span class="dz-sub">or click to browse your files</span>
    @if($hint)<span class="dz-accept">{{ $hint }}</span>@endif
  </div>
  <div class="dz-file" hidden></div>
</div>
