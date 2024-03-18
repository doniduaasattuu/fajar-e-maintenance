<x-app-layout>

    @php
    $skipped = ['password', 'remember_token', 'created_at', 'updated_at'];
    @endphp

    @inject('utility', 'App\Services\Utility')

    @if (Auth::user()->isSuperAdmin())
    <x-modal-confirm></x-modal-confirm>
    @endif

    <section class="mb-4">
        <x-h3>{{ $title }}</x-h3>

        {{-- FILTERING --}}
        <div class="row mb-3">
            {{-- FILTER SEARCH --}}
            <div class="col pe-1">
                <x-input-label for="search" :value="__('Search')" />
                <x-input-text id="search" type="text" name="search" placeholder="NIK or fullname"></x-input-text>
            </div>
            {{-- BY DEPT --}}
            <div class="col ps-1">
                <x-input-label for="dept" :value="__('Dept')" />
                <x-input-select id="dept" name="dept" :options="$utility::getEnumValue('user', 'department')" :choose="''"></x-input-select>
            </div>
            <x-footer-header-table :paginator='$paginator' />
        </div>
    </section>

    {{-- USER DATA --}}
    <section class="mb-4 overflow-x-auto">
        {{-- TABLE --}}
        <table class="rounded table table-hover mb-0 border border-1 shadow-sm table-responsive-md" style="min-width: 1200px;">
            <thead>
                <tr>
                    @foreach ($utility::getColumns('users', $skipped) as $column)
                    <th style="line-height: 30px">{{ $column == 'nik' ? strtoupper($column) : ucfirst(str_replace('_' , ' ', $column)) }}</th>
                    @endforeach

                    {{-- EDIT AND DELETE USER --}}
                    @if (Auth::user()->isSuperAdmin())
                    <th style="width: 50px;">Admin</th>
                    <th style="width: 50px;">Super</th>
                    <th style="width: 50px;">Reset</th>
                    <th style="width: 50px;">Edit</th>
                    <th style="width: 50px;">Delete</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($paginator->items() as $user)
                <tr class="table-row">
                    @foreach ($utility::getColumns('users', $skipped) as $column)
                    <td>{{ $user->$column }}</td>
                    @endforeach

                    @if (Auth::user()->isSuperAdmin())
                    {{-- ASSIGN/UNASSIGN ADMIN --}}
                    <td class="text-center" style="width: 50px;">
                        <div class="form-check form-switch">
                            <input style="cursor: pointer" class="form-check-input" value="{{ (null != $user->isAdmin()) ? 'true' : 'false' }}" onchange="(this.value == 'true') ? window.location='/role-delete/admin/{{ $user->nik }}' : window.location='/role-assign/admin/{{ $user->nik }}'" type="checkbox" role="switch" @checked($user->isAdmin())>
                        </div>
                    </td>

                    {{-- ASSIGN/UNASSIGN SUPER ADMIN --}}
                    <td class="text-center" style="width: 50px;">
                        <div class="form-check form-switch">
                            <input style="cursor: pointer" class="form-check-input" value="{{ (null != $user->isSuperAdmin()) ? 'true' : 'false' }}" onchange="(this.value == 'true') ? window.location='/role-delete/superadmin/{{ $user->nik }}' : window.location='/role-assign/superadmin/{{ $user->nik }}'" type="checkbox" role="switch" @checked($user->isSuperAdmin())>
                        </div>
                    </td>

                    {{-- RESET PASSWORD --}}
                    <td class="text-center" style="width: 50px;">
                        <span data-bs-toggle="modal" data-bs-target="#modal_confirm" onclick="return JS.modalConfirm('/user-reset/{{ $user->nik }}')" style="cursor: pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#0d6efd" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41m-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9" />
                                <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5 5 0 0 0 8 3M3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9z" />
                            </svg>
                        </span>
                    </td>

                    {{-- EDIT USER --}}
                    <td class="text-center" style="width: 40px">
                        <a href="/user-edit/{{ $user->nik }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#0d6efd" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                            </svg>
                        </a>
                    </td>

                    {{-- DELETE USER --}}
                    <td class="text-center" style="width: 50px;">
                        <span data-bs-toggle="modal" data-bs-target="#modal_confirm" onclick="return JS.modalConfirm('/user-delete/{{ $user->nik }}')" style="cursor: pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#dc3545" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                            </svg>
                        </span>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>

    </section>

    {{-- PAGINATION --}}
    @if ($paginator->hasPages())
    <x-paginator :paginator="$paginator"></x-paginator>
    @endif

    <script type="module">
        let search = document.getElementById("search");
        let dept = document.getElementById("dept");

        JS.fillInputFilterFromUrlSearchParams(search, dept)

        function doFilter() {
            JS.filter(search, dept);
        }

        search.oninput = JS.debounce(doFilter, 300);
        dept.oninput = JS.debounce(doFilter, 0);
    </script>

</x-app-layout>