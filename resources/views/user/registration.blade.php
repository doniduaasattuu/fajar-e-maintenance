<!DOCTYPE html>
<html lang="en">
@include('utility.head')

<body>
    <div class="container d-flex vh-100">
        <div class="my-auto align-items-center py-4 mx-auto justify-content-center" style="min-width: 300px;">

            @include('utility.errors')

            <h2 class="mb-4">{{ $title }}</h2>
            <form action="registration" method="POST">
                @csrf

                <!-- NIK -->
                <div class=" mb-3">
                    <label for="nik" class="form-label fw-semibold">NIK</label>
                    <input value="{{ old('nik') }}" id="nik" name="nik" type="text" onkeypress="return onlynumber(event)" maxlength="8" class="form-control" aria-describedby="nik">
                </div>

                <!-- PASSWORD -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input id="password" name="password" type="password" class="form-control">
                </div>

                <!-- FULLNAME -->
                <div class="mb-3">
                    <label for="fullname" class="form-label fw-semibold">Full name</label>
                    <input value="{{ old('fullname') }}" id="fullname" name="fullname" maxlength="150" type="text" class="form-control">
                </div>

                <!-- DEPARTMENT -->
                <div class="mb-3">
                    <label for="department" class="form-label fw-semibold">Department</label>
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
                    <label for="phone_number" class="form-label fw-semibold">Phone number</label>
                    <input value="{{ old('phone_number') }}" id="phone_number" name="phone_number" onkeypress="return onlynumber(event)" maxlength="13" class="form-control" aria-describedby="phone_number">
                </div>

                <!-- REGISTRATION CODE -->
                <div class="mb-3">
                    <label for="registration_code" class="form-label fw-semibold">Registration code</label>
                    <input value="{{ old('registration_code') }}" id="registration_code" name="registration_code" type="text" class="form-control">
                </div>

                <!-- SUBMIT -->
                <button type="submit" class="btn btn-primary mt-2">Sign Up</button>
                <div id="emailHelp" class="form-text">Already have an account ?, Sign in <a class="text-decoration-none" href="/login">here</a></div>
            </form>
        </div>

        @include('utility.script.onlynumber')
        @include('utility.suffix')