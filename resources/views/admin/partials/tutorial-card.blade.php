@php($locked = $locked ?? false)
@php($imageUrl = $imageUrl ?? null)
<div class="tp-card{{ $locked ? ' locked' : '' }}" data-tp-card>
  <div class="tp-thumb">
    @if($imageUrl)<img class="tp-img" src="{{ $imageUrl }}" alt="">@endif
    <div class="pl">
      <svg class="ic-play" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
      <svg class="ic-lock" viewBox="0 0 24 24" fill="none"><rect x="6" y="11" width="12" height="9" rx="1.5"/><path d="M9 11V8a3 3 0 016 0v3" stroke-linecap="round"/></svg>
    </div>
    @if(!empty($duration))<span class="dur">{{ $duration }}</span>@endif
    <span class="after">After purchase</span>
  </div>
  <div class="body">
    <span class="k">TUTORIAL {{ str_pad((string) ($index ?? 1), 2, '0', STR_PAD_LEFT) }}</span>
    <h4>{{ $title }}</h4>
    <div class="rt">{!! $description !!}</div>
  </div>
</div>
