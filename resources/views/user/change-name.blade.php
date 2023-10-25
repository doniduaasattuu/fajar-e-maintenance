<!DOCTYPE html>
<html lang="en">

@include("utility.head")

<body class="overflow-hidden">


    @include("utility.navbar")

    <div class="container d-flex absolute mt-5 vh-100">
        <div class="my-auto align-items-center position-absolute top-50 start-50 translate-middle" style="min-width: 300px;">

            @isset($error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
            @endisset

            <h2 class="mb-4">{{ $title }}</h2>
            <form action="/change-name" method="POST">
                @csrf
                <div class=" mb-3">
                    <label for="nik" class="form-label -mb-5">Your NIK</label>
                    <input value="{{ session('nik') }}" type="number" style="appearance: textField;" id="nik" name="nik" class="form-control" id="nik" aria-describedby="nikHelp">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label -mb-5">Password</label>
                    <input id="password" name="password" type="password" class="form-control">
                </div>
                <div class=" mb-3">
                    <label for="name" class="form-label -mb-5">New Fullname</label>
                    <input maxlength="100" type="text" id="name" name="name" class="form-control" aria-describedby="emailHelp">
                </div>
                <button type="submit" class="btn btn-primary">Change</button>
                <div id="emailHelp" class="mt-2 form-text">Want to change your password ?, click <a class="text-decoration-none" href="/change-password">here</a></div>
            </form>
        </div>
    </div>
</body>

</html>