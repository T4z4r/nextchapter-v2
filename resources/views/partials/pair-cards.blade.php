@foreach($items as $item)
  <div class="pair">
    <div class="ico">@include('partials.icon', ['name' => $item->icon])</div>
    <span class="tagn">{{ $item->tag }}</span>
    <h3>{{ $item->title }}</h3>
    <div class="rt">{!! $item->description !!}</div>
  </div>
@endforeach
