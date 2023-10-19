<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <title>{{ $title }}</title>
</head>

<body>
    <nav class="sticky-top navbar absolute navbar-expand-lg bg-dark text-white zindex-fixed shadow-sm">
        <div class="container">
            <a class="text-white fw-medium me-xl-5 me-lg-3 navbar-brand" href="#">Fajar E-Maintenance</a>
            <button class="bg-white navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="text-primary navbar-toggler-icon"></span>
            </button>
            <div class="mt-4 mt-lg-0 collapse navbar-collapse" id="navbarSupportedContent">
                <form class="d-flex" role="search">
                    <input class="search_input form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </form>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item me-xl-5 me-lg-3">
                        <a class="text-white nav-link" aria-current="page" href="/">Scanner</a>
                    </li>
                    <li class="nav-item me-xl-5 me-lg-3">
                        <a class="text-white nav-link" href="#">Data Record</a>
                    </li>
                    <li class="nav-item me-xl-5 me-lg-3">
                        <a class="text-white nav-link" href="#">Logs</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="text-white nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="text-dark dropdown-item" href="/change-name">Change Name</a></li>
                            <li><a class="text-dark dropdown-item" href="/change-password">Change Password</a></li>
                            <li><a class="text-light bg-danger dropdown-item" href="/logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4 my-5">
        <h3 class="mb-4">CHECKING FORM {{ $emo->id }}</h3>
        @isset($error)
        <div class="alert alert-danger" role="alert">
            {{ $error }}
        </div>
        @endisset

        <!-- MOTOR DETAILS -->
        <div class="accordion mb-4" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="bg-primary text-white accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <strong>CLICK FOR MOTOR DETAILS</strong>
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Function Location</th>
                                    <td>{{ $funcLoc["id"] }}</td>
                                </tr>
                                @foreach ($emoDetail as $key => $value)
                                @if ($key == "id")
                                @continue
                                @endif
                                <tr>
                                    <th scope="row">{{ str_replace("_", " ", ucwords($key)) }}</th>
                                    <td>{{ $value }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <!-- CHECKING -->
        <form action="/checking-form" method="post">
            @csrf
            <div class="mb-3 row">
                <div class="col">
                    <select name="motor_status" id="motor_status" class="form-select mb-3" aria-label="Default select example">
                        <option value="">--Motor Status--</option>
                        <option value="Running">Running</option>
                        <option value="Not Running">Not Running</option>
                    </select>
                    <select name="clean_status" id="clean_status" class="form-select mb-3" aria-label="Default select example">
                        <option value="">--Cleanliness--</option>
                        <option value="Clean">Clean</option>
                        <option value="Dirty">Dirty</option>
                    </select>
                    <select name="nipple_grease" id="nipple_grease" class="form-select mb-3" aria-label="Default select example">
                        <option value="">--Nipple Grease--</option>
                        <option value="Available">Available</option>
                        <option value="Not Available">Not Available</option>
                    </select>
                    <div class="mb-4">
                        <label for="number_of_greasing" class="fw-bold form-label">Number of Greasing</label>
                        <input disabled type="number" onkeypress="return onlynumber(event)" min="0" max="255" step="10" class="form-control" name="number_of_greasing" id="number_of_greasing">
                    </div>

                    <!-- =========== TEMPERATURE =========== -->
                    <div class="row mb-3">
                        <div class="col-md">
                            <img class="img-fluid" src="/images/left-side.jpeg" alt="Left Side">
                        </div>
                        <div class="col-md">
                            <img class="img-fluid" src="/images/front-side.jpeg" alt="Front Side">
                        </div>
                    </div>
                    <div class="mb-1">
                        <label for="temperature_a" class="fw-bold form-label">Temperature A</label>
                        <input type="number" onkeypress="return onlynumber(event)" min="0" max="150" class="form-control temperature" placeholder="°C" name="temperature_a" id="temperature_a">
                    </div>
                    <div class="mb-1">
                        <label for="temperature_b" class="fw-bold form-label">Temperature B</label>
                        <input type="number" onkeypress="return onlynumber(event)" min="0" max="150" class="form-control temperature" placeholder="°C" name="temperature_b" id="temperature_b">
                    </div>
                    <div class="mb-1">
                        <label for="temperature_c" class="fw-bold form-label">Temperature C</label>
                        <input type="number" onkeypress="return onlynumber(event)" min="0" max="150" class="form-control temperature" placeholder="°C" name="temperature_c" id="temperature_c">
                    </div>
                    <div class="mb-4">
                        <label for="temperature_d" class="fw-bold form-label">Temperature D</label>
                        <input type="number" onkeypress="return onlynumber(event)" min="0" max="150" class="form-control temperature" placeholder="°C" name="temperature_d" id="temperature_d">
                    </div>

                    <!-- =========== VIBRATION =========== -->
                    <div class="row mt-3 mb-2">
                        <div class="col-md">
                            <img class="img-fluid mx-auto d-block" src="/images/vibration-iso-10816.jpg" alt="Front Side">
                        </div>
                    </div>
                    <!-- SPACE -->
                    <div class="mb-2">
                        <label for="vibration_value_de" class="fw-bold form-label">Vibration DE</label>
                        <input type="text" maxlength="5" onkeypress="return /[0-9-.]/i.test(event.key)" class="form-control" placeholder="Vibration value (mm/s)" name="vibration_value_de" id="vibration_value_de">
                    </div>
                    <select name="vibration_de" class="form-select mb-3 " aria-label="Default select example">
                        <option value="">--Status--</option>
                        <option value="Normal">Normal</option>
                        <option value="Abormal">Abormal</option>
                    </select>
                    <!-- SPACE -->
                    <div class="mb-2">
                        <label for="vibration_value_nde" class="fw-bold form-label">Vibration NDE</label>
                        <input type="text" maxlength="5" onkeypress="return /[0-9-.]/i.test(event.key)" class="form-control" placeholder="Vibration value (mm/s)" name="vibration_value_nde" id="vibration_value_nde">
                    </div>
                    <select name="vibration_nde" class="form-select mb-4 " aria-label="Default select example">
                        <option value="">--Status--</option>
                        <option value="Normal">Normal</option>
                        <option value="Abormal">Abormal</option>
                    </select>


                    <div class="mb-4">
                        <input class="btn btn-primary" type="submit" value="Submit">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        const nipple_grease = document.getElementById("nipple_grease");
        const number_of_greasing = document.getElementById("number_of_greasing");
        const temperatures = document.getElementsByClassName("temperature");

        nipple_grease.onchange = () => {
            if (nipple_grease.value == "Available") {
                number_of_greasing.removeAttribute("disabled");
            } else {
                number_of_greasing.value = "";
                number_of_greasing.setAttribute("disabled", true);
            }
        }

        number_of_greasing.onchange = () => {
            if (Number(number_of_greasing.value) > 255) {
                number_of_greasing.value = 255
            }
        }

        function onlynumber(evt) {
            let ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }

        for (let i = 0; i < temperatures.length; i++) {
            temperatures[i].onchange = () => {
                if (temperatures[i].value.length > 3) {
                    let value_accepted = temperatures[i].value.substring(0, 3)
                    temperatures[i].value = value_accepted
                }

                if (Number(temperatures[i].value) > 150) {
                    alert("Temperature should not exceed 150°C")
                    temperatures[i].value = ""
                }
            }
        }
    </script>
</body>

</html>