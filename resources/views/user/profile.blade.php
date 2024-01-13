@include('utility.prefix')

<div class="py-4">
    <div class="mb-4">
        <h3 class="mb-3">{{ $title }}</h3>
        <table class="rounded table mb-0 border border-1 shadow-sm">
            <tbody>
                @foreach ($userService->getTableColumns() as $column)

                @if ($column == 'password')
                @continue
                @else
                <tr class="table-light">
                    @if ($column == 'nik')
                    <td style="line-height:30px" class="fw-semibold" scope="col">{{ strtoupper(str_replace('_', ' ', ucwords($column))) }}</td>
                    @else
                    <td style="line-height:30px" class="fw-semibold" scope="col">{{ str_replace('_', ' ', ucwords($column)) }}</td>
                    @endif
                    <td style="line-height:30px" scope="col">{{ $userService->user(session('nik'))->$column }}</td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mb-4">
        <h3 class="mb-3">Update profile</h3>

        @include('utility.alert')

        <form action="/update-profile" method="post">
            @csrf

            <!-- NIK -->
            <div class="mb-3">
                <label for="nik" class="form-label fw-semibold">NIK</label>
                <input readonly value="{{ $userService->user(session('nik'))->nik }}" id="nik" name="nik" type="text" onkeypress="return onlynumber(event)" maxlength="8" class="form-control" aria-describedby="nik">
                @error('nik')
                <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- FULLNAME -->
            <div class="mb-3">
                <label for="fullname" class="form-label fw-semibold">Full name</label>
                <input value="{{ $userService->user(session('nik'))->fullname }}" id="fullname" name="fullname" maxlength="150" type="text" class="form-control">
                @error('fullname')
                <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- DEPARTMENT -->
            <div class="mb-3">
                <label for="department" class="form-label fw-semibold">Department</label>
                <select name="department" id="department" class="form-select" aria-label="Default select example">
                    @foreach ($userService->departments() as $department)
                    @if ($userService->user(session('nik'))->department == $department)
                    <option selected value="{{ $department }}">{{ $department }}</option>
                    @else
                    <option value="{{ $department }}">{{ $department }}</option>
                    @endif
                    @endforeach
                </select>
                @error('department')
                <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- PHONE NUMBER -->
            <div class="mb-3">
                <label for="phone_number" class="form-label fw-semibold">Phone number</label>
                <input value="{{ $userService->user(session('nik'))->phone_number }}" id="phone_number" name="phone_number" onkeypress="return onlynumber(event)" maxlength="13" class="form-control" aria-describedby="phone_number">
                @error('phone_number')
                <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- PASSWORD -->
            <div class="mb-3">
                <label for="new_password" class="form-label fw-semibold">New password</label>
                <input id="new_password" name="new_password" type="password" class="form-control">
                @error('new_password')
                <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- NEW PASSWORD CONFIRMATION -->
            <div class="mb-3">
                <label for="new_password_confirmation" class="form-label fw-semibold">New password confirmation</label>
                <input id="new_password_confirmation" name="new_password_confirmation" type="password" class="form-control">
                @error('new_password_confirmation')
                <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>
</div>

@include('utility.suffix')