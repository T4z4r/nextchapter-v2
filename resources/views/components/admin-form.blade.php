@props(['back' => null])
<form method="POST" {{ $attributes }}>
  @csrf
  <div class="card">
    {{ $slot }}
    <div style="display:flex;gap:10px;margin-top:8px">
      <button type="submit" class="btn btn-primary">Save</button>
      @if($back)<a href="{{ $back }}" class="btn btn-ghost">Cancel</a>@endif
    </div>
  </div>
</form>
