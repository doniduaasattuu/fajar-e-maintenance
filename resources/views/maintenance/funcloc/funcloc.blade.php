@include('utility.prefix')
<div class="py-4">
    <h3 class="mb-3">{{ $title }}</h3>

    <!-- REGISTRY NEW FUNCLOC -->
    <!-- <div class="mb-3">
        <a class="text-dark nav-link d-inline-block" aria-current="page" href="/funcloc-registration">
            <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="grey" class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0" />
            </svg>
            New funcloc</a>
    </div> -->

    <!-- REGISTRY NEW FUNCLOC -->
    <div class="mb-3">
        <div class="btn-group">
            <button type="button" class="btn btn-primary">
                <a class="text-white nav-link d-inline-block" aria-current="page" href="/funcloc-registration">
                    <svg class="my-1 me-1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0" />
                    </svg>
                    New funcloc
                </a>
            </button>
        </div>
    </div>

    <!-- FILTER FUNCLOC -->
    <div class="mb-3">
        <label for="filter" class="form-label fw-semibold">Filter</label>
        <input type="text" class="form-control" id="filter" name="filter" placeholder="Filter by funcloc">
        <div class="form-text">The total registered funcloc is {{ count($funclocService->getAll()) }} records.</div>
    </div>

    <!-- TABlE FUNCLOC -->
    <div class="mb-3">
        <table class="rounded table table-light table-hover mb-0 border border-1 shadow-sm">
            <thead>
                <tr>
                    @foreach ($funclocService->getTableColumns() as $column)
                    @if ($column == 'created_at')
                    @continue
                    @else
                    <th style="line-height: 30px;" class="{{ $column }}" scope="col">{{ $column == 'id' ? 'Funcloc' : ucfirst(str_replace("_", " ", $column)) }}</th>
                    @endif
                    @endforeach

                    <!-- EDIT -->
                    <th style="line-height: 30px; width: 30px" scope="col">Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($funclocService->getAll() as $funcloc)
                <tr class="table_row">
                    @foreach ($funclocService->getTableColumns() as $column)
                    @if ($column == 'created_at')
                    @continue
                    @elseif ($column == 'id')
                    <!-- ADD TOOLTIP FOR FUNCLOC ID -->
                    <td class="funcloc_id text-break {{ $column }}" scope="row" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="{{ $funcloc->description }}">{{ $funcloc->$column }}</td>
                    @else
                    <td class="text-break {{ $column }}" scope="row">{{ $funcloc->$column }}</td>
                    @endif
                    @endforeach

                    <!-- EDIT -->
                    <td class="text-center" style="width: 30px">
                        <a href="/funcloc-edit/{{ $funcloc->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                            </svg>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('utility.script.hidecolumn')
<script>
    function doHideColumnOnPhone() {
        if (window.innerWidth < 576) {
            hideColumnOnPhone('add', 'updated_at');
            hideColumnOnPhone('add', 'description');
        } else if (window.innerWidth >= 576 && window.innerWidth < 992) {
            hideColumnOnPhone('remove', 'description');
            hideColumnOnPhone('add', 'updated_at');
        } else if (window.innerWidth >= 992) {
            hideColumnOnPhone('remove', 'updated_at');
        }
    }

    window.onresize = doHideColumnOnPhone;

    // FILTER
    let table_rows = document.getElementsByClassName('table_row');
    let filter = document.getElementById('filter');
    let funclocs_id = document.getElementsByClassName('funcloc_id');

    funclocsText = [];
    for (id of funclocs_id) {
        funclocsText.push(id.textContent);
    }

    function resetFilter(table_rows) {
        for (let i = 0; i < table_rows.length; i++) {
            table_rows[i].classList.remove("d-none");
        }
    }

    function doFilter() {
        filter.value = filter.value.toUpperCase();

        if (filter.value.trim().length > 0) {
            resetFilter(table_rows);

            for (let i = 0; i < funclocsText.length; i++) {
                if (!funclocsText[i].match(filter.value.trim().toUpperCase())) {
                    table_rows[i].classList.add("d-none");
                }
            }
        } else {
            resetFilter(table_rows);
        }
    }

    filter.oninput = () => {
        doFilter();
    }

    window.onload = () => {
        doFilter();
        doHideColumnOnPhone()
    }
</script>
@include('utility.script.tooltip')
@include('utility.suffix')