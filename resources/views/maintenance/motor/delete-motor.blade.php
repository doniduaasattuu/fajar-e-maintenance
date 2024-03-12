@include('utility.prefix')
<div class="py-4">
    <h3 class="mb-3">{{ $title }}</h3>

    {{-- REGISTRY NEW MOTOR --}}
    <div class="mb-3">
        <div class="btn-group dropend">
            <button type="button" class="btn btn-primary">
                <a class="text-white nav-link d-inline-block" aria-current="page" href="/motor-registration">
                    <svg class="my-1 me-1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0" />
                    </svg>
                    New motor
                </a>
            </button>
            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false" data-bs-reference="parent">
                <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/motor-install-dismantle">Install / Dismantle</a></li>
            </ul>
        </div>
    </div>

    {{-- FILTER MOTOR --}}
    <div class="row mb-3">

        <!-- BY ID -->
        <div class="col pe-1">
            <label for="filter" class="form-label fw-semibold">Filter</label>
            <input value="{{ $filter }}" type="text" class="form-control" id="filter" name="filter" placeholder="Filter by motor or unique id">
        </div>

        <!-- BY STATUS -->
        <div class="col ps-1">
            <label for="filter_status" class="form-label fw-semibold">Motor status</label>
            <select id="filter_status" name="filter_status" class="form-select" aria-label="Default select example">
                <option @selected($filter_status=='All' ) value="All">All</option>
                <option @selected($filter_status=='Installed' ) value="Installed">Installed</option>
                <option @selected($filter_status=='Repaired' ) value="Repaired">Repaired</option>
                <option @selected($filter_status=='Available' ) value="Available">Available</option>
            </select>
        </div>
        <div class="form-text">The total registered motor is {{ count($motorService->getAll()) }} records.</div>
    </div>

    {{-- PAGINATION --}}
    <div class="mb-3">
        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
            <div class="btn-group me-2" role="group" aria-label="First group">
                @for ($i = 1; $i <= $paginate->lastPage(); $i++)
                    <button onclick="return pageClick(<?php echo $i ?>)" type="button" @class(['btn', 'btn-sm' , 'btn-outline-secondary' , ($i==$paginate->currentPage()) ? 'active' : ''])>
                        {{ $i }}
                    </button>
                    @endfor
            </div>
        </div>
        <div class="form-text">The total number displayed is {{ count($paginate->items()) }} motor.</div>
    </div>

    {{-- TABlE MOTOR --}}
    <div class="mb-3">
        <table class="rounded table table-light table-hover mb-0 border border-1 shadow-sm table-responsive-md">
            <thead>
                <tr>
                    @foreach ($motorService->getColumns('motors', ['description','material_number','qr_code_link','created_at',]) as $column)

                    <th style="line-height: 30px;" class="{{ $column }}" scope="col">{{ $column == 'id' ? 'Motor' : ucfirst(str_replace("_", " ", $column)) }}</th>

                    @endforeach

                    <!-- DETAILS -->
                    <th style="line-height: 30px; width: 50px;" scope="col">Details</th>

                    <!-- EDIT -->
                    <th style="line-height: 30px; width: 40px" scope="col">Edit</th>
                </tr>
            </thead>
            <tbody>
                <!-- MOTOR -->
                @foreach ($paginate->items() as $motor)

                <!-- CHECK IF FILTER MATCH WITH ID -->
                @if (preg_match("/$filter/i", $motor->id))
                <tr class="table_row d-none">
                    @else
                <tr class="table_row">
                    @endif

                    @foreach ($motorService->getColumns('motors', ['description', 'material_number', 'qr_code_link', 'created_at',]) as $column)

                    @switch($column)
                    @case('id')
                    <td class="motor_id text-break {{ $column }}" scope="row" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="{{ $motor->funcloc != null ? $motor->funcloc : $motor->status }}">{{ $motor->$column }}</td>
                    @break

                    @case('unique_id')
                    <td class="text-break motor_unique {{ $column }}" scope="row">{{ $motor->$column }}</td>
                    @break

                    @default
                    <td class="text-break {{ $column == 'status' ? 'motor_status' : $column }}" scope="row">{{ $motor->$column }}</td>
                    @endswitch

                    @endforeach

                    <!-- DETAILS -->
                    <td class="text-center text-danger" style="width: 50px" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Motor details">
                        <a href="/motor-details/{{ $motor->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="grey" class="bi bi-info-square-fill" viewBox="0 0 16 16">
                                <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm8.93 4.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                            </svg>
                        </a>
                    </td>

                    <!-- EDIT -->
                    <td class="text-center" style="width: 40px">
                        <a href="/motor-edit/{{ $motor->id }}">
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


