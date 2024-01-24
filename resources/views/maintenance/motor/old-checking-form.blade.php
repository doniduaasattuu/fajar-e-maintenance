@include('utility.prefix')

<!-- HEADER  -->
<div class="mb-3">
    <h5 class="text-break lh-sm mb-0">@{{ $motor->sort_field }}</h5>
    <p class="text-break mb-0 text-secondary">@{{ $motor->equipment_description }}</p>
    <p class="text-break lh-sm mb-0 text-secondary">@{{ $motor->funcloc }}</p>
    <p class="text-break lh-sm mb-0 text-secondary">@{{ $motor->id }}</p>
</div>

<!-- TRENDS -->
<form action="/equipment-trends" method="post">
    @csrf
    <input type="hidden" id="sort_field" name="sort_field" value="@{{ $motor->sort_field }}">
    <input type="hidden" id="equipment_id" name="equipment_id" value="@{{ $equipment_id }}">
    <input type="hidden" id="funcloc" name="funcloc" value="@{{ $motor->funcloc }}">
    <button class="btn btn-success fw-bold mb-2 text-white">
        <svg class="mb-1 me-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-graph-up" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M0 0h1v15h15v1H0V0Zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07Z" />
        </svg>
        TRENDS
    </button>
</form>

<!-- MOTOR DETAILS START -->
<div class="accordion mb-4" id="accordionDetails">
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="bg-primary text-white accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-view-list" viewBox="0 0 16 16">
                    <path d="M3 4.5h10a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1H3zM1 2a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 2zm0 12a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 14z" />
                </svg>
                <strong class="ms-2">MOTOR DETAILS</strong>
            </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionDetails">
            <div class="accordion-body">
                <table class="table table-hover">
                    <tbody>

                        <!-- FUNCLOC -->
                        <tr class="d-none" id="emo_function_location">
                            <th>Function Location</th>
                            <td>@{{ $motor->funcloc }}</td>
                        </tr>

                        <!-- SORT FIELD -->
                        <tr class="d-none" id="emo_sort_field">
                            <th>Sort field</th>
                            <td>@{{ $motor->sort_field }}</td>
                        </tr>

                        <!-- STATUS -->
                        <tr>
                            <th>Status</th>
                            <td id="status">@{{ $motor->status }}</td>
                        </tr>

                        <!-- UPDATED AT -->
                        <tr>
                            <th>Updated at</th>
                            <td>@{{ $motor->updated_at }}</td>
                        </tr>

                        <!-- EQUIPMENT DESCRIPTION -->
                        <tr>
                            <th>Equipment Description</th>
                            <td class="text-break">@{{ $motor->equipment_description }}</td>
                        </tr>

                        <!-- MATERIAL NUMBER -->
                        <tr>
                            <th>Material number</th>
                            <td>@{{ $motor->material_number }}</td>
                        </tr>

                        @@foreach ($motor->emoDetails->toArray() as $key => $value)
                        <tr>
                            <th scope="row">@{{ str_replace("_", " ", ucwords($key)) }}</th>
                            <td id="@{{ 'detail_' . $key }}">@{{ $value  }}</td>
                        </tr>
                        @@endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- MOTOR DETAILS END -->

