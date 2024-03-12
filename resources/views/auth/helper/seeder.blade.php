@foreach ($users as $user)
@php
$id = $loop->iteration < 10 ? '0' . $loop->iteration : $loop->iteration;
    @endphp

    $user{{ $id }} = new User();</br>
    $user{{ $id }}->nik = '{{ $user->nik }}';</br>
    $user{{ $id }}->password = '{{ $user->password }}';</br>
    $user{{ $id }}->fullname = {{ null == $user->fullname ? 'null' : "'" . ucwords(strtolower($user->fullname)) . "'" }};</br>
    $user{{ $id }}->department = {{ null == $user->department ? 'null' : "'" . $user->department . "'" }};</br>
    $user{{ $id }}->phone_number = {{ null == $user->phone_number ? 'null' : "'" . $user->phone_number . "'" }};</br>
    $user{{ $id }}->created_at = Carbon::now();</br>
    $user{{ $id }}->updated_at = null;</br>
    $user{{ $id }}->save();</br>
    <br>

    @endforeach