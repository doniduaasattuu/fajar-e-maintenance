<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <title>{{ $title }}</title>
</head>

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
                    <input type="text" onkeypress="return /[0-9]/i.test(event.key)" id="NIK" name="NIK" class="form-control" id="NIK" aria-describedby="NIKHelp">
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