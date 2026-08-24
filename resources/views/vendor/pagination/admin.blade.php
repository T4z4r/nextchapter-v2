@if($paginator->hasPages())
  <nav class="pagination" aria-label="Pagination">
    @if($paginator->onFirstPage())
      <span>&laquo;</span>
    @else
      <a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a>
    @endif

    @foreach($elements as $element)
      @if(is_string($element))
        <span class="dots">{{ $element }}</span>
      @endif
      @if(is_array($element))
        @foreach($element as $page => $url)
          <span class="{{ $paginator->currentPage() === $page ? 'current' : '' }}">
            @if($paginator->currentPage() === $page)
              {{ $page }}
            @else
              <a href="{{ $url }}">{{ $page }}</a>
            @endif
          </span>
        @endforeach
      @endif
    @endforeach

    @if($paginator->hasMorePages())
      <a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a>
    @else
      <span>&raquo;</span>
    @endif
  </nav>
@endif
