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
    <div class="container d-flex vh-100">
        <div class="my-auto align-items-center mx-auto justify-content-center" style="min-width: 300px;">

            @isset($error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
            @endisset

            <h2 class="mb-4">{{ $title }}</h2>
            <form action="registration" method="POST">
                @csrf
                <div class=" mb-3">
                    <label for="exampleInputEmail1" class="form-label -mb-5">NIK</label>
                    <input type="text" id="nik" onkeypress="return /[0-9]/i.test(event.key)" name="nik" class="form-control" aria-describedby="nikHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label -mb-5">Password</label>
                    <input id="password" name="password" type="password" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="mb-3">
                    <label for="fullname" class="form-label -mb-5">Full Name</label>
                    <input id="text" name="fullname" type="fullname" class="form-control" id="fullname">
                </div>
                <div class="mb-3">
                    <label for="department" class="form-label -mb-5">Department</label>
                    <input id="text" name="department" type="department" class="form-control" id="department">
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label -mb-5">Phone Number</label>
                    <input id="number" name="phone_number" onkeypress="return /[0-9]/i.test(event.key)" type="phone_number" class="form-control" id="phone_number">
                </div>

                <button type="submit" class="btn btn-primary">Sign Up</button>
                <div id="emailHelp" class="form-text">Already have an account ?, Login <a class="text-decoration-none" href="/login">here</a></div>
            </form>
        </div>

    </div>
</body>

</html>