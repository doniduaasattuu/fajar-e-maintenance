@include('utility.prefix')

<div class="py-4">

    <!-- HEADER -->
    <div class="mb-3">
        <h5 class="text-break lh-sm mb-0">{{ $trafo->sort_field }}</h5>
        <p class="text-break mb-0 text-secondary">{{ $trafo->equipment_description }}</p>
        <p class="text-break lh-sm mb-0 text-secondary">{{ $trafo->funcloc }}</p>
        <p class="text-break lh-sm mb-0 text-secondary">{{ $trafo->id }}</p>
    </div>

    <!-- TRENDS -->
    <form action="/equipment-trends" method="post">
        @csrf
        <input type="hidden" id="sort_field" name="sort_field" value="{{ $trafo->sort_field }}">
        <input type="hidden" id="funcloc" name="funcloc" value="{{ $trafo->funcloc }}">
        <input type="hidden" id="equipment_id" name="equipment_id" value="{{ $equipment_id }}">
        <button class="btn btn-success fw-bold mb-2 text-white">
            <svg class="mb-1 me-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-graph-up" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M0 0h1v15h15v1H0V0Zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07Z" />
            </svg>
            TRENDS
        </button>
    </form>

    <!-- TRANSFORMER DETAILS START -->
    <div class="accordion mb-4" id="accordionDetails">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="bg-primary text-white accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-view-list" viewBox="0 0 16 16">
                        <path d="M3 4.5h10a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1H3zM1 2a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 2zm0 12a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 14z" />
                    </svg>
                    <strong class="ms-2">TRANSFORMER DETAILS</strong>
                </button>
            </h2>
            <!-- DETAILS -->
            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionDetails">
                <div class="accordion-body">
                    <table class="table table-hover">
                        <tbody>

                            <!-- FUNCLOC -->
                            <tr class="d-none" id="transformer_function_location">
                                <th>Function Location</th>
                                <td>{{ $trafo->funcloc }}</td>
                            </tr>

                            <!-- SORT FIELD -->
                            <tr class="d-none" id="transformer_sort_field">
                                <th>Sort field</th>
                                <td>{{ $trafo->sort_field }}</td>
                            </tr>

                            <!-- STATUS -->
                            <tr>
                                <th>Status</th>
                                <td id="status">{{ $trafo->status }}</td>
                            </tr>

                            <!-- UPDATED AT -->
                            <tr>
                                <th>Updated at</th>
                                <td>{{ $trafo->updated_at }}</td>
                            </tr>

                            <!-- EQUIPMENT DESCRIPTION -->
                            <tr>
                                <th>Equipment Description</th>
                                <td class="text-break">{{ $trafo->equipment_description }}</td>
                            </tr>

                            <!-- MATERIAL NUMBER -->
                            <tr>
                                <th>Material number</th>
                                <td>{{ $trafo->material_number }}</td>
                            </tr>

                            @foreach ($trafo->transformerDetails->toArray() as $key => $value)
                            <tr>
                                <th scope="row">{{ str_replace("_", " ", ucwords($key)) }}</th>
                                <td>{{ $value  }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- TRANSFORMER DETAILS END -->

    <!-- ========================================= -->
    <!-- ========== CHECKING FORM START ========== -->
    <!-- ========================================= -->
    <form id="myform" action="/checking-form/{{ $equipment_id }}" method="post">
        @csrf
        <div>
            <div>
                <div class="mb-3">
                    <label for="transformer_status" class="fw-bold form-label">Transformer Status *</label>
                    <select name="transformer_status" id="transformer_status" class="form-select mb-3" aria-label="Default select example">
                        <option value="">--Transformer Status--</option>
                        <option value="Online">Online</option>
                        <option value="Offline">Offline</option>
                    </select>
                </div>

                <!-- OFFLINE DISABLED INPUT -->
                <div>
                    <!-- PRIMARY CURRENT -->
                    <div class="mb-3">
                        <div class="row">
                            <label class="fw-bold form-label">Primary Current (A)</label>
                            <div class="col">
                                <input disabled type="number" onkeypress="return onlynumber(event)" min="0" class="form-control primary_current unrequired" placeholder="Phase R" name="primary_current_phase_r" id="primary_current_phase_r">
                            </div>
                            <div class="col px-0">
                                <input disabled type="number" onkeypress="return onlynumber(event)" min="0" class="form-control primary_current unrequired" placeholder="Phase S" name="primary_current_phase_s" id="primary_current_phase_s">
                            </div>
                            <div class="col">
                                <input disabled type="number" onkeypress="return onlynumber(event)" min="0" class="form-control primary_current unrequired" placeholder="Phase T" name="primary_current_phase_t" id="primary_current_phase_t">
                            </div>
                        </div>
                    </div>

                    <!-- SECONDARY CURRENT -->
                    <div class="mb-3">
                        <div class="row">
                            <label class="fw-bold form-label">Secondary Current (A)</label>
                            <div class="col">
                                <input disabled type="number" onkeypress="return onlynumber(event)" min="0" class="form-control secondary_current unrequired" placeholder="Phase R" name="secondary_current_phase_r" id="secondary_current_phase_r">
                            </div>
                            <div class="col px-0">
                                <input disabled type="number" onkeypress="return onlynumber(event)" min="0" class="form-control secondary_current unrequired" placeholder="Phase S" name="secondary_current_phase_s" id="secondary_current_phase_s">
                            </div>
                            <div class="col">
                                <input disabled type="number" onkeypress="return onlynumber(event)" min="0" class="form-control secondary_current unrequired" placeholder="Phase T" name="secondary_current_phase_t" id="secondary_current_phase_t">
                            </div>
                        </div>
                    </div>

                    <!-- PRIMARY VOLTAGE -->
                    <div class="mb-3">
                        <label for="primary_voltage" class="fw-bold form-label">Primary Voltage (V)</label>
                        <input disabled type="number" onkeypress="return onlynumber(event)" min="0" class="form-control voltage_input unrequired" placeholder="Volt" name="primary_voltage" id="primary_voltage">
                    </div>

                    <!-- SECONDARY VOLTAGE -->
                    <div class="mb-3">
                        <label for="secondary_voltage" class="fw-bold form-label">Secondary Voltage (V)</label>
                        <input disabled type="number" onkeypress="return onlynumber(event)" min="0" class="form-control voltage_input unrequired" placeholder="Volt" name="secondary_voltage" id="secondary_voltage">
                    </div>

                    <!-- OIL TEMPERATURE -->
                    <div class="mb-3">
                        <label for="oil_temperature" class="fw-bold form-label">Oil Temperature</label>
                        <input disabled type="number" onkeypress="return onlynumber(event)" min="0" max="200" class="form-control temperature unrequired" placeholder="°C" name="oil_temperature" id="oil_temperature">
                    </div>

                    <!-- WINDING TEMPERATURE -->
                    <div class="mb-3">
                        <label for="winding_temperature" class="fw-bold form-label">Winding Temperature</label>
                        <input disabled type="number" onkeypress="return onlynumber(event)" min="0" max="200" class="form-control temperature unrequired" placeholder="°C" name="winding_temperature" id="winding_temperature">
                    </div>
                </div>

                <!-- CLEAN STATUS -->
                <div class="mb-3">
                    <label for="clean_status" class="fw-bold form-label">Clean Status *</label>
                    <select disabled name="clean_status" id="clean_status" class="form-select mb-3 required" aria-label="Default select example">
                        <option value="Clean">Clean</option>
                        <option value="Dirty">Dirty</option>
                    </select>
                </div>

                <!-- NOISE -->
                <div class="mb-3">
                    <label for="noise" class="fw-bold form-label">Noise *</label>
                    <select disabled name="noise" id="noise" class="form-select mb-3 required" aria-label="Default select example">
                        <option value="Normal">Normal</option>
                        <option value="Abnormal">Abnormal</option>
                    </select>
                </div>

                <!-- SILICA GEL -->
                <div class="mb-3">
                    <label for="silica_gel" class="fw-bold form-label">Silica Gel *</label>
                    <select disabled name="silica_gel" id="silica_gel" class="form-select mb-3 required" aria-label="Default select example">
                        <option title="Good" value="Dark Blue">Dark Blue</option>
                        <option title="Satisfactory" value="Light Blue">Light Blue</option>
                        <option title="Unsatisfactory" value="Pink">Pink</option>
                        <option title="Unacceptable" value="Brown">Brown</option>
                    </select>
                </div>

                <!-- EARTHING CONNECTION -->
                <div class="mb-3">
                    <label for="earthing_connection" class="fw-bold form-label">Earthing Connection *</label>
                    <select disabled name="earthing_connection" id="earthing_connection" class="form-select mb-3 required" aria-label="Default select example">
                        <option value="Tight">Tight</option>
                        <option value="Loose">Loose</option>
                    </select>
                </div>

                <!-- OIL LEAKAGE -->
                <div class="mb-3">
                    <label for="oil_leakage" class="fw-bold form-label">Oil Leakage *</label>
                    <select disabled name="oil_leakage" id="oil_leakage" class="form-select mb-3 required" aria-label="Default select example">
                        <option value="No Leaks">No Leaks</option>
                        <option value="Leaks">Leaks</option>
                    </select>
                </div>

                <!-- OIL LEVEL -->
                <div class="mb-3">
                    <label for="oil_level" class="fw-bold form-label">Oil Level *</label>
                    <input disabled type="number" onkeypress="return onlynumber(event)" step="10" min="0" max="100" class="form-control required" placeholder="0-100%" name="oil_level" id="oil_level">
                </div>

                <!-- BLOWER CONDITION -->
                <div class="mb-3">
                    <label for="blower_condition" class="fw-bold form-label">Blower Condition *</label>
                    <select disabled name="blower_condition" id="blower_condition" class="form-select mb-3 required" aria-label="Default select example">
                        <option value="Normal">Normal</option>
                        <option value="Abnormal">Abnormal</option>
                    </select>
                </div>
                <hr>

                <!-- COMMENT -->
                <div class="mb-3">
                    <label for="comment" class="fw-bold form-label">Remarks</label>
                    <textarea disabled placeholder="Description of findings if any" class="form-control mb-3" name="comment" id="comment" cols="30" rows="5"></textarea>
                </div>

                <!-- BUTTON SUBMIT -->
                <div>
                    <input disabled id="buttonSubmit" class="btn btn-primary" type="button" value="Submit">
                </div>
            </div>
        </div>
    </form>
    <!-- TRANSFORMER CHECKING FORM END -->

</div>

<script>
    let myform = document.getElementById("myform");
    const ajax = new XMLHttpRequest();

    let transformer_function_location = document.getElementById("transformer_function_location");
    let transformer_sort_field = document.getElementById("transformer_sort_field");
    let status = document.getElementById("status");
    let buttonSubmit = document.getElementById("buttonSubmit");

    let transformer_status = document.getElementById("transformer_status");
    let temperatures = document.getElementsByClassName("temperature");
    let oil_level = document.getElementById("oil_level");
    let unrequireds = document.getElementsByClassName("unrequired"); // current, voltage & temperature which is unrequired while transformer offline

    // ========================================================
    // ============= UNHIDE FUNCLOC & SORTFIELD  ==============
    // ========================================================
    if (status.textContent == "Installed") {
        transformer_function_location.classList.remove("d-none");
        transformer_sort_field.classList.remove("d-none");
    }

    // ========================================================
    // ===================== ENABLE INPUT  ====================
    // ========================================================
    transformer_status.onchange = () => {
        // ENABLE ALL INPUT FIELD WHILE ONLINE
        if (transformer_status.value === 'Online') {
            for (input of myform) {
                if (input.getAttribute("name") == "_token" ||
                    input.getAttribute("name") == "transformer_status") {
                    continue;
                } else {
                    input.removeAttribute("disabled")
                }
            }
        } else if (transformer_status.value === "Offline") {
            // ENABLE SOME INPUT FILED IF OFFLINE
            for (input of myform) {
                if (input.getAttribute("name") == "_token" ||
                    input.getAttribute("name") == "transformer_status") {
                    continue;
                } else {
                    input.removeAttribute("disabled")
                }
            }
            // CURRENT AND VOLTAGE FIELD
            for (input of unrequireds) {
                input.value = "";
                input.setAttribute("disabled", true);
            }
        } else {
            // DISABLED ALL INPUT WHILE UNSELECTED
            for (input of myform) {
                if (input.getAttribute("name") == "_token" ||
                    input.getAttribute("name") == "transformer_status") {
                    continue;
                } else {
                    input.setAttribute("disabled", true);
                }
            }
            // CURRENT AND VOLTAGE FIELD
            for (input of unrequireds) {
                input.value = "";
            }

            setInputValueToDefaultValue();
        }
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

    // VALIDATION OIL LEVEL BELOW 100%
    oil_level.onchange = () => {
        if (oil_level.value > 100) {
            let oilLevelModal = new bootstrap.Modal(document.getElementById('oil_level_alert'), {});
            oilLevelModal.show();
            oil_level.value = "";
        }
    }

    // ========================================================
    // =================== POST DATA AJAX  ====================
    // ========================================================
    buttonSubmit.onclick = () => {

        let myArray = {
            'funcloc': '{{ $trafo->funcloc }}',
            'transformer': '{{ $trafo->id }}',
            'sort_field': '{{ $trafo->sort_field }}',
            'equipment_id': '{{ $equipment_id }}',
        };
        for (let input of myform) {
            if (`${input.name}` == "_token" || `${input.value}` == "Submit") {
                continue;
            } else {
                myArray[`${input.name}`] = `${input.value}`;
            }
        }
        console.table(myArray);

        ajax.open("POST", "/checking-form/{{ $equipment_id }}");
        ajax.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}")
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

    // SET REQUIRED INPUT SELECT VALUE TO DEFAULT VALUE
    function setInputValueToDefaultValue() {
        let requireds = document.getElementsByClassName("required");
        for (required of requireds) {
            let input = document.getElementById(required.id);
            let input_firstchild = input.firstElementChild ?? "";
            let reset = input_firstchild.value == undefined ? "" : input_firstchild.value;

            input.value = reset;
        }

        let comment = document.getElementById("comment");
        comment.value = "";
    }
</script>

@include('utility.suffix')