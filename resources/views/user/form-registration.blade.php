<form action="{{ $action }}" method="POST">
    @csrf

    <!-- NIK -->
    <div class=" mb-3">
        <label for="nik" class="form-label">NIK</label>
        <input value="{{ old('nik') }}" id="nik" name="nik" type="text" onkeypress="return onlynumber(event)" maxlength="8" class="form-control" aria-describedby="nik">
    </div>

    <!-- PASSWORD -->
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input id="password" name="password" type="password" class="form-control">
    </div>

    <!-- FULLNAME -->
    <div class="mb-3">
        <label for="fullname" class="form-label">Full name</label>
        <input value="{{ old('fullname') }}" id="fullname" name="fullname" maxlength="150" type="text" class="form-control">
    </div>

    <!-- DEPARTMENT -->
    <div class="mb-3">
        <label for="department" class="form-label">Department</label>
        <select name="department" id="department" class="form-select" aria-label="Default select example">
            <option value="">-- Choose --</option>
            @foreach ($userService->departments() as $department)
            @if (old('department') == $department)
            <option selected value="{{ $department }}">{{ $department }}</option>
            @else
            <option value="{{ $department }}">{{ $department }}</option>
            @endif
            @endforeach
        </select>
    </div>

    <!-- PHONE NUMBER -->
    <div class="mb-3">
        <label for="phone_number" class="form-label">Phone number</label>
        <input value="{{ old('phone_number') }}" id="phone_number" name="phone_number" onkeypress="return onlynumber(event)" maxlength="13" class="form-control" aria-describedby="phone_number">
    </div>

    <!-- REGISTRATION CODE -->
    <div class="mb-3">
        <label for="registration_code" class="form-label">Registration code</label>
        @if ($action == '/user-registration')
        <input value="{{ $userService->registrationCode }}" id="registration_code" name="registration_code" type="text" class="form-control">
        @else
        <input value="{{ old('registration_code') }}" id="registration_code" name="registration_code" type="text" class="form-control">
        @endif
    </div>

    <!-- SUBMIT -->
    @if ($action == '/user-registration')
    <button type="submit" class="btn btn-primary mt-2">Register</button>
    @else
    <button type="submit" class="btn btn-primary mt-2">Sign Up</button>
    <div id="emailHelp" class="form-text">Already have an account ?, Sign in <a class="text-decoration-none" href="/login">here</a></div>
    @endif

</form>