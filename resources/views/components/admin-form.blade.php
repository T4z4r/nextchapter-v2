@props(['back' => null, 'submit' => 'Save', 'test' => false, 'testHint' => null])
<form method="POST" {{ $attributes }}>
  @csrf
  <div class="card">
    {{ $slot }}
    <div style="display:flex;gap:10px;margin-top:8px;flex-wrap:wrap">
      <button type="submit" name="action" value="save" class="btn btn-primary">{{ $submit }}</button>
      @if($test)
        <button type="submit" name="action" value="test" class="btn btn-ghost">
          <x-ad-icon name="mail"/>Send test email
        </button>
      @endif
      @if($back)<a href="{{ $back }}" class="btn btn-ghost">Cancel</a>@endif
    </div>
    @if($test && $testHint)
      <p class="hint" style="margin-top:8px">{{ $testHint }}</p>
    @endif
  </div>
</form>