@include('utility.script.tooltip')
@include('utility.script.hidecolumn')
<script>
    function doHideColumnOnPhone() {
        if (window.innerWidth < 576) {
            hideColumnOnPhone('add', 'funcloc');
            hideColumnOnPhone('add', 'sort_field');
            hideColumnOnPhone('add', 'unique_id');
            hideColumnOnPhone('add', 'updated_at');
        } else if (window.innerWidth >= 576 && window.innerWidth < 992) {
            hideColumnOnPhone('remove', 'funcloc');
            hideColumnOnPhone('add', 'sort_field');
            hideColumnOnPhone('add', 'unique_id');
            hideColumnOnPhone('add', 'updated_at');
        } else if (window.innerWidth >= 992 && window.innerWidth < 1200) {
            hideColumnOnPhone('remove', 'funcloc');
            hideColumnOnPhone('remove', 'sort_field');
            hideColumnOnPhone('remove', 'unique_id');
            hideColumnOnPhone('add', 'updated_at');
        } else if (window.innerWidth >= 1200) {
            hideColumnOnPhone('remove', 'funcloc');
            hideColumnOnPhone('remove', 'sort_field');
            hideColumnOnPhone('remove', 'unique_id');
            hideColumnOnPhone('remove', 'updated_at');
        }
    }

    window.onresize = doHideColumnOnPhone;

    // FILTER BY MOTOR ID
    let table_rows = document.getElementsByClassName('table_row');
    let filter = document.getElementById('filter');
    let motors_id = document.getElementsByClassName('motor_id');
    let filter_status = document.getElementById('filter_status');
    let statuses = document.getElementsByClassName('motor_status');
    let unique_ids = document.getElementsByClassName('motor_unique');

    motorsText = [];
    for (id of motors_id) {
        motorsText.push(id.textContent);
    }

    uniqueIdsText = [];
    for (id of unique_ids) {
        uniqueIdsText.push(id.textContent);
    }

    function resetFilter(table_rows) {
        for (let i = 0; i < table_rows.length; i++) {
            table_rows[i].classList.remove("d-none");
        }
    }

    function doFilterById() {

        filter.value = filter.value.toUpperCase();

        if (filter.value.trim().length > 0) {
            resetFilter(table_rows);

            for (let i = 0; i < motorsText.length; i++) {
                if (!motorsText[i].match(filter.value.trim().toUpperCase()) && !uniqueIdsText[i].match(filter.value.trim().toUpperCase())) {
                    table_rows[i].classList.add("d-none");
                }
            }
        } else {
            resetFilter(table_rows);
        }
    }

    filter.oninput = () => {
        doFilterById();
        doFilterByMotorStatus();
    }

    // FILTER BY MOTOR STATUS
    motorStatusText = [];
    for (id of statuses) {
        motorStatusText.push(id.textContent);
    }

    function filterByMotorStatus(status) {
        if (status != "All") {
            for (let i = 0; i < motorStatusText.length; i++) {
                if (!motorStatusText[i].match(status)) {
                    table_rows[i].classList.add("d-none");
                }
            }
        }
    }

    function doFilterByMotorStatus() {
        if (filter_status.value == 'Installed') {
            doFilterById();
            filterByMotorStatus(filter_status.value)
        } else if (filter_status.value == 'Repaired') {
            doFilterById();
            filterByMotorStatus(filter_status.value)
        } else if (filter_status.value == 'Available') {
            doFilterById();
            filterByMotorStatus(filter_status.value)
        } else {
            doFilterById();
        }
    }

    filter_status.onchange = () => {
        doFilterByMotorStatus()
    }

    // WINDOW
    window.onload = () => {
        doFilterById();
        doFilterByMotorStatus()
        doHideColumnOnPhone()
    }
</script>
<script>
    function pageClick(page) {
        window.location = '/motors' + '/' + page + '/' + filter_status.value + '/' + filter.value;
    }
</script>
@include('utility.suffix')