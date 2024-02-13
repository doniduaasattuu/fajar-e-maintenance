@include('utility.prefix')

@php
$columns = $userService->getColumns('users', ['password', 'created_at', 'updated_at', 'phone_number']);
$role_columns = ['nik', 'role'];
@endphp

<div class="py-4">

    @include('utility.confirmation')

    <div class="mb-4"> <!-- REGISTERED USER -->
        <h3 class="mb-3">{{ $title }}</h3>

        {{-- REGISTRY NEW USER --}}
        <div class="mb-3">
            <button type="button" class="btn btn-primary">
                <a class="text-white nav-link d-inline-block" aria-current="page" href="/user-registration">
                    <svg class="my-1 me-1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0" />
                    </svg>
                    New User
                </a>
            </button>
        </div>

        {{-- FILTER USER --}}
        <div class="row mb-3">

            {{-- BY NAME --}}
            <div class="col pe-1">
                <label for="filter_name" class="form-label fw-semibold">Filter</label>
                <input type="text" class="form-control" id="filter_name" name="filter_name" placeholder="Name">
            </div>

            {{-- BY DEPT --}}
            <div class="col ps-1">
                <label for="filter_department" class="form-label fw-semibold">Dept</label>
                <select id="filter_department" name="filter_department" class="form-select" aria-label="Default select example">
                    <option value="All" selected>All</option>
                    @foreach ($userService->departments() as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-text">The total registered user is {{ count($userService->getAll()) }} people.</div>
        </div>

        <table class="rounded table table-hover mb-0 border border-1 shadow-sm table-responsive-md">
            <thead>
                <tr>
                    @foreach ($columns as $column)
                    @if ($column == 'nik')
                    <th>{{ strtoupper($column) }}</th>
                    @elseif ($column == 'department')
                    <th class="{{ $column }}">Dept</th>
                    @elseif ($column == 'phone_number')
                    <th>{{ ucfirst(explode('_', $column)[0]) }}</th>
                    @else
                    <th class="{{ $column }}">{{ $column == 'fullname' ? 'Name' : str_replace('_', ' ', ucfirst($column)) }}</th>
                    @endif
                    @endforeach

                    <th>DB</th>
                    <th>Admin</th>

                    <!-- RESET -->
                    <th data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" data-bs-title="Reset password" class="text-center" style="width: 50px">
                        Reset
                    </th>
                    <!-- RESET -->

                    <!-- DELETE -->
                    <th data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" data-bs-title="Delete user" class="text-center" style="width: 50px">
                        Delete
                    </th>
                    <!-- DELETE -->

                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr class="table_row">
                    @foreach ($columns as $column)
                    @if ($column == 'password')
                    <td>{{ str_replace('n', '#', str_replace('o', '*', str_replace('e', '*', str_replace('u', '*', str_replace('u', '*', str_replace('i', '*', str_replace('a', '*', str_rot13(str_shuffle($user->$column))))))))) }}</td>
                    @elseif ($column == 'fullname')
                    <td class="{{ $column }} {{ $column . '-filter' }}" style="min-width: 150px;">{{ sizeof(explode(' ', $user->$column)) > 2 ? (explode(' ', $user->$column)[0] . " " . explode(' ', $user->$column)[1] . " " . explode(' ', $user->$column)[2][0]) : $user->$column }}</td>
                    @elseif ($column == 'department')
                    <td class="{{ $column }} {{ $column . '-filter' }}">{{ $user->$column }}</td>
                    @elseif ($column == 'nik')
                    <td data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" data-bs-title="{{ sizeof(explode(' ', $user->fullname)) > 2 ? (explode(' ', $user->fullname)[0] . " " . explode(' ', $user->fullname)[1] . " " . explode(' ', $user->fullname)[2][0])  . ' - ' . $user->department : $user->fullname . ' - ' . $user->department }}">{{ $user->$column }}</td>
                    @else
                    <td class="{{ $column }}">{{ $user->$column }}</td>
                    @endif
                    @endforeach

                    <!-- DB ADMIN -->
                    <td class="text-center" style="width: 50px" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Assign/delete as database administrator">
                        <div class="form-check form-switch">
                            <input style="cursor: pointer" class="form-check-input" value="{{ (null != $user->isDbAdmin()) ? 'true' : 'false' }}" onchange="(this.value == 'true') ? window.location='/role-delete/db_admin/{{ $user->nik }}' : window.location='/role-assign/db_admin/{{ $user->nik }}'" type="checkbox" role="switch" @checked($user->isDbAdmin())>
                        </div>
                    </td>
                    <!-- DB ADMIN -->

                    <!-- ADMIN -->
                    <td class="justify-content-center" style="width: 50px" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Assign/delete as administrator">
                        <div class="mx-auto form-check form-switch">
                            <input style="cursor: pointer" class="form-check-input" value="{{ (null != $user->isAdmin()) ? 'true' : 'false' }}" onchange="(this.value == 'true') ? window.location='/role-delete/admin/{{ $user->nik }}' : window.location='/role-assign/admin/{{ $user->nik }}'" type="checkbox" role="switch" @checked($user->isAdmin())>
                        </div>
                    </td>
                    <!-- ADMIN -->

                    <!-- RESET PASSWORD -->
                    <td data-bs-toggle="modal" data-bs-target="#confirmation_modal" url='/user-reset/{{ $user->nik }}' class="text-center buttonReset" style="width: 50px">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#0d6efd" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                            <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41m-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9" />
                            <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5 5 0 0 0 8 3M3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9z" />
                        </svg>
                    </td>
                    <!-- RESET PASSWORD -->

                    <!-- DELETE USER -->
                    <td data-bs-toggle="modal" data-bs-target="#confirmation_modal" url='/user-delete/{{ $user->nik }}' class="text-center buttonDelete" style="width: 50px">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#dc3545" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                        </svg>
                    </td>
                    <!-- DELETE USER -->

                </tr>
                @endforeach
            </tbody>
        </table>
    </div> <!-- REGISTERED USER -->
</div>

<script>
    let buttonsDelete = document.getElementsByClassName('buttonDelete');
    let buttonsReset = document.getElementsByClassName('buttonReset');

    function doConfirmation(buttons) {
        for (let i = 0; i < buttons.length; i++) {
            buttons[i].style.cursor = 'pointer';
            buttons[i].onclick = () => {
                let confirm_url = buttons[i].getAttribute('url');
                let modal_url = document.getElementById('confirmation_url');
                modal_url.setAttribute('href', confirm_url);
            }
        }
    }

    doConfirmation(buttonsDelete);
    doConfirmation(buttonsReset);

    function doHideColumnOnPhone() {
        if (window.innerWidth < 576) {
            hideColumnOnPhone('add', 'fullname');
            hideColumnOnPhone('add', 'department');
        } else if (window.innerWidth >= 576 && window.innerWidth < 768) {
            hideColumnOnPhone('add', 'department');
            hideColumnOnPhone('remove', 'fullname');
        } else {
            hideColumnOnPhone('remove', 'fullname');
            hideColumnOnPhone('remove', 'department');
        }
    }

    window.onresize = doHideColumnOnPhone;
    window.onload = () => {
        doHideColumnOnPhone();
    }
</script>

<script>
    // FILTER USER
    let table_rows = document.getElementsByClassName('table_row');
    let filter_name = document.getElementById('filter_name');
    let names = document.getElementsByClassName('fullname-filter');
    let filter_department = document.getElementById('filter_department');
    let departments = document.getElementsByClassName('department-filter');

    // FILTER
    function resetFilter(table_rows) {
        for (let i = 0; i < table_rows.length; i++) {
            table_rows[i].classList.remove("d-none");
        }
    }

    // FILTER BY NAME
    namesText = [];
    for (id of names) {
        namesText.push(id.textContent.toUpperCase());
    }

    function filterByName() {

        let filter = filter_name.value.toUpperCase();

        for (let i = 0; i < namesText.length; i++) {
            if (!namesText[i].match(filter.trim().toUpperCase())) {
                table_rows[i].classList.add("d-none");
            }
        }
    }

    function doFilterByName() {
        if (filter_name.value != '' && filter_name.value.length >= 1) {
            resetFilter(table_rows);
            filterByName();
        } else {
            resetFilter(table_rows);
        }
    }

    filter_name.oninput = () => {
        if (filter_department.value != 'All') {
            doFilterByName();
            filterByDepartment();
        } else {
            doFilterByName();
        }
    }

    // FILTER BY DEPT
    departmentsText = [];
    for (id of departments) {
        departmentsText.push(id.textContent.toUpperCase());
    }

    function filterByDepartment() {
        let filter = filter_department.value;

        for (let i = 0; i < departmentsText.length; i++) {
            if (departmentsText[i] != filter) {
                table_rows[i].classList.add("d-none");
            }
        }
    }

    function doFilterByDepartment() {
        if (filter_department.value != 'All') {
            resetFilter(table_rows);
            filterByDepartment();
        } else {
            resetFilter(table_rows);
        }
    }

    filter_department.onchange = () => {
        if (filter_name.value != '' && filter_name.value.length >= 1) {
            doFilterByDepartment();
            filterByName()
        } else {
            doFilterByDepartment();
        }
    }

    // console.log(departmentsText);
</script>
@include('utility.script.hidecolumn')
@include('utility.script.tooltip')
@include('utility.suffix')