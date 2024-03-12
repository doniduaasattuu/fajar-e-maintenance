@props(['paginator'])

<nav aria-label="Page navigation example">
    <ul class="pagination pagination-sm mb-4">
        <li class="page-item {{ $paginator->previousPageUrl() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>

        @for ($i = 1; $i < $paginator->lastPage() + 1; $i++)
            <li class="page-item {{ $paginator->currentPage() == $i ? 'active' : '' }}"><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
            </li>
            @endfor

            <li class="page-item {{ $paginator->nextPageUrl() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
    </ul>
</nav>