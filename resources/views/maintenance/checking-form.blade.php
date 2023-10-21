<!DOCTYPE html>
<html lang="en">

@include("utility.head")

<body>
    @include("utility.navbar")

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
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                        </svg> -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-view-list" viewBox="0 0 16 16">
                            <path d="M3 4.5h10a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1H3zM1 2a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 2zm0 12a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 14z" />
                        </svg>
                        <strong class="ms-2">MOTOR DETAILS</strong>
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>Function Location</th>
                                    <td>{{ $funcLoc["id"] }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $emo->status }}</td>
                                </tr>
                                <tr>
                                    <th>Sort field</th>
                                    <td>{{ $emo->sort_field }}</td>
                                </tr>
                                <tr>
                                    <th>Material number</th>
                                    <td>{{ $emo->material_number }}</td>
                                </tr>
                                @foreach ($emoDetail as $key => $value)
                                @if ($key == "id" || $key == "greasing_type" || $key == "greasing_qty_de" || $key == "greasing_qty_nde")
                                @continue
                                @endif
                                <tr>
                                    <th scope="row">{{ str_replace("_", " ", ucwords($key)) }}</th>
                                    <td id="{{ $key }}">{{ $value  }}</td>
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
                    <select name="nipple_grease_input" id="nipple_grease_input" class="form-select mb-3" aria-label="Default select example">
                        <option value="">--Nipple Grease--</option>
                        <option value="Available">Available</option>
                        <option value="Not Available">Not Available</option>
                    </select>
                    <div class="mb-4">
                        <label for="number_of_greasing_input" class="fw-bold form-label">Number of Greasing</label>
                        <input disabled type="number" onkeypress="return onlynumber(event)" min="0" max="255" step="10" class="form-control" name="number_of_greasing_input" id="number_of_greasing_input">
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
                        <input type="number" onkeypress="return onlynumber(event)" min="0" max="150" class="form-control temperature_input" placeholder="°C" name="temperature_a" id="temperature_a">
                    </div>
                    <div class="mb-1">
                        <label for="temperature_b" class="fw-bold form-label">Temperature B</label>
                        <input type="number" onkeypress="return onlynumber(event)" min="0" max="150" class="form-control temperature_input" placeholder="°C" name="temperature_b" id="temperature_b">
                    </div>
                    <div class="mb-1">
                        <label for="temperature_c" class="fw-bold form-label">Temperature C</label>
                        <input type="number" onkeypress="return onlynumber(event)" min="0" max="150" class="form-control temperature_input" placeholder="°C" name="temperature_c" id="temperature_c">
                    </div>
                    <div class="mb-4">
                        <label for="temperature_d" class="fw-bold form-label">Temperature D</label>
                        <input type="number" onkeypress="return onlynumber(event)" min="0" max="150" class="form-control temperature_input" placeholder="°C" name="temperature_d" id="temperature_d">
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
                        <input class="btn btn-primary" type="submit" value="Submit" disabled>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        const nipple_grease_input = document.getElementById("nipple_grease_input");
        const number_of_greasing_input = document.getElementById("number_of_greasing_input");
        const temperatures_input = document.getElementsByClassName("temperature");

        nipple_grease_input.onchange = () => {
            if (nipple_grease_input.value == "Available") {
                number_of_greasing_input.removeAttribute("disabled");
            } else {
                number_of_greasing_input.value = "";
                number_of_greasing_input.setAttribute("disabled", true);
            }
        }

        number_of_greasing_input.onchange = () => {
            if (Number(number_of_greasing_input.value) > 255) {
                number_of_greasing_input.value = 255
            }
        }

        function onlynumber(evt) {
            let ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }

        for (let i = 0; i < temperatures_input.length; i++) {
            temperatures_input[i].onchange = () => {
                if (temperatures_input[i].value.length > 3) {
                    let value_accepted = temperatures_input[i].value.substring(0, 3)
                    temperatures_input[i].value = value_accepted
                }

                if (Number(temperatures_input[i].value) > 150) {
                    alert("Temperature should not exceed 150°C")
                    temperatures_input[i].value = ""
                }
            }
        }

        // ADD UNIT TO MOTOR DETAILS
        function changeUnit(id, unit) {
            if (id.textContent.length > 0) {
                id.textContent = id.textContent + " " + unit;
            } else {
                id.textContent = "";
            }
        }

        const power_unit = document.getElementById("power_unit");
        const power_rate = document.getElementById("power_rate");
        changeUnit(power_rate, power_unit.textContent);

        power_unit.parentElement.style.display = "none";

        const voltage = document.getElementById("voltage");
        changeUnit(voltage, "V");

        const current_nominal = document.getElementById("current_nominal");
        changeUnit(current_nominal, "A");

        const frequency = document.getElementById("frequency");
        changeUnit(frequency, "Hz");

        const pole = document.getElementById("pole");
        changeUnit(pole, "P");

        const rpm = document.getElementById("rpm");
        changeUnit(rpm, "Rpm");

        const shaft_diameter = document.getElementById("shaft_diameter");
        changeUnit(shaft_diameter, "mm");

        const phase_supply = document.getElementById("phase_supply");
        changeUnit(phase_supply, "Phase");

        const length = document.getElementById("length");
        changeUnit(length, "mm");

        const width = document.getElementById("width");
        changeUnit(width, "mm");

        const height = document.getElementById("height");
        changeUnit(height, "mm");

        const weight = document.getElementById("weight");
        changeUnit(weight, "Kg");
    </script>
</body>

</html>