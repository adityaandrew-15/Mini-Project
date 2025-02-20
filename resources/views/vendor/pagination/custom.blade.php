<div class="pagination-wrapper">
    <div class="pagination">
        @if ($paginator->onFirstPage())
            <span class="prev page-numbers disabled">prev</span>
        @else
            <a class="prev page-numbers" href="{{ $paginator->previousPageUrl() }}">prev</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="page-numbers">...</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-numbers current">{{ $page }}</span>
                    @else
                        <a class="page-numbers" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a class="next page-numbers" href="{{ $paginator->nextPageUrl() }}">next</a>
        @else
            <span class="next page-numbers disabled">next</span>
        @endif
    </div>
</div>
