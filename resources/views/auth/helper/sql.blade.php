INSERT INTO `users` (`nik`, `password`, `fullname`, `department`, `phone_number`) VALUES </br>

@foreach ($users as $user)
@php
$id = $loop->iteration < 10 ? '0' . $loop->iteration : $loop->iteration;
    @endphp

    ('{{ $user->nik }}', '@Fajarpaper123', '{{ $user->fullname }}', 'EI1', '12345678910'), </br>

    @endforeach