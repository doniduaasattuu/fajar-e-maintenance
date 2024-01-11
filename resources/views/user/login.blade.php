<!DOCTYPE html>
<html lang="en">
@include('utility.head')
@include('utility.script.onlynumber')

<body>
    <div class="container d-flex vh-100">
        <div class="my-auto align-items-center mx-auto justify-content-center" style="min-width: 300px;">

            @include('utility.alert')

            <h2 class="mb-4">{{ $title }}</h2>
            <form action="login" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="NIK" class="form-label -mb-5">NIK</label>
                    <input type="text" onkeypress="return onlynumber(event)" maxlength="8" id="NIK" name="NIK" class="form-control" aria-describedby="NIK">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label -mb-5">Password</label>
                    <input id="password" name="password" type="password" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Sign In</button>
                <div id="emailHelp" class="form-text">Don&#039;t have an account ?, Register <a class="text-decoration-none" href="/registration">here</a></div>
            </form>
        </div>
        @include('utility.suffix')