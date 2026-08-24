<span class="tagn">@if($feature->pip)<span class="pip">{{ $feature->pip }}</span>@endif @if($feature->tag){{ $feature->tag }}@endif</span>
<h3>{{ $feature->title }}</h3>
<div class="rt">{!! $feature->description !!}</div>
@if(trim((string) $feature->bullets) !== '')
<ul>
  @foreach(preg_split('/\r\n|\r|\n/', $feature->bullets) as $bullet)
    @if(trim($bullet) !== '')
      <li><svg viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/></svg> {!! trim($bullet) !!}</li>
    @endif
  @endforeach
</ul>
@endif
