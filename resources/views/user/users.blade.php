@include('utility.prefix')

@php
$columns = $userService->getColumns('users', ['password', 'created_at', 'updated_at', 'department', 'phone_number']);
$role_columns = ['nik', 'role'];
@endphp

<div class="py-4">
    <div class="mb-4">
        <h3 class="mb-3">{{ $title }}</h3>
        <table class="rounded table mb-0 border border-1 shadow-sm">
            <thead>
                <tr>
                    @foreach ($columns as $column)
                    @if ($column == 'nik')
                    <th>{{ strtoupper($column) }}</th>
                    @elseif ($column == 'fullname')
                    <th>Name</th>
                    @elseif ($column == 'department')
                    <th>Dept</th>
                    @elseif ($column == 'phone_number')
                    <th>{{ ucfirst(explode('_', $column)[0]) }}</th>
                    @else
                    <th>{{ str_replace('_', ' ', ucfirst($column)) }}</th>
                    @endif
                    @endforeach

                    <!-- RESET -->
                    <th class="text-center" style="width: 40px">
                        Reset
                    </th>
                    <!-- RESET -->

                    <!-- DELETE -->
                    <th class="text-center" style="width: 40px">
                        Delete
                    </th>
                    <!-- DELETE -->

                </tr>
            </thead>
            <tbody>

                @foreach ($users as $user)
                <tr>
                    @foreach ($columns as $column)
                    @if ($column == 'password')
                    <td>{{ str_replace('n', '#', str_replace('o', '*', str_replace('e', '*', str_replace('u', '*', str_replace('u', '*', str_replace('i', '*', str_replace('a', '*', str_rot13(str_shuffle($user->$column))))))))) }}</td>
                    @elseif ($column == 'fullname')
                    <td style="min-width: 140px;">{{ sizeof(explode(' ', $user->$column)) > 2 ? (explode(' ', $user->$column)[0] . " " . explode(' ', $user->$column)[1] . " " . explode(' ', $user->$column)[2][0]) : $user->$column }}</td>
                    @else
                    <td>{{ $user->$column }}</td>
                    @endif
                    @endforeach

                    <!-- RESET PASSWORD -->
                    <td class=" text-center" style="width: 40px">
                        <a href="/user-reset/{{ $user->nik }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#0d6efd" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41m-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9" />
                                <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5 5 0 0 0 8 3M3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9z" />
                            </svg>
                        </a>
                    </td>
                    <!-- RESET PASSWORD -->

                    <!-- DELETE USER -->
                    <td class="text-center" style="width: 40px">
                        <a href="/user-delete/{{ $user->nik }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#dc3545" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                            </svg>
                        </a>
                    </td>
                    <!-- DELETE USER -->

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mb-3">
        <h3 class="mb-3">Assignation</h3>

        @include('utility.error')
        @include('utility.alert')

        <form action="/user-assignment" method="post">
            @csrf
            <div class="row">
                <div class="pe-1 col-6 col-md-4 mb-3">
                    <div class="input-group">
                        <span class="input-group-text">NIK</span>
                        <select id="nik" name="nik" class="form-select" aria-label="Default select example">
                            <option></option>
                            @foreach ($userService->registeredNiks() as $nik)
                            @if (old('nik') == $nik)
                            <option selected value="{{ $nik }}">{{ $nik }}</option>
                            @else
                            <option value="{{ $nik }}">{{ $nik }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="ps-1 col-6 col-md-4 mb-3">
                    <div class="input-group">
                        <span class="input-group-text">Role</span>
                        <select id="role" name="role" class="form-select" aria-label="Default select example">
                            <option></option>
                            @foreach ($userService->availableRole() as $role)
                            @if (old('role') == $role)
                            <option selected value="{{ $role }}">{{ $role }}</option>
                            @else
                            <option value="{{ $role }}">{{ $role }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <button style="width: 100%;" type="submit" class="btn btn-primary">Assign</button>
                </div>
            </div>
        </form>
    </div>

    <div class="mb-3">
        <h3 class="mb-3">Admin</h3>



    </div>
</div>

@include('utility.suffix')