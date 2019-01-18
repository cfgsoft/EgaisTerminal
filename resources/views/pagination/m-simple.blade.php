@if ($paginator->hasPages())
    <ul class="pagination" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled" aria-disabled="true"><span>1 Назад</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">1 Назад</a></li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">Вперед 3</a></li>
        @else
            <li class="disabled" aria-disabled="true"><span>Вперед 3</span></li>
        @endif
    </ul>
@endif