<!-- ========================================= -->
<!-- ========== CHECKING FORM START ========== -->
<!-- ========================================= -->
<form id="myform" action="/checking-form/@{{ $equipment_id }}" method="post">
    @csrf
    <div class="row">
        <div class="col">

            <!-- MOTOR STATUS -->
            <div class="mb-3">
                <label for="motor_status" class="fw-bold form-label">Motor Status *</label>
                <select name="motor_status" id="motor_status" class="form-select" aria-label="Default select example">
                    <option value="">--Motor Status--</option>
                    <option value="Running">Running</option>
                    <option value="Not Running">Not Running</option>
                </select>
            </div>

            <!-- CLEAN STATUS -->
            <div class="mb-3">
                <label for="clean_status" class="fw-bold form-label">Cleanliness *</label>
                <select disabled name="clean_status" id="clean_status" class="form-select required" aria-label="Default select example">
                    <option value="Clean">Clean</option>
                    <option value="Dirty">Dirty</option>
                </select>
            </div>

            <!-- NIPPLE GREASE -->
            <div class="mb-3">
                <label for="nipple_grease" class="fw-bold form-label">Nipple Grease *</label>
                <select disabled name="nipple_grease" id="nipple_grease" class="form-select required" aria-label="Default select example">
                    <option value="Available">Available</option>
                    <option value="Not Available">Not Available</option>
                </select>
            </div>

            <!-- NUMBER OF GREASING -->
            <div class="mb-3">
                <label for="number_of_greasing" class="fw-bold form-label">Number of Greasing</label>
                <input disabled type="number" onkeypress="return onlynumber(event)" min="0" max="255" step="10" class="form-control" name="number_of_greasing" id="number_of_greasing">
            </div>
        </div>

        <!-- ========================================= -->
        <!-- =========== TEMPERATURE START =========== -->
        <!-- ========================================= -->
        <div class="mb-3">
            <div class="row mb-3">

                <!-- IMAGE LEFT SIDE -->
                <div class="col-md">
                    <figure>
                        <img class="img-fluid" src="/storage/assets/images/left-side.jpeg" alt="Left Side">
                        <figcaption class="figure-caption text-center">Left side</figcaption>
                    </figure>
                </div>

                <!-- IMAGE FRONT SIDE -->
                <div class="col-md">
                    <figure>
                        <img class="img-fluid" src="/storage/assets/images/front-side.jpeg" alt="Front Side">
                        <figcaption class="figure-caption text-center">Front side</figcaption>
                    </figure>
                </div>
            </div>

            <!-- IMAGE IEC 60085 -->
            <div class="mb-3">
                <div class="col-md">
                    <figure>
                        <img class="img-fluid mx-auto d-block" src="/storage/assets/images/temp_iso_IEC_60085.png" alt="Temperature">
                        <figcaption class="figure-caption text-center">IEC 60085</figcaption>
                    </figure>
                </div>
            </div>

            <!-- TEMPERATURE DE -->
            <div class="mb-3">
                <label for="temperature_de" class="fw-bold form-label">Temperature DE</label>
                <input disabled type="number" onkeypress="return onlynumber(event)" min="0" max="200" class="form-control temperature unrequired" placeholder="°C" name="temperature_de" id="temperature_de">
            </div>

            <!-- TEMPERATURE BODY -->
            <div class="mb-3">
                <label for="temperature_body" class="fw-bold form-label">Temperature Body</label>
                <input disabled type="number" onkeypress="return onlynumber(event)" min="0" max="200" class="form-control temperature unrequired" placeholder="°C" name="temperature_body" id="temperature_body">
            </div>

            <!-- TEMPERATURE NDE -->
            <div class="mb-3">
                <label for="temperature_nde" class="fw-bold form-label">Temperature NDE</label>
                <input disabled type="number" onkeypress="return onlynumber(event)" min="0" max="200" class="form-control temperature unrequired" placeholder="°C" name="temperature_nde" id="temperature_nde">
            </div>
        </div>
        <!-- ========================================= -->
        <!-- ============ TEMPERATURE END ============ -->
        <!-- ========================================= -->

        <!-- ========================================= -->
        <!-- ============ VIBRATION START ============ -->
        <!-- ========================================= -->
        <div>
            <div class="row">

                <!-- IMAGE VIBRATION SEVERITY TABLE -->
                <div class="col-md">
                    <figure>
                        <img class="img-fluid mx-auto d-block" src="/storage/assets/images/vibration-iso-10816.jpg" alt="Vibration">
                        <figcaption id="figcaption_vibrations" class="figure-caption text-center">Vibration standard</figcaption>
                    </figure>
                </div>

                <!-- IMAGE VIBRATION INSPECTION GUIDE -->
                <div class="col-md">
                    <figure>
                        <img class="img-fluid mx-auto d-block" src="/storage/assets/images/vibration-inspection-guide.png" alt="Vibration inspection guide">
                        <figcaption id="figcaption_vibration" class="figure-caption text-center">Vibration inspection guide</figcaption>
                    </figure>
                </div>
            </div>

            <!-- ========================================= -->
            <!-- ============= VIBRATION DE ============== -->
            <!-- ========================================= -->
            <div class="drive-end">

                <!-- VIBRATION DEV -->
                <div class="mb-3">
                    <div class="mb-2">
                        <label for="vibration_de_vertical_value" class="vibrations_label fw-bold form-label">DEV (Vertical)</label>
                        <input disabled type="number" step="0.01" min="0.00" max="45" onkeypress="return /[0-9-.]/i.test(event.key)" class="form-control vibration_value unrequired" placeholder="Vibration value (mm/s)" name="vibration_de_vertical_value" id="vibration_de_vertical_value">
                    </div>
                    <select disabled id="vibration_de_vertical_desc" name="vibration_de_vertical_desc" class="vibration form-select vibration_description" aria-label="Default select example">
                        <option value="">--Status--</option>
                        <option value="Good">Good</option>
                        <option value="Satisfactory">Satisfactory</option>
                        <option value="Unsatisfactory">Unsatisfactory</option>
                        <option value="Unacceptable">Unacceptable</option>
                    </select>
                </div>

                <!-- VIBRATION DEH -->
                <div class="mb-3">
                    <div class="mb-2">
                        <label for="vibration_de_horizontal_value" class="vibrations_label fw-bold form-label">DEH (Horizontal)</label>
                        <input disabled type="number" step="0.01" min="0.00" max="45" onkeypress="return /[0-9-.]/i.test(event.key)" class="form-control vibration_value unrequired" placeholder="Vibration value (mm/s)" name="vibration_de_horizontal_value" id="vibration_de_horizontal_value">
                    </div>
                    <select id="vibration_de_horizontal_desc" name="vibration_de_horizontal_desc" class="vibration form-select vibration_description bg-success" aria-label="Default select example">
                        <option value="">--Status--</option>
                        <option value="Good">Good</option>
                        <option value="Satisfactory">Satisfactory</option>
                        <option value="Unsatisfactory">Unsatisfactory</option>
                        <option value="Unacceptable">Unacceptable</option>
                    </select>
                </div>

                <!-- VIBRATION DEA -->
                <div class="mb-3">
                    <div class="mb-2">
                        <label for="vibration_de_axial_value" class="vibrations_label fw-bold form-label">DEA (Axial)</label>
                        <input disabled type="number" step="0.01" min="0.00" max="45" onkeypress="return /[0-9-.]/i.test(event.key)" class="form-control vibration_value unrequired" placeholder="Vibration value (mm/s)" name="vibration_de_axial_value" id="vibration_de_axial_value">
                    </div>
                    <select disabled id="vibration_de_axial_desc" name="vibration_de_axial_desc" class="vibration form-select vibration_description" aria-label="Default select example">
                        <option value="">--Status--</option>
                        <option value="Good">Good</option>
                        <option value="Satisfactory">Satisfactory</option>
                        <option value="Unsatisfactory">Unsatisfactory</option>
                        <option value="Unacceptable">Unacceptable</option>
                    </select>
                </div>

                <!-- VIBRATION DE FRAME -->
                <div class="mb-3">
                    <div class="mb-2">
                        <label for="vibration_de_frame_value" class="vibrations_label fw-bold form-label">DE Frame Horizontal (Diagonal from NDE)</label>
                        <input disabled type="number" step="0.01" min="0.00" max="45" onkeypress="return /[0-9-.]/i.test(event.key)" class="form-control vibration_value unrequired" placeholder="Vibration value (mm/s)" name="vibration_de_frame_value" id="vibration_de_frame_value">
                    </div>
                    <select disabled id="vibration_de_frame_desc" name="vibration_de_frame_desc" class="vibration form-select vibration_description" aria-label="Default select example">
                        <option value="">--Status--</option>
                        <option value="Good">Good</option>
                        <option value="Satisfactory">Satisfactory</option>
                        <option value="Unsatisfactory">Unsatisfactory</option>
                        <option value="Unacceptable">Unacceptable</option>
                    </select>
                </div>

                <!-- NOISE DE -->
                <div class="mb-3">
                    <label for="noise_de" class="fw-bold form-label">Noise DE</label>
                    <select disabled name="noise_de" id="noise_de" class="noise form-select unrequired" aria-label="Default select example">
                        <option selected value="Normal">Normal</option>
                        <option value="Abnormal">Abnormal</option>
                    </select>
                </div>

            </div>
            <hr>
            <!-- DRIVE END -->

            <!-- ========================================= -->
            <!-- ============= VIBRATION DE ============== -->
            <!-- ========================================= -->
            <div class="non-drive-end">

                <!-- VIBRATION NDEV -->
                <div class="mb-3">
                    <div class="mb-2">
                        <label for="vibration_nde_vertical_value" class="vibrations_label fw-bold form-label">NDEV (Vertical)</label>
                        <input disabled type="number" step="0.01" min="0.00" max="45" onkeypress="return /[0-9-.]/i.test(event.key)" class="form-control vibration_value unrequired" placeholder="Vibration value (mm/s)" name="vibration_nde_vertical_value" id="vibration_nde_vertical_value">
                    </div>
                    <select disabled id="vibration_nde_vertical_desc" name="vibration_nde_vertical_desc" class="vibration form-select vibration_description" aria-label="Default select example">
                        <option value="">--Status--</option>
                        <option value="Good">Good</option>
                        <option value="Satisfactory">Satisfactory</option>
                        <option value="Unsatisfactory">Unsatisfactory</option>
                        <option value="Unacceptable">Unacceptable</option>
                    </select>
                </div>

                <!-- VIBRATION NDEH -->
                <div class="mb-3">
                    <div class="mb-2">
                        <label for="vibration_nde_horizontal_value" class="vibrations_label fw-bold form-label">NDEH (Horizontal)</label>
                        <input disabled type="number" step="0.01" min="0.00" max="45" onkeypress="return /[0-9-.]/i.test(event.key)" class="form-control vibration_value unrequired" placeholder="Vibration value (mm/s)" name="vibration_nde_horizontal_value" id="vibration_nde_horizontal_value">
                    </div>
                    <select disabled id="vibration_nde_horizontal_desc" name="vibration_nde_horizontal_desc" class="vibration form-select vibration_description" aria-label="Default select example">
                        <option value="">--Status--</option>
                        <option value="Good">Good</option>
                        <option value="Satisfactory">Satisfactory</option>
                        <option value="Unsatisfactory">Unsatisfactory</option>
                        <option value="Unacceptable">Unacceptable</option>
                    </select>
                </div>

                <!-- VIBRATION NDE FRAME -->
                <div class="mb-3">
                    <div class="mb-2">
                        <label for="vibration_nde_frame_value" class="vibrations_label fw-bold form-label">NDE Frame Horizontal (Diagonal from DE)</label>
                        <input disabled type="number" step="0.01" min="0.00" max="45" onkeypress="return /[0-9-.]/i.test(event.key)" class="form-control vibration_value unrequired" placeholder="Vibration value (mm/s)" name="vibration_nde_frame_value" id="vibration_nde_frame_value">
                    </div>
                    <select disabled id="vibration_nde_frame_desc" name="vibration_nde_frame_desc" class="vibration form-select vibration_description" aria-label="Default select example">
                        <option value="">--Status--</option>
                        <option value="Good">Good</option>
                        <option value="Satisfactory">Satisfactory</option>
                        <option value="Unsatisfactory">Unsatisfactory</option>
                        <option value="Unacceptable">Unacceptable</option>
                    </select>
                </div>

                <!-- NOISE NDE -->
                <div class="mb-3">
                    <label for="noise_nde" class="fw-bold form-label">Noise NDE</label>
                    <select disabled name="noise_nde" id="noise_nde" class="noise form-select unrequired" aria-label="Default select example">
                        <option selected value="Normal">Normal</option>
                        <option value="Abnormal">Abnormal</option>
                    </select>
                </div>
            </div>
            <hr>
        </div>
        <!-- ========================================= -->
        <!-- ============= VIBRATION END ============= -->
        <!-- ========================================= -->

        <!-- COMMENT -->
        <div class="mb-3">
            <label for="comment" class="fw-bold form-label">Remarks</label>
            <textarea disabled placeholder="Description of findings if any" class="form-control" name="comment" id="comment" cols="30" rows="5"></textarea>
        </div>

        <!-- BUTTON SUBMIT -->
        <div>
            <input disabled id="buttonSubmit" class="btn btn-primary" type="button" value="Submit">
        </div>
    </div>
    </div>
