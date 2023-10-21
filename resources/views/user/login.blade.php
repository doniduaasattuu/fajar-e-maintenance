<!DOCTYPE html>
<html lang="en">

@include("utility.head")

<body>

    @isset($registration_success)
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="bg-light modal-header">
                    <h1 class=" modal-title fs-5" id="exampleModalLabel">Registration Success! ✅</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Your account has been successfully created.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {});
        myModal.show();
    </script>
    @endisset

    <div class="container d-flex vh-100">
        <div class="my-auto align-items-center mx-auto justify-content-center" style="min-width: 300px;">

            @isset($error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
            @endisset

            <h2 class="mb-4">{{ $title }}</h2>
            <form action="login" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="NIK" class="form-label -mb-5">NIK</label>
                    <input style="appearance: textField;" type="number" id="NIK" name="NIK" class="form-control" id="NIK" aria-describedby="NIKHelp">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label -mb-5">Password</label>
                    <input id="password" name="password" type="password" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Sign In</button>
                <div id="emailHelp" class="form-text">Don&#039;t have an account ?, Register <a class="text-decoration-none" href="/registration">here</a></div>
            </form>
        </div>

    </div>
</body>

</html>