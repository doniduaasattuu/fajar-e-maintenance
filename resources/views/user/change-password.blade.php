<!DOCTYPE html>
<html lang="en">

@include("utility.head")

<style>
</style>

<body>

    @include("utility.navbar")

    <div class="container d-flex absolute mt-5">
        <div class="my-auto align-items-center mx-auto" style="min-width: 300px;">

            @isset($error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
            @endisset

            <h2 class="mb-4">{{ $title }}</h2>
            <form action="/change-password" method="POST">
                @csrf
                <div class=" mb-3">
                    <label for="nik" class="form-label -mb-5">Your NIK</label>
                    <input value="{{ session('nik') }}" type="number" style="appearance: textField;" id="nik" name="nik" class="form-control" id="nik" aria-describedby="nikHelp">
                </div>
                <div class="mb-3">
                    <label for="current_password" class="form-label -mb-5">Current Password</label>
                    <input id="current_password" name="current_password" type="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label -mb-5">New Password</label>
                    <input id="new_password" name="new_password" type="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="confirm_new_password" class="form-label -mb-5">Confirm New Password</label>
                    <input id="confirm_new_password" name="confirm_new_password" type="password" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Change</button>
                <div id="emailHelp" class="mt-2 form-text">Want to change your name ?, click <a class="text-decoration-none" href="/change-name">here</a></div>
            </form>
        </div>
    </div>
</body>

</html>