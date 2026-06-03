<div style="display: flex; align-items: center; gap: 4px;">
    @if ($paginator->hasPages())
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <div class="disabled"><span>&lsaquo;</span></div>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev">&lsaquo;</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <div class="disabled"><span>{{ $element }}</span></div>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <div class="active"><span>{{ $page }}</span></div>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next">&rsaquo;</a>
        @else
            <div class="disabled"><span>&rsaquo;</span></div>
        @endif
    @else
        {{-- Fallback when there is only 1 page or 0 records --}}
        <div class="disabled"><span>&lsaquo;</span></div>
        <div class="active"><span>{{ $paginator->currentPage() }}</span></div>
        <div class="disabled"><span>&rsaquo;</span></div>
    @endif
</div>
