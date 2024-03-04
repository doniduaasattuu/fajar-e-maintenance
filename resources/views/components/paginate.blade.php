@props(['paginate'])

<nav aria-label="Page navigation example">
    <ul class="pagination pagination-sm mb-4">
        <li class="page-item {{ $paginate->previousPageUrl() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $paginate->previousPageUrl() }}" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>

        @for ($i = 1; $i < $paginate->lastPage() + 1; $i++)
            <li class="page-item {{ $paginate->currentPage() == $i ? 'active' : '' }}"><a class="page-link" href="{{ $paginate->url($i) }}">{{ $i }}</a>
            </li>
            @endfor

            <li class="page-item {{ $paginate->nextPageUrl() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $paginate->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
    </ul>
</nav>