</form>
<!-- CHECKING FORM END -->

<script>
    let myform = document.getElementById("myform");
    const ajax = new XMLHttpRequest();
    let motor_status = document.getElementById("motor_status");
    let unrequireds = document.getElementsByClassName("unrequired"); // temperature, vibration and number_of_greasing which is unrequired while emo not running
    let nipple_grease = document.getElementById("nipple_grease");
    let number_of_greasing = document.getElementById("number_of_greasing");
    let buttonSubmit = document.getElementById("buttonSubmit");
    let temperatures = document.getElementsByClassName("temperature");
    let vibration_values = document.getElementsByClassName("vibration_value");
    let vibration_descriptions = document.getElementsByClassName("vibration_description");
    let detail_power_rate = document.getElementById("detail_power_rate");
    let detail_power_unit = document.getElementById("detail_power_unit");
    let vibrations = document.getElementsByClassName("vibration")
    let status = document.getElementById("status");
    let emo_function_location = document.getElementById("emo_function_location");
    let emo_sort_field = document.getElementById("emo_sort_field");
    let noises = document.getElementsByClassName("noise");

    // ========================================================
    // ============= UNHIDE FUNCLOC & SORTFIELD  ==============
    // ========================================================
    if (status.textContent == "Installed") {
        emo_function_location.classList.remove("d-none");
        emo_sort_field.classList.remove("d-none");
    }

    // ========================================================
    // ===================== ENABLE INPUT  ====================
    // ========================================================
    motor_status.onchange = () => {
        // ENABLE ALL INPUT FIELD WHILE RUNNING
        if (motor_status.value === 'Running') {
            for (input of myform) {
                if (
                    input.classList.contains("vibration_description") ||
                    input.getAttribute("name") == "_token" ||
                    input.getAttribute("name") == "motor_status") {
                    continue;
                } else {
                    input.removeAttribute("disabled");
                }
            }

            disabledNumberOfGreasing();
        } else if (motor_status.value === "Not Running") {
            // ENABLE SOME INPUT FILED IF NOT RUNNING
            for (input of myform) {
                if (
                    input.classList.contains("vibration_description") ||
                    input.getAttribute("name") == "_token" ||
                    input.getAttribute("name") == "motor_status") {
                    continue;
                } else {
                    input.removeAttribute("disabled")
                }
            }

            for (input of unrequireds) {
                input.setAttribute("disabled", true);
                if (!input.classList.contains("noise")) {
                    input.value = "";
                }
            }

            for (noise of noises) {
                noise.value = "Normal"
            }

            normalizeVibrationDescription()
            disabledNumberOfGreasing();
        } else {
            // DISABLED ALL INPUT WHILE UNSELECTED
            for (input of myform) {
                if (
                    input.classList.contains("vibration_description") ||
                    input.getAttribute("name") == "_token" ||
                    input.getAttribute("name") == "motor_status") {
                    continue;
                } else {
                    input.setAttribute("disabled", true);
                }
            }

            for (input of unrequireds) {
                if (!input.classList.contains("noise")) {
                    input.value = "";
                }
            }


            normalizeVibrationDescription()

            for (noise of noises) {
                noise.value = "Normal"
            }

            comment.value = "";
            nipple_grease.value = "Available";
            clean_status.value = "Clean";
        }
    }

    // DISABLED NUMBER OF GREASING IF NIPPLE GREASE IS UNAVAILABLE
    function disabledNumberOfGreasing() {
        if (nipple_grease.value == "Available") {
            number_of_greasing.removeAttribute("disabled");
        } else {
            number_of_greasing.setAttribute("disabled", true);
        }
    }
    nipple_grease.onchange = () => {
        disabledNumberOfGreasing();
    }

    // ========================================================
    // =================== INPUT VALIDATION ===================
    // ========================================================
    // FUNCTION ONLY NUMBER ALLOWED
    function onlynumber(evt) {
        let ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }

    // VALIDATE TEMPERATURE NOT EXCEED 200°C
    for (let i = 0; i < temperatures.length; i++) {
        temperatures[i].onchange = () => {
            if (Number(temperatures[i].value) > 200 || temperatures[i].value.length > 3) {
                let temperatureModal = new bootstrap.Modal(document.getElementById('temperature_alert'), {});
                temperatureModal.show();
                temperatures[i].value = "";
            }
        }
    }

    // ========================================================
    // =================== POST DATA AJAX  ====================
    // ========================================================
    buttonSubmit.onclick = () => {

        let myArray = {
            'funcloc': '@{{ $motor->funcloc }}',
            'emo': '@{{ $motor->id }}',
            'sort_field': '@{{ $motor->sort_field }}',
            'equipment_id': '@{{ $equipment_id }}',
        };
        for (let input of myform) {
            if (`${input.name}` == "_token" || `${input.value}` == "Submit") {
                continue;
            } else {
                myArray[`${input.name}`] = `${input.value}`;
            }
        }

        ajax.open("POST", "/checking-form/@{{ $equipment_id }}");
        ajax.setRequestHeader("X-CSRF-TOKEN", "@{{ csrf_token() }}")
        ajax.setRequestHeader("Content-Type", "application/json");
        ajax.onload = () => {
            if (ajax.readyState == 4) {

                console.info(ajax.responseText);

                // response from server is format json
                let response_object = JSON.parse(ajax.responseText);
                // console.info(response_object);

                if (response_object.error?.errorInfo == undefined) {
                    // if have object have error will display error message 
                    if (response_object.hasOwnProperty("error")) {
                        alert_response.textContent = response_object.error;
                        message_response.style.display = "none";
                        alert_response.style.display = "block";
                        document.documentElement.scrollTop = 0;
                    } else {
                        // will display response message success
                        message_response.textContent = response_object.message;
                        alert_response.style.display = "none";
                        message_response.style.display = "block";
                        document.documentElement.scrollTop = 0;
                    }
                } else {
                    alert_response.textContent = response_object.error.connectionName + "Error: " + response_object.error.errorInfo[2];
                    message_response.style.display = "none";
                    alert_response.style.display = "block";
                    document.documentElement.scrollTop = 0;
                }
            }
        }
        ajax.send(JSON.stringify(myArray));
    }

    // ========================================================
    // ========= CHANGE COLOR VIBRATION DESCRIPTION  ==========
    // ========================================================
    // GOOD
    function vibrationGood(element) {
        element.value = "Good";
        element.classList.remove("text-dark");
        element.classList.remove("bg-info");
        element.classList.remove("bg-warning");
        element.classList.remove("bg-danger");
        element.classList.add("bg-success");
        element.classList.add("text-white");
    }

    // SATISACTORY
    function vibrationSatisfactory(element) {
        element.value = "Satisfactory";
        element.classList.remove("text-white");
        element.classList.remove("bg-success");
        element.classList.remove("bg-warning");
        element.classList.remove("bg-danger");
        element.classList.add("bg-info");
        element.classList.add("text-dark");
    }

    // UNSATISFACTORY
    function vibrationUnsatisfactory(element) {
        element.value = "Unsatisfactory";
        element.classList.remove("text-white");
        element.classList.remove("bg-success");
        element.classList.remove("bg-info");
        element.classList.remove("bg-danger");
        element.classList.add("bg-warning");
        element.classList.add("text-dark");
    }

    // UNACCEPTABLE
    function vibrationUnacceptable(element) {
        element.value = "Unacceptable";
        element.classList.remove("text-dark");
        element.classList.remove("bg-success");
        element.classList.remove("bg-warning");
        element.classList.remove("bg-info");
        element.classList.add("bg-danger");
        element.classList.add("text-white");
    }

    // NORMALIZE COLOR
    function normalizeInput(element) {
        element.value = "";
        element.classList.add("text-dark");
        element.classList.remove("text-white");
        element.classList.remove("bg-success");
        element.classList.remove("bg-warning");
        element.classList.remove("bg-info");
        element.classList.remove("bg-danger");
    }

    for (let i = 0; i < vibration_values.length; i++) {
        vibration_values[i].onchange = () => {
            if (vibration_values[i].value > 45 || vibration_values[i].value < 0) {
                let vibrationModal = new bootstrap.Modal(
                    document.getElementById("vibration_alert"), {}
                );
                vibrationModal.show();
                vibration_values[i].value = "0.01";
            }

            if (vibration_values[i].value == "") {
                normalizeInput(vibrations[i]);
            }

            motor_detail_power_rate = detail_power_rate.textContent.split(" ")[0].split("/")[0]; // MOTOR WHO HAVE 2 WINDINGS
            motor_detail_power_unit = detail_power_unit.textContent == "kW" ? "kW" : "HP";

            if (motor_detail_power_unit == "HP") {
                motor_detail_power_rate = Math.floor(motor_detail_power_rate * 0.7457);
            }

            if (motor_detail_power_rate <= 15) {
                // MOTOR CLASS 1 == UNDER 15kW
                figcaption_vibration.textContent =
                    "Vibration standard " + `(${motor_detail_power_rate}kW` + "/Class 1)";

                if (
                    vibration_values[i].value >= 0.01 &&
                    vibration_values[i].value <= 0.71
                ) {
                    // GOOD
                    vibrationGood(vibrations[i]);
                } else if (
                    vibration_values[i].value > 0.71 &&
                    vibration_values[i].value <= 1.8
                ) {
                    // SATISFACTORY
                    vibrationSatisfactory(vibrations[i]);
                } else if (
                    vibration_values[i].value > 1.8 &&
                    vibration_values[i].value <= 4.5
                ) {
                    // UNSATISFACTORY
                    vibrationUnsatisfactory(vibrations[i]);
                } else if (
                    vibration_values[i].value > 4.5 &&
                    vibration_values[i].value <= 45
                ) {
                    // UNACCEPTABLE
                    vibrationUnacceptable(vibrations[i]);
                }
            } else if (motor_detail_power_rate < 300) {
                // MOTOR CLASS 2 == MORE THAN 15kW UNDER 300k
                figcaption_vibration.textContent =
                    "Vibration standard " + `(${motor_detail_power_rate}kW` + "/Class 2)";

                if (
                    vibration_values[i].value >= 0.01 &&
                    vibration_values[i].value <= 1.12
                ) {
                    // GOOD
                    vibrationGood(vibrations[i]);
                } else if (
                    vibration_values[i].value > 1.12 &&
                    vibration_values[i].value <= 2.8
                ) {
                    // SATISFACTORY
                    vibrationSatisfactory(vibrations[i]);
                } else if (
                    vibration_values[i].value > 2.8 &&
                    vibration_values[i].value <= 7.1
                ) {
                    // UNSATISFACTORY
                    vibrationUnsatisfactory(vibrations[i]);
                } else if (
                    vibration_values[i].value > 7.1 &&
                    vibration_values[i].value <= 45
                ) {
                    // UNACCEPTABLE
                    vibrationUnacceptable(vibrations[i]);
                }
            } else {
                // MOTOR CLASS 3 == MORE THAN 300kW
                figcaption_vibration.textContent =
                    "Vibration standard " +
                    `(${motor_detail_power_rate}kW` +
                    "/>=Class 3)";

                if (
                    vibration_values[i].value >= 0.01 &&
                    vibration_values[i].value <= 1.8
                ) {
                    // GOOD
                    vibrationGood(vibrations[i]);
                } else if (
                    vibration_values[i].value > 1.8 &&
                    vibration_values[i].value <= 4.5
                ) {
                    // SATISFACTORY
                    vibrationSatisfactory(vibrations[i]);
                } else if (
                    vibration_values[i].value > 4.5 &&
                    vibration_values[i].value <= 11.2
                ) {
                    // UNSATISFACTORY
                    vibrationUnsatisfactory(vibrations[i]);
                } else if (
                    vibration_values[i].value > 11.2 &&
                    vibration_values[i].value <= 45
                ) {
                    // UNACCEPTABLE
                    vibrationUnacceptable(vibrations[i]);
                }
            }
        };
    }

    // NORMALIZE VIBRATION DESCRIPTION
    function normalizeVibrationDescription() {
        for (vibration_description of vibration_descriptions) {
            normalizeInput(vibration_description);
        }
    }
</script>

@include('utility.suffix')