<!DOCTYPE html>
<html lang="en">

@include("utility.head")

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
                    <input id="text" name="fullname" type="text" class="form-control" id="fullname">
                </div>
                <div class="mb-3">
                    <label for="department" class="form-label -mb-5">Department</label>
                    <select name="department" id="department" class="form-select" aria-label="Default select example">
                        <option value=""></option>
                        <option value="EI1">EI1</option>
                        <option value="EI2">EI2</option>
                        <option value="EI3">EI3</option>
                        <option value="EI4">EI4</option>
                        <option value="EI5">EI5</option>
                        <option value="EI6">EI6</option>
                        <option value="EI7">EI7</option>
                    </select>
                    <!-- <input id="text" name="department" type="department" class="form-control" id="department"> -->
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label -mb-5">Phone Number</label>
                    <input style="appearance: textField;" id="number" name="phone_number" type="number" class="form-control" id="phone_number">
                </div>

                <button type="submit" class="btn btn-primary">Sign Up</button>
                <div id="emailHelp" class="form-text">Already have an account ?, Sign in <a class="text-decoration-none" href="/login">here</a></div>
            </form>
        </div>

    </div>
</body>

</html>