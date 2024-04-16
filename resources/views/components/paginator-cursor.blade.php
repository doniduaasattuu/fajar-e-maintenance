@props(['paginator'])

<nav aria-label="Cursor pagination">
    <ul class="pagination pagination-sm mb-4">
        <li>
            <a class="page-link {{ $paginator->onFirstPage() ? 'disabled' : '' }}" href="{{ $paginator->url($paginator->previousCursor()) }}" aria-label="Previous">
                <span aria-hidden="true">Prev</span>
            </a>
        </li>
        <li>
            <a class="page-link {{ $paginator->onLastPage() ? 'disabled' : '' }}" href="{{ $paginator->url($paginator->nextCursor()) }}" aria-label="Next">
                <span aria-hidden="true">Next</span>
            </a>
        </li>
    </ul>
</nav>