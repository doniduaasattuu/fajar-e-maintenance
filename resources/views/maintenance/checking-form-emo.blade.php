<!DOCTYPE html>
<html lang="en">

@include("utility.head")

<style>
    #copy_text:hover {
        cursor: pointer;
    }
</style>

<body>
    @include("utility.navbar")

    <div class="container mt-4 my-5">

        <!-- FAILED POST ALERT START -->
        <div class="alert alert-danger shadow" style="display: none" id="alert_response" role="alert">
            Error occurred! ⚠️
        </div>
        <!-- FAILED POST ALERT END -->

        <!-- SUCCESS POST ALERT START -->
        <div class="alert alert-success shadow" style="display: none" id="message_response" role="alert">
            Success! ✅
        </div>
        <!-- SUCCESS POST ALERT END -->

        <!-- TEMPERATURE ALERT START -->
        <div class="modal fade" id="temperature_alert" tabindex="-1" aria-labelledby="temperature_alertLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="bg-light modal-header">
                        <h1 class=" modal-title fs-5" id="temperature_alertLabel">Invalid input ⚠️</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Temperature should not exceed 200&deg;C!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- TEMPERATURE ALERT END -->

        <!-- VIBRATION ALERT START -->
        <div class="modal fade" id="vibration_alert" tabindex="-1" aria-labelledby="vibration_alertLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="bg-light modal-header">
                        <h1 class=" modal-title fs-5" id="vibration_alertLabel">Invalid input ⚠️</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Vibration should not exceed 45 mm/s!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- VIBRATION ALERT END -->

        <!-- EMO ID AND TRENDS START  -->
        <div>
            <h5 id="equipment_description" class="mb-0">{{ $emo->equipment_description }}</h5>
            <p id="sort_field_information" class="lh-sm mb-0 text-secondary">{{ $emo->sort_field }}</p>
            <p id="funcloc_information" class="lh-sm mb-0 text-secondary">{{ $emo->funcloc }}</p>
            <p id="emo_information" class="lh-sm mb-3 text-secondary">{{ $emo->id }}</p>
        </div>

        <form action="/sortfield-trends" method="post">
            @csrf
            <input type="hidden" id="sort_field" name="sort_field" value="{{ $emo->sort_field }}">
            <button class="btn btn-success fw-bold mb-2 text-white">
                <svg class="mb-1 me-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-graph-up" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M0 0h1v15h15v1H0V0Zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07Z" />
                </svg>
                TRENDS
            </button>

        </form>
        <!-- EMO ID AND TRENDS END -->

        <!-- MOTOR DETAILS START -->
        <div class="accordion mb-4" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="bg-primary text-white accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
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
                                <tr class="d-none" id="emo_function_location">
                                    <th>Function Location</th>
                                    <td>{{ $emo->funcloc }}</td>
                                </tr>
                                <tr class="d-none" id="emo_sort_field">
                                    <th>Sort field</th>
                                    <td>{{ $emo->sort_field }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td id="status">{{ $emo->status }}</td>
                                </tr>
                                <tr>
                                    <th>Updated at</th>
                                    <td>{{ $emo->updated_at }}</td>
                                </tr>

                                <tr>
                                    <th>Material number</th>
                                    <td>{{ $emo->material_number }}</td>
                                </tr>
                                @foreach ($emoDetail as $key => $value)
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
        <!-- MOTOR DETAILS END -->

        <!-- CHECKING FORM START -->
        <form id="myform" action="/checking-form/{{ $motorList }}" method="post">
            @csrf
            <div class="row">
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
                    <select name="nipple_grease" id="nipple_grease_input" class="form-select mb-3" aria-label="Default select example">
                        <option value="">--Nipple Grease--</option>
                        <option value="Available">Available</option>
                        <option value="Not Available">Not Available</option>
                    </select>
                    <div class="mb-4">
                        <label for="number_of_greasing_input" class="fw-bold form-label">Number of Greasing</label>
                        <input disabled type="number" onkeypress="return onlynumber(event)" min="0" max="255" step="10" class="form-control" name="number_of_greasing" id="number_of_greasing_input">
                    </div>

                    <!-- =========== TEMPERATURE START =========== -->
                    <div>
                        <div class="row mb-3">
                            <div class="col-md">
                                <figure>
                                    <img class="img-fluid" src="/images/left-side.jpeg" alt="Left Side">
                                    <figcaption class="figure-caption text-center">Left side</figcaption>
                                </figure>
                            </div>
                            <div class="col-md">
                                <figure>
                                    <img class="img-fluid" src="/images/front-side.jpeg" alt="Front Side">
                                    <figcaption class="figure-caption text-center">Front side</figcaption>
                                </figure>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="col-md">
                                <figure>
                                    <img class="img-fluid mx-auto d-block" src="/images/temp_iso_IEC_60085.png" alt="Temperature">
                                    <figcaption class="figure-caption text-center">IEC 60085</figcaption>
                                </figure>
                            </div>
                        </div>

                        <div class="mb-1">
                            <label for="temperature_de" class="fw-bold form-label">Temperature DE</label>
                            <input disabled type="number" onkeypress="return onlynumber(event)" min="0" max="200" class="form-control temperature_input" placeholder="°C" name="temperature_de" id="temperature_de">
                        </div>
                        <div class="mb-1">
                            <label for="temperature_body" class="fw-bold form-label">Temperature Body</label>
                            <input disabled type="number" onkeypress="return onlynumber(event)" min="0" max="200" class="form-control temperature_input" placeholder="°C" name="temperature_body" id="temperature_body">
                        </div>
                        <div class="mb-4">
                            <label for="temperature_nde" class="fw-bold form-label">Temperature NDE</label>
                            <input disabled type="number" onkeypress="return onlynumber(event)" min="0" max="200" class="form-control temperature_input" placeholder="°C" name="temperature_nde" id="temperature_nde">
                        </div>
                        <!-- <div class="mb-4">
                            <label for="temperature_d" class="fw-bold form-label">Temperature D <span style="font-weight: 400;">(NDE)</span></label>
                            <input disabled type="number" onkeypress="return onlynumber(event)" min="0" max="200" class="form-control temperature_input" placeholder="°C" name="temperature_d" id="temperature_d">
                        </div> -->
                    </div>
                    <!-- =========== TEMPERATURE END =========== -->

                    <!-- =========== VIBRATION START =========== -->
                    <div>
                        <div class="row">
                            <div class="col-md mt-4">
                                <figure>
                                    <img class="img-fluid mx-auto d-block" src="/images/vibration-iso-10816.jpg" alt="Vibration">
                                    <figcaption id="figcaption_vibration" class="figure-caption text-center">Vibration standard</figcaption>
                                </figure>
                            </div>
                            <div class="col-md">
                                <figure>
                                    <img class="img-fluid mx-auto d-block" src="/images/vibrations-checking-guide.png" alt="Vibration checking guide">
                                    <figcaption id="figcaption_vibration_checking_guide" class="figure-caption text-center">Vibrations checking guide</figcaption>
                                </figure>
                            </div>
                        </div>

                        <!-- =========================== VIBRATION START =========================== -->
                        <!-- DRIVE END -->
                        <div class="drive-end mb-4">
                            <!-- VIBRATION DEV -->
                            <div class="mb-2">
                                <label for="vibration_de_vertical_value" class="vibrations_label fw-bold form-label">DEV (Vertical)</label>
                                <input disabled type="number" step="0.01" min="0.01" max="45" onkeypress="return /[0-9-.]/i.test(event.key)" class="form-control vibration_value" placeholder="Vibration value (mm/s)" name="vibration_de_vertical_value" id="vibration_de_vertical_value">
                            </div>
                            <select disabled id="vibration_de_vertical_desc" name="vibration_de_vertical_desc" class="vibration form-select mb-3 " aria-label="Default select example">
                                <option value="">--Status--</option>
                                <option value="Good">Good</option>
                                <option value="Satisfactory">Satisfactory</option>
                                <option value="Unsatisfactory">Unsatisfactory</option>
                                <option value="Unacceptable">Unacceptable</option>
                            </select>

                            <!-- VIBRATION DEH -->
                            <div class="mb-2">
                                <label for="vibration_de_horizontal_value" class="vibrations_label fw-bold form-label">DEH (Horizontal)</label>
                                <input disabled type="number" step="0.01" min="0.01" max="45" onkeypress="return /[0-9-.]/i.test(event.key)" class="form-control vibration_value" placeholder="Vibration value (mm/s)" name="vibration_de_horizontal_value" id="vibration_de_horizontal_value">
                            </div>
                            <select disabled id="vibration_de_horizontal_desc" name="vibration_de_horizontal_desc" class="vibration form-select mb-3 " aria-label="Default select example">
                                <option value="">--Status--</option>
                                <option value="Good">Good</option>
                                <option value="Satisfactory">Satisfactory</option>
                                <option value="Unsatisfactory">Unsatisfactory</option>
                                <option value="Unacceptable">Unacceptable</option>
                            </select>

                            <!-- VIBRATION DEA -->
                            <div class="mb-2">
                                <label for="vibration_de_axial_value" class="vibrations_label fw-bold form-label">DEA (Axial)</label>
                                <input disabled type="number" step="0.01" min="0.01" max="45" onkeypress="return /[0-9-.]/i.test(event.key)" class="form-control vibration_value" placeholder="Vibration value (mm/s)" name="vibration_de_axial_value" id="vibration_de_axial_value">
                            </div>
                            <select disabled id="vibration_de_axial_desc" name="vibration_de_axial_desc" class="vibration form-select mb-3 " aria-label="Default select example">
                                <option value="">--Status--</option>
                                <option value="Good">Good</option>
                                <option value="Satisfactory">Satisfactory</option>
                                <option value="Unsatisfactory">Unsatisfactory</option>
                                <option value="Unacceptable">Unacceptable</option>
                            </select>

                            <!-- VIBRATION DE FRAME -->
                            <div class="mb-2">
                                <label for="vibration_de_frame_value" class="vibrations_label fw-bold form-label">DE Frame Horizontal (Diagonal from NDE)</label>
                                <input disabled type="number" step="0.01" min="0.01" max="45" onkeypress="return /[0-9-.]/i.test(event.key)" class="form-control vibration_value" placeholder="Vibration value (mm/s)" name="vibration_de_frame_value" id="vibration_de_frame_value">
                            </div>
                            <select disabled id="vibration_de_frame_desc" name="vibration_de_frame_desc" class="vibration form-select mb-3 " aria-label="Default select example">
                                <option value="">--Status--</option>
                                <option value="Good">Good</option>
                                <option value="Satisfactory">Satisfactory</option>
                                <option value="Unsatisfactory">Unsatisfactory</option>
                                <option value="Unacceptable">Unacceptable</option>
                            </select>
                        </div>

                        <!-- NON DRIVE END -->
                        <div class="non-drive-end my-4">
                            <!-- VIBRATION NDEV -->
                            <div class="mb-2">
                                <label for="vibration_nde_vertical_value" class="vibrations_label fw-bold form-label">NDEV (Vertical)</label>
                                <input disabled type="number" step="0.01" min="0.01" max="45" onkeypress="return /[0-9-.]/i.test(event.key)" class="form-control vibration_value" placeholder="Vibration value (mm/s)" name="vibration_nde_vertical_value" id="vibration_nde_vertical_value">
                            </div>
                            <select disabled id="vibration_nde_vertical_desc" name="vibration_nde_vertical_desc" class="vibration form-select mb-3 " aria-label="Default select example">
                                <option value="">--Status--</option>
                                <option value="Good">Good</option>
                                <option value="Satisfactory">Satisfactory</option>
                                <option value="Unsatisfactory">Unsatisfactory</option>
                                <option value="Unacceptable">Unacceptable</option>
                            </select>

                            <!-- VIBRATION NDEH -->
                            <div class="mb-2">
                                <label for="vibration_nde_horizontal_value" class="vibrations_label fw-bold form-label">NDEH (Horizontal)</label>
                                <input disabled type="number" step="0.01" min="0.01" max="45" onkeypress="return /[0-9-.]/i.test(event.key)" class="form-control vibration_value" placeholder="Vibration value (mm/s)" name="vibration_nde_horizontal_value" id="vibration_nde_horizontal_value">
                            </div>
                            <select disabled id="vibration_nde_horizontal_desc" name="vibration_nde_horizontal_desc" class="vibration form-select mb-3 " aria-label="Default select example">
                                <option value="">--Status--</option>
                                <option value="Good">Good</option>
                                <option value="Satisfactory">Satisfactory</option>
                                <option value="Unsatisfactory">Unsatisfactory</option>
                                <option value="Unacceptable">Unacceptable</option>
                            </select>

                            <!-- VIBRATION NDE FRAME -->
                            <div class="mb-2">
                                <label for="vibration_nde_frame_value" class="vibrations_label fw-bold form-label">NDE Frame Horizontal (Diagonal from DE)</label>
                                <input disabled type="number" step="0.01" min="0.01" max="45" onkeypress="return /[0-9-.]/i.test(event.key)" class="form-control vibration_value" placeholder="Vibration value (mm/s)" name="vibration_nde_frame_value" id="vibration_nde_frame_value">
                            </div>
                            <select disabled id="vibration_nde_frame_desc" name="vibration_nde_frame_desc" class="vibration form-select mb-3 " aria-label="Default select example">
                                <option value="">--Status--</option>
                                <option value="Good">Good</option>
                                <option value="Satisfactory">Satisfactory</option>
                                <option value="Unsatisfactory">Unsatisfactory</option>
                                <option value="Unacceptable">Unacceptable</option>
                            </select>
                        </div>

                        <!-- VIBRATION VALUE DE START -->
                        <!-- <div class="mb-2">
                            <label for="vibration_value_de_vertical" class="vibrations_label fw-bold form-label">Vibration DE</label>
                            <input disabled type="number" step="0.01" min="0.01" max="45" onkeypress="return /[0-9-.]/i.test(event.key)" class="form-control vibration_value" placeholder="Vibration value (mm/s)" name="vibration_value_de_vertical" id="vibration_value_de_vertical">
                        </div>
                        <select disabled id="vibration_de_vertical_desc" name="vibration_de_vertical_desc" class="vibration form-select mb-3 " aria-label="Default select example">
                            <option value="">--Status--</option>
                            <option value="Good">Good</option>
                            <option value="Satisfactory">Satisfactory</option>
                            <option value="Unsatisfactory">Unsatisfactory</option>
                            <option value="Unacceptable">Unacceptable</option>
                        </select> -->
                        <!-- VIBRATION VALUE DE END -->

                        <!-- VIBRATION VALUE NDE START -->
                        <!-- <div class="mb-2">
                            <label for="vibration_value_nde" class="vibrations_label fw-bold form-label">Vibration NDE</label>
                            <input disabled type="number" step="0.01" min="0.01" max="45" onkeypress="return /[0-9-.]/i.test(event.key)" class="form-control vibration_value" placeholder="Vibration value (mm/s)" name="vibration_value_nde" id="vibration_value_nde">
                        </div>
                        <select disabled id="vibration_nde" name="vibration_nde" class="vibration form-select mb-3 " aria-label="Default select example">
                            <option selected value="">--Status--</option>
                            <option value="Good">Good</option>
                            <option value="Satisfactory">Satisfactory</option>
                            <option value="Unsatisfactory">Unsatisfactory</option>
                            <option value="Unacceptable">Unacceptable</option>
                        </select> -->
                        <!-- VIBRATION VALUE NDE END -->
                    </div>
                    <!-- =========== VIBRATIONS END=========== -->

                    <!-- =========== COMMENT START=========== -->
                    <div class="my-4">
                        <label for="vibration_value_de_vertical" class="fw-bold form-label">Remarks</label>
                        <textarea disabled placeholder="Description of findings if any" class="form-control" name="comment" id="comment" cols="30" rows="5"></textarea>
                    </div>
                    <!-- =========== COMMENT END =========== -->

                    <div class="mb-4">
                        <input id="buttonsubmit" class="btn btn-primary" type="button" value="Submit">
                    </div>
                </div>
            </div>
        </form>
        <!-- CHECKING FORM END -->

    </div>

    <script>
        const nipple_grease_input = document.getElementById("nipple_grease_input");
        const number_of_greasing_input = document.getElementById("number_of_greasing_input");
        const temperatures_input = document.getElementsByClassName("temperature_input");
        const alert_response = document.getElementById("alert_response");
        const message_response = document.getElementById("message_response");
        const myform = document.getElementById("myform");
        const ajax = new XMLHttpRequest()

        // AJAX START
        let buttonSubmit = document.getElementById("buttonsubmit");
        buttonSubmit.onclick = () => {

            let myArray = {
                'funcloc': '{{ $emo->funcloc }}',
                'emo': '{{ $emo->id }}',
                'sort_field': '{{ $emo->sort_field }}',
            };
            // console.info(myform);
            for (let input of myform) {
                // console.info(`${key}: ${value}`);
                if (`${input.name}` == "_token") {
                    continue;
                } else if (`${input.value}` == "Submit") {
                    continue;
                } else {
                    // console.info(`${input.name}: ${input.value}`);
                    // myArray.push(`${input.name}: ${input.value}`);
                    myArray[`${input.name}`] = `${input.value}`;
                }
            }
            console.table(myArray);

            ajax.open("POST", "/checking-form/{{ $motorList }}");
            ajax.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}")
            // ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            ajax.setRequestHeader("Content-Type", "application/json");
            ajax.onload = () => {
                if (ajax.readyState == 4) {

                    // response from server is format json
                    // console.info(ajax.responseText);

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
            // ajax.send(
            //     "funcloc=" + '{{ $emo->funcloc }}' + "&" +
            //     "emo=" + '{{ $emo->id }}' + "&" +
            //     "sort_field=" + '{{ $emo->sort_field }}' + "&" +

            //     "motor_status=" + myform[1].value + "&" +
            //     "clean_status=" + myform[2].value + "&" +
            //     "nipple_grease_input=" + myform[3].value + "&" +
            //     "number_of_greasing_input=" + myform[4].value + "&" +

            //     "temperature_a=" + myform[5].value + "&" +
            //     "temperature_b=" + myform[6].value + "&" +
            //     "temperature_c=" + myform[7].value + "&" +
            //     "temperature_d=" + myform[8].value + "&" +

            //     "vibration_value_de_vertical=" + myform[9].value + "&" +
            //     "vibration_de=" + myform[10].value + "&" +
            //     "vibration_value_nde=" + myform[11].value + "&" +
            //     "vibration_nde=" + myform[12].value + "&" +

            //     "comment=" + myform[13].value
            // );
        }
        // AJAX END

        let jsonku = {
            nama: "Doni",
            kelas: "19.3B.24"
        }

        // console.info(jsonku);
        // console.info(JSON.stringify(jsonku));
        // console.info(JSON.stringify(myArray));

        // VIBRATION VALUE ALERT VALIDATION AND STATUS START
        const vibration_values = document.getElementsByClassName("vibration_value");
        const vibrations = document.getElementsByClassName("vibration");
        const motor_class = document.getElementById("motor_class");
        const vibrations_label = document.getElementsByClassName("vibrations_label");
        const figcaption_vibration = document.getElementById("figcaption_vibration");
        const comment = document.getElementById("comment");

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
            element.classList.remove("text-white");
            element.classList.remove("bg-success");
            element.classList.remove("bg-warning");
            element.classList.remove("bg-info");
            element.classList.remove("bg-danger");
        }

        for (let i = 0; i < vibration_values.length; i++) {
            vibration_values[i].onchange = () => {

                if (vibration_values[i].value > 45 || vibration_values[i].value < 0) {
                    let vibrationModal = new bootstrap.Modal(document.getElementById('vibration_alert'), {});
                    vibrationModal.show();
                    vibration_values[i].value = "0.01";
                }

                if (vibration_values[i].value == "") {
                    normalizeInput(vibrations[i]);
                }

                motor_power_rate = power_rate.textContent.split(" ")[0].split("/")[0]; // MOTOR WHO HAVE 2 WINDINGS
                motor_power_unit = power_unit.textContent == "kW" ? "kW" : "HP";

                if (motor_power_unit == "HP") {
                    motor_power_rate = Math.floor(motor_power_rate * 0.7457);
                }

                if (motor_power_rate <= 15) {
                    // MOTOR CLASS 1 == UNDER 15kW
                    figcaption_vibration.textContent = "Vibration standard " + `(${motor_power_rate}kW` + "/Class 1)";

                    if ((vibration_values[i].value >= 0.01) && (vibration_values[i].value <= 0.71)) {
                        // GOOD
                        vibrationGood(vibrations[i]);
                    } else if ((vibration_values[i].value > 0.71) && (vibration_values[i].value <= 1.80)) {
                        // SATISFACTORY
                        vibrationSatisfactory(vibrations[i]);
                    } else if ((vibration_values[i].value > 1.80) && (vibration_values[i].value <= 4.50)) {
                        // UNSATISFACTORY
                        vibrationUnsatisfactory(vibrations[i]);
                    } else if ((vibration_values[i].value > 4.50) && (vibration_values[i].value <= 45)) {
                        // UNACCEPTABLE
                        vibrationUnacceptable(vibrations[i]);
                    }
                } else if (motor_power_rate < 300) {
                    // MOTOR CLASS 2 == MORE THAN 15kW UNDER 300k
                    figcaption_vibration.textContent = "Vibration standard " + `(${motor_power_rate}kW` + "/Class 2)";

                    if ((vibration_values[i].value >= 0.01) && (vibration_values[i].value <= 1.12)) {
                        // GOOD
                        vibrationGood(vibrations[i]);
                    } else if ((vibration_values[i].value > 1.12) && (vibration_values[i].value <= 2.80)) {
                        // SATISFACTORY
                        vibrationSatisfactory(vibrations[i]);
                    } else if ((vibration_values[i].value > 2.80) && (vibration_values[i].value <= 7.10)) {
                        // UNSATISFACTORY
                        vibrationUnsatisfactory(vibrations[i]);
                    } else if ((vibration_values[i].value > 7.10) && (vibration_values[i].value <= 45)) {
                        // UNACCEPTABLE
                        vibrationUnacceptable(vibrations[i]);
                    }
                } else {
                    // MOTOR CLASS 3 == MORE THAN 300kW
                    figcaption_vibration.textContent = "Vibration standard " + `(${motor_power_rate}kW` + "/>=Class 3)";

                    if ((vibration_values[i].value >= 0.01) && (vibration_values[i].value <= 1.80)) {
                        // GOOD
                        vibrationGood(vibrations[i]);
                    } else if ((vibration_values[i].value > 1.80) && (vibration_values[i].value <= 4.50)) {
                        // SATISFACTORY
                        vibrationSatisfactory(vibrations[i]);
                    } else if ((vibration_values[i].value > 4.50) && (vibration_values[i].value <= 11.2)) {
                        // UNSATISFACTORY
                        vibrationUnsatisfactory(vibrations[i]);
                    } else if ((vibration_values[i].value > 11.2) && (vibration_values[i].value <= 45)) {
                        // UNACCEPTABLE
                        vibrationUnacceptable(vibrations[i]);
                    }
                }
            }
        }

        // ENABLED INPUT NUMBER OF GREASING
        nipple_grease_input.onchange = () => {
            if (nipple_grease_input.value == "Available") {
                number_of_greasing_input.removeAttribute("disabled");
            } else {
                number_of_greasing_input.value = "";
                number_of_greasing_input.setAttribute("disabled", true);
            }
        }

        // ENABLED TEMPERATURE AND VIBRATION VALUE
        motor_status.onchange = () => {
            if (motor_status.value == "Running") {
                for (let i = 0; i < temperatures_input.length; i++) {
                    temperatures_input[i].removeAttribute("disabled");
                }
                for (let j = 0; j < vibration_values.length; j++) {
                    vibration_values[j].removeAttribute("disabled");
                }

            } else {

                for (let i = 0; i < temperatures_input.length; i++) {
                    temperatures_input[i].setAttribute("disabled", true);
                    temperatures_input[i].value = "";
                }
                for (let j = 0; j < vibration_values.length; j++) {
                    vibration_values[j].setAttribute("disabled", true);
                    vibration_values[j].value = "";
                }
                for (let k = 0; k < vibrations.length; k++) {
                    normalizeInput(vibrations[k]);
                }
            }

            // ENABLE COMMENT
            if (motor_status.value != "") {
                comment.removeAttribute("disabled", true);
                comment.value = "";
            } else {
                comment.setAttribute("disabled", true);
                comment.value = "";
            }
        }

        // VALIDATE NUMBER OF GREASING NOT EXCEED 255
        number_of_greasing_input.onchange = () => {
            if (Number(number_of_greasing_input.value) > 255) {
                number_of_greasing_input.value = 255
            }
        }

        // ONLY NUMBER DATA TYPES ALLOWED
        function onlynumber(evt) {
            let ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }

        // VALIDATE INPUT TEMPERATURE NOT EXCEED 200 DEGREE
        for (let i = 0; i < temperatures_input.length; i++) {
            temperatures_input[i].onchange = () => {
                // if (temperatures_input[i].value.length > 3) {
                //     let value_accepted = temperatures_input[i].value.substring(0, 3)
                //     temperatures_input[i].value = value_accepted
                // }

                if (Number(temperatures_input[i].value) > 200 || temperatures_input[i].value.length > 3) {
                    let temperatureModal = new bootstrap.Modal(document.getElementById('temperature_alert'), {});
                    temperatureModal.show();
                    temperatures_input[i].value = "";
                }
            }
        }

        // ADD UNIT TO MOTOR DETAILS
        function changeUnit(id, unit) {
            if (id.textContent.length >= 1) {
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

        const cos_phi = document.getElementById("cos_phi");
        changeUnit(cos_phi, "φ");

        const efficiency = document.getElementById("efficiency");
        changeUnit(efficiency, "%");

        const phase_supply = document.getElementById("phase_supply");
        changeUnit(phase_supply, "Phase");

        const greasing_qty_de = document.getElementById("greasing_qty_de");
        changeUnit(greasing_qty_de, "grams");

        const greasing_qty_nde = document.getElementById("greasing_qty_nde");
        changeUnit(greasing_qty_nde, "grams");

        const length = document.getElementById("length");
        changeUnit(length, "mm");

        const width = document.getElementById("width");
        changeUnit(width, "mm");

        const height = document.getElementById("height");
        changeUnit(height, "mm");

        const weight = document.getElementById("weight");
        changeUnit(weight, "kg");

        // HIDE FUNCLOC WHILE NOT INSTALLED
        let function_location = document.getElementById("emo_function_location");
        let sort_field = document.getElementById("emo_sort_field");
        let status = document.getElementById("status");

        if (status.textContent == "Installed") {
            function_location.classList.remove("d-none");
            sort_field.classList.remove("d-none");
        }

        // DISABLED INPUT WHEN EQUIPMENT IS NOT INSTALLED (AVAILABLE / REPAIRED)
        const funcloc_information = document.getElementById("funcloc_information");
        const sort_field_information = document.getElementById("sort_field_information");
        if (funcloc_information.textContent == "" && sort_field_information.textContent == "") {
            buttonSubmit.setAttribute("disabled", true);
            motor_status.setAttribute("disabled", true);
            clean_status.setAttribute("disabled", true);
            nipple_grease_input.setAttribute("disabled", true);
        } else {
            buttonSubmit.removeAttribute("disabled");
            motor_status.removeAttribute("disabled");
            clean_status.removeAttribute("disabled");
            nipple_grease_input.removeAttribute("disabled");
        }
    </script>
</body>

</html>