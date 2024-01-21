@include('utility.prefix')

@php
$columns = $userService->getColumns('users', ['password'])
@endphp

<div class="py-4">
    <div class="mb-4">
        <h3 class="mb-3">{{ $title }}</h3>
        <table class="rounded table mb-0 border border-1 shadow-sm">
            <thead>
                <tr>
                    @foreach ($columns as $column)
                    <th>{{ str_replace('_', ' ', ucfirst($column)) }}</th>
                    @endforeach

                    <!-- EDIT -->
                    <th class="text-center" style="width: 40px">
                        Delete
                    </th>
                    <!-- EDIT -->

                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    @foreach ($columns as $column)
                    @if ($column == 'password')
                    <td>{{ str_replace('n', '#', str_replace('o', '*', str_replace('e', '*', str_replace('u', '*', str_replace('u', '*', str_replace('i', '*', str_replace('a', '*', str_rot13(str_shuffle($user->$column))))))))) }}</td>
                    @else
                    <td>{{ $user->$column }}</td>
                    @endif
                    @endforeach

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
</div>

@include('utility.suffix')