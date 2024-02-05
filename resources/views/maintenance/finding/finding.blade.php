@include('utility.prefix')

<div class="py-4">

    <h3 class="mb-3">{{ $title }}</h3>

    {{-- REGISTRY NEW FINDING --}}
    <div class="mb-3">
        <div class="btn-group dropend">
            <button type="button" class="btn btn-primary">
                <a class="text-white nav-link d-inline-block" aria-current="page" href="/finding-registration">
                    <svg class="my-1 me-1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0" />
                    </svg>
                    New finding
                </a>
            </button>
            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false" data-bs-reference="parent">
                <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/finding-install-dismantle">Install / Dismantle</a></li>
            </ul>
        </div>
    </div>


    {{-- FILTER FINDING --}}
    <div class="row mb-3">

        <!-- BY ID -->
        <div class="col pe-1">
            <label for="filter" class="form-label fw-bold">Filter</label>
            <input type="text" class="form-control" id="filter" name="filter" placeholder="Filter by equipment">
        </div>

        <!-- BY STATUS -->
        <div class="col ps-1">
            <label for="filter_status" class="form-label fw-bold">Finding status</label>
            <select id="filter_status" name="filter_status" class="form-select" aria-label="Default select example">
                <option value="All" selected>All</option>
                <option value="Open">Open</option>
                <option value="Close">Close</option>
            </select>
        </div>
        <div class="form-text">The total registered finding is {{ count($findingService->getAll()) }} records.</div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 row-cols-xxl-4 g-3">

        @foreach ($findings as $finding)
        <div class="col">
            <div class="card shadow shadow-md">

                {{-- FINDING IMAGE --}}
                <div>
                    <a href="{{ null != $finding->image ? '/storage/findings/' . $finding->image : '/storage/assets/images/finding-default.png' }}">
                        <img class="card-img-top p-1 rounded" style="height: 300px; object-fit: cover;" src="{{ null != $finding->image ? '/storage/findings/' . $finding->image : '/storage/assets/images/finding-default.png' }}" alt="...">
                    </a>
                </div>

                {{-- FINDING DESCRIPTION --}}
                <div class="card-body">
                    <div class="mb-2">
                        <h5 class="card-title">{{ $finding->area ?? 'Null' }}</h5>
                        <p class="card-text text-truncate" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="{{ (null != $finding->description) ? $finding->description : 'Not set' }}">{{ $finding->description ?? '' }}</p>
                    </div>
                    <div>

                        {{-- FINDING COLUMN --}}
                        @foreach ($findingService->getColumns('findings', ['id', 'area', 'description', 'image', 'updated_at']) as $column)
                        @switch($column)

                        @case('funcloc')
                        <div class="row">
                            <div class="col-6 mb-0 fw-semibold">{{ ucfirst($column) }}</div>
                            <div class="col-6 mb-0 text-truncate" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" data-bs-title="{{ $finding->$column }}">{{ str_replace('FP-01-', '', $finding->$column) }}</div>
                        </div>
                        @break

                        @default
                        <div class="row">
                            <div class="col-6 mb-0 fw-semibold">{{ ucfirst($column == 'created_at' ? 'Date' : $column) }}</div>
                            <div class="col-6 mb-0 text-truncate" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" data-bs-title="{{ (null != $finding->$column) ? $finding->$column : 'Not set' }}">{{ $column == 'created_at' ? $findingService->formatDDMMYY($finding->$column) : $finding->$column }}</div>
                        </div>
                        @endswitch
                        @endforeach

                    </div>

                    {{-- ACTION BUTTON --}}
                    <div class="row mt-3">
                        <div class="col">
                            <a href="#" class="btn btn-outline-primary btn-sm w-100">
                                <svg class="mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                </svg>
                                Update
                            </a>
                        </div>
                        <div class="col">
                            <a href="#" class="btn btn-outline-danger btn-sm w-100">
                                <svg class="mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                </svg>
                                Delete
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>

</div>

@include('utility.script.tooltip')
@include('utility.suffix')