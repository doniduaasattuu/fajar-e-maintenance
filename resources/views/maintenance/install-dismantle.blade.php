<!DOCTYPE html>
<html lang="en">

@include('utility.head')

<style>
    #alert_response:hover {
        cursor: pointer;
    }
</style>

<body>

    @include('utility.navbar')

    <div class="container py-4">

        <!-- MESSAGE -->
        @if (session("message"))
        <div class="modal fade" id="message" tabindex="-1" aria-labelledby="messageLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="bg-light modal-header">
                        <h1 class=" modal-title fs-5" id="messageLabel">Message</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ session("message") }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            let message = new bootstrap.Modal(document.getElementById('message'), {});
            message.show();
        </script>
        @endif
        <!-- MESSAGE -->

        <!-- <form action="#">
            <div class="form-group row mb-3">
                <label class="col-form-label col-xl-2 fw-bold">Status</label>
                <div class="input-group col-xl-10">
                    <select name="status" id="status" value="Installed" class="form-select" aria-label="Default select example">
                        <option value="Repaired">Repaired</option>
                        <option value="Installed">Installed</option>
                        <option value="Available">Available</option>
                    </select>
                    <select name="status" id="status" value="Installed" class="form-select" aria-label="Default select example">
                        <option value="Repaired">Repaired</option>
                        <option value="Installed">Installed</option>
                        <option value="Available">Available</option>
                    </select>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="col-form-label col-xl-2 fw-bold">Material Number</label>
                <div class="input-group col-xl-10">
                    <input name="material_number" id="material_number" type="text" class="form-control" value="10019982">
                    <input name="material_number" id="material_number" type="text" class="form-control" value="10019982">
                </div>
            </div>
        </form> -->

        <!-- WARNING -->
        <div title="Click to dismiss" class="alert alert-warning shadow" id="alert_response" role="alert">
            ⚠️ Warning: Every changes can't be undone.
        </div>
        <!-- WARNING -->

        <form action="/install-dismantle" method="post">
            @csrf
            <div class="row">

                <!-- HEADER -->
                <h3 class="mb-3">Install Dismantle</h3>
                <!-- HEADER -->

                <!-- FORM DISMANTLED -->
                <div class="col">
                    <p class="mb-0 text-secondary">Equipment to be dismantled</p>
                    <div>
                        <!-- SEARCH FORM -->
                        <div class="form-group row mb-3">
                            <label class="col-form-label col-xl-10 fw-bold">Equipment</label>
                            <div class="input-group col-xl-10">
                                <input id="search_equipment_dismantle" type="text" class="form-control" placeholder="Equipment">
                                <button disabled id="button_search_dismantle" class="btn btn-primary">
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <!-- SEARCH FORM -->

                        <div id="dismantle_form">
                            <!-- DATA -->
                            <!-- <input name="id" id="id_dismantle" type="hidden" class="form-control" placeholder="Equipment">

                        <div class="form-group row mb-1">
                            <label class="col-form-label col-xl-10 fw-bold">Status</label>
                            <div class="input-group col-xl-10">
                                <select name="status" id="status_dismantle" class="form-select" aria-label="Default select example">
                                    <option value="Available">Available</option>
                                    <option value="Installed">Installed</option>
                                    <option value="Repaired">Repaired</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label class="col-form-label col-xl-10 fw-bold">Funcloc</label>
                            <div class="input-group col-xl-10">
                                <input name="funcloc" id="funcloc_dismantle" type="text" class="form-control" placeholder="Funcloc">
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label class="col-form-label col-xl-10 fw-bold">Sort Field</label>
                            <div class="input-group col-xl-10">
                                <input name="sort_field" id="sort_field_dismantle" type="text" class="form-control" placeholder="Sort Field">
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label class="col-form-label col-xl-10 fw-bold">Material Number</label>
                            <div class="input-group col-xl-10">
                                <input name="material_number" id="material_number_dismantle" type="text" class="form-control" placeholder="Material Number">
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label class="col-form-label col-xl-10 fw-bold">Description</label>
                            <div class="input-group col-xl-10">
                                <input name="equipment_description" id="equipment_description_dismantle" type="text" class="form-control" placeholder="Description">
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label class="col-form-label col-xl-10 fw-bold">Updated at</label>
                            <div class="input-group col-xl-10">
                                <input name="updated_at" id="updated_at_dismantle" type="text" class="form-control" placeholder="Updated at">
                            </div>
                        </div>

                        <div class="d-flex">
                            <button type="submit" class="ms-auto mt-3 btn btn-primary">
                                <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                                    <path d="M11 2H9v3h2V2Z" />
                                    <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0ZM1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5Zm3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4v4.5ZM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5V15Z" />
                                </svg>
                                Save
                            </button>
                        </div> -->
                            <!-- DATA -->
                        </div>
                    </div>
                </div>
                <!-- FORM DISMANTLED -->

                <!-- ================================================================================================================================================================================ -->

                <!-- FORM INSTALLED START -->
                <div class="col">
                    <p class="mb-0 text-secondary">Equipment to be installed</p>
                    <div>
                        <!-- SEARCH FORM -->
                        <div class="form-group row mb-3">
                            <label class="col-form-label col-xl-10 fw-bold">Equipment</label>
                            <div class="input-group col-xl-10">
                                <input id="search_equipment_install" type="text" class="form-control" placeholder="Equipment">
                                <button disabled id="button_search_install" class="btn btn-primary">
                                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <!-- SEARCH FORM -->

                        <div id="install_form">
                            <!-- DATA -->
                            <!-- <input name="id" id="id_install" type="hidden" class="form-control" placeholder="Equipment">

                        <div class="form-group row mb-1">
                            <label class="col-form-label col-xl-10 fw-bold">Status</label>
                            <div class="input-group col-xl-10">
                                <select name="status" id="status_install" class="form-select" aria-label="Default select example">
                                    <option value="Available">Available</option>
                                    <option value="Installed">Installed</option>
                                    <option value="Repaired">Repaired</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label class="col-form-label col-xl-10 fw-bold">Funcloc</label>
                            <div class="input-group col-xl-10">
                                <input name="funcloc" id="funcloc_install" type="text" class="form-control" placeholder="Funcloc">
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label class="col-form-label col-xl-10 fw-bold">Sort Field</label>
                            <div class="input-group col-xl-10">
                                <input name="sort_field" id="sort_field_install" type="text" class="form-control" placeholder="Sort Field">
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label class="col-form-label col-xl-10 fw-bold">Material Number</label>
                            <div class="input-group col-xl-10">
                                <input name="material_number" id="material_number_install" type="text" class="form-control" placeholder="Material Number">
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label class="col-form-label col-xl-10 fw-bold">Description</label>
                            <div class="input-group col-xl-10">
                                <input name="equipment_description" id="equipment_description_install" type="text" class="form-control" placeholder="Description">
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label class="col-form-label col-xl-10 fw-bold">Updated at</label>
                            <div class="input-group col-xl-10">
                                <input name="updated_at" id="updated_at_install" type="text" class="form-control" placeholder="Updated at">
                            </div>
                        </div>

                        <div class="d-flex">
                            <button type="submit" class="ms-auto mt-3 btn btn-primary">
                                <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                                    <path d="M11 2H9v3h2V2Z" />
                                    <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0ZM1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5Zm3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4v4.5ZM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5V15Z" />
                                </svg>
                                Save
                            </button>
                        </div> -->
                            <!-- DATA -->
                        </div>
                    </div>
                </div>
                <!-- FORM DISMANTLED -->
            </div>

            <div id="button_submit" class="d-none">
                <button type="submit" class="mt-4 btn btn-primary">
                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                        <path d="M11 2H9v3h2V2Z" />
                        <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0ZM1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5Zm3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4v4.5ZM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5V15Z" />
                    </svg>
                    Change
                </button>
            </div>
        </form>
    </div>


    <script>
        // SEARCH FORM LOGIC
        const dismantle_form = document.getElementById("dismantle_form");
        const install_form = document.getElementById("install_form");
        const search_equipment_dismantle = document.getElementById("search_equipment_dismantle");
        const button_search_dismantle = document.getElementById("button_search_dismantle");
        const search_equipment_install = document.getElementById("search_equipment_install");
        const button_search_install = document.getElementById("button_search_install");
        const button_submit = document.getElementById("button_submit");

        function addZero(value) {
            if (value <= 9) {
                return "0" + value;
            } else {
                return value;
            }
        }

        function printGeneralInputValue(key, value, status, myform) {
            let div = document.createElement("div");
            div.setAttribute("class", "form-group row mb-1");

            let content = key.split("_");
            if (content.length > 1) {
                label_text = content[0].charAt(0).toUpperCase() + content[0].slice(1) + " " + content[1];
            } else {
                label_text = content[0].charAt(0).toUpperCase() + content[0].slice(1);
            }

            let label = document.createElement("label");
            label.setAttribute("class", "col-form-label col-xl-10 fw-bold");
            label.textContent = label_text;

            let div_input = document.createElement("div");
            div_input.setAttribute("class", "input-group col-xl-10");

            let input = document.createElement("input");
            input.setAttribute("id", key + status);
            input.setAttribute("name", key + status);
            input.setAttribute("value", (value != "null") ? value : "");
            input.setAttribute("type", "text");
            input.setAttribute("class", "form-control");
            // input.setAttribute("placeholder", key);

            div_input.appendChild(input);
            div.appendChild(label);
            div.appendChild(div_input);

            myform.appendChild(div);
            // console.info(`${key}: ${value}`);
        }

        function removeAllChildren(parent) {
            while (parent.firstChild) {
                parent.removeChild(parent.firstChild);
            }
        }

        function removeChildrenOnFocus(button_search, search_input, parent) {
            search_input.onfocus = () => {
                if (search_input.value.length == 9) {
                    button_search.removeAttribute("disabled");
                } else {
                    button_search.setAttribute("disabled", true);
                }
                removeAllChildren(parent);
            }
        }

        removeChildrenOnFocus(button_search_dismantle, search_equipment_dismantle, dismantle_form);
        removeChildrenOnFocus(button_search_install, search_equipment_install, install_form);

        function enabledButtonSearchEquipment(search_input, button_search) {
            search_input.oninput = () => {
                if (search_input.value.length == 9) {
                    button_search.removeAttribute("disabled");
                } else {
                    button_search.setAttribute("disabled", true);
                }
            }
        }

        function showButtonSubmit() {
            // CHANGE COLUMN STATUS DISMANTLE AUTO FILLED COLUMN STATUS INSTALL START
            const status_dismantle = document.getElementById("status_dismantle");
            const funcloc_dismantle = document.getElementById("funcloc_dismantle");
            const sort_field_dismantle = document.getElementById("sort_field_dismantle");

            const status_install = document.getElementById("status_install");
            const funcloc_install = document.getElementById("funcloc_install");
            const sort_field_install = document.getElementById("sort_field_install");

            status_dismantle.onchange = () => {
                if (status_dismantle.value == "Repaired" || status_dismantle.value == "Available") {
                    if (funcloc_dismantle.value != "") {
                        status_install.value = "Installed";
                        funcloc_install.value = funcloc_dismantle.value;
                        sort_field_install.value = sort_field_dismantle.value;

                        funcloc_dismantle.value = "";
                        sort_field_dismantle.value = "";
                    }
                } else {
                    if (funcloc_install.value != "") {
                        status_install.value = "Available";
                        funcloc_dismantle.value = funcloc_install.value;
                        sort_field_dismantle.value = sort_field_install.value;

                        funcloc_install.value = "";
                        sort_field_install.value = "";
                    }
                }
            }
            // CHANGE COLUMN STATUS DISMANTLE AUTO FILLED COLUMN STATUS INSTALL END

            if ((dismantle_form.childElementCount >= 1) && (install_form.childElementCount >= 1)) {
                button_submit.classList.remove("d-none");
            } else {
                button_submit.classList.add("d-none");
            }
            // console.info((dismantle_form.childElementCount >= 1) && (install_form.childElementCount >= 1));
        }

        function getEquipment(search_input, button_search, status, myform) {
            button_search.onclick = (event) => {
                button_search.setAttribute("disabled", true);

                const ajax = new XMLHttpRequest();
                ajax.open("POST", "/equipment");
                ajax.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
                ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                ajax.onload = () => {
                    if (ajax.readyState == 4) {

                        if (ajax.responseText.length != 6) {

                            // console.info(JSON.parse(JSON.parse(ajax.responseText)));
                            let response_string = JSON.parse(ajax.responseText);
                            let response_object = JSON.parse(response_string);

                            for (const [key, value] of Object.entries(response_object)) {
                                if (`${key}` == "emo_details") {
                                    // EMO DETAILS TABLE
                                    for (const [key, value] of Object.entries(response_object.emo_details)) {

                                        if (`${key}` == "id" || `${key}` == "emo_detail") {
                                            continue;
                                        } else if (`${key}` == "power_unit") {
                                            // POWER UNIT
                                            let div = document.createElement("div");
                                            div.setAttribute("class", "form-group row mb-1");

                                            let label = document.createElement("label");
                                            label.setAttribute("class", "col-form-label col-xl-10 fw-bold");
                                            label.textContent = "Power unit";

                                            let div_select = document.createElement("div");
                                            div_select.setAttribute("class", "input-group col-xl-10");

                                            let select = document.createElement("select");
                                            select.setAttribute("name", `${key + status}`);
                                            select.setAttribute("id", `${key + status}`);
                                            select.setAttribute("class", "form-select");
                                            select.setAttribute("aria-label", "Default select example");
                                            select.setAttribute("value", (`${value}` != "null") ? `${value}` : "");

                                            let option_kw = document.createElement("option");
                                            option_kw.setAttribute("value", "kW");
                                            option_kw.textContent = "kW";

                                            let option_hp = document.createElement("option");
                                            option_hp.setAttribute("value", "HP");
                                            option_hp.textContent = "HP";

                                            if (`${value}` == "kW") {
                                                option_kw.setAttribute("selected", true);
                                            } else if (`${value}` == "HP") {
                                                option_hp.setAttribute("selected", true);
                                            }

                                            select.appendChild(option_hp);
                                            select.appendChild(option_kw);

                                            div_select.appendChild(select);

                                            div.appendChild(label);
                                            div.appendChild(div_select);

                                            myform.appendChild(div);
                                            continue;
                                        } else if (`${key}` == "nipple_grease") {
                                            // NIPPLE GREASE
                                            let div = document.createElement("div");
                                            div.setAttribute("class", "form-group row mb-1");

                                            let label = document.createElement("label");
                                            label.setAttribute("class", "col-form-label col-xl-10 fw-bold");
                                            label.textContent = "Nipple grease";

                                            let div_select = document.createElement("div");
                                            div_select.setAttribute("class", "input-group col-xl-10");

                                            let select = document.createElement("select");
                                            select.setAttribute("name", `${key + status}`);
                                            select.setAttribute("id", `${key + status}`);
                                            select.setAttribute("class", "form-select");
                                            select.setAttribute("aria-label", "Default select example");
                                            select.setAttribute("value", (`${value}` != "null") ? `${value}` : "");

                                            let option_available = document.createElement("option");
                                            option_available.setAttribute("value", "Available");
                                            option_available.textContent = "Available";

                                            let option_not_available = document.createElement("option");
                                            option_not_available.setAttribute("value", "Not Available");
                                            option_not_available.textContent = "Not Available";

                                            if (`${value}` == "Available") {
                                                option_available.setAttribute("selected", true);
                                            } else if (`${value}` == "Not Available") {
                                                option_not_available.setAttribute("selected", true);
                                            }

                                            select.appendChild(option_available);
                                            select.appendChild(option_not_available);

                                            div_select.appendChild(select);

                                            div.appendChild(label);
                                            div.appendChild(div_select);

                                            myform.appendChild(div);
                                            continue;
                                        } else if (`${key}` == "cooling_fan") {
                                            // COOLING FAN
                                            let div = document.createElement("div");
                                            div.setAttribute("class", "form-group row mb-1");

                                            let label = document.createElement("label");
                                            label.setAttribute("class", "col-form-label col-xl-10 fw-bold");
                                            label.textContent = "Cooling fan";

                                            let div_select = document.createElement("div");
                                            div_select.setAttribute("class", "input-group col-xl-10");

                                            let select = document.createElement("select");
                                            select.setAttribute("name", `${key + status}`);
                                            select.setAttribute("id", `${key + status}`);
                                            select.setAttribute("class", "form-select");
                                            select.setAttribute("aria-label", "Default select example");
                                            select.setAttribute("value", (`${value}` != "null") ? `${value}` : "");

                                            let option_internal = document.createElement("option");
                                            option_internal.setAttribute("value", "Internal");
                                            option_internal.textContent = "Internal";

                                            let option_external = document.createElement("option");
                                            option_external.setAttribute("value", "External");
                                            option_external.textContent = "External";

                                            let option_not_available = document.createElement("option");
                                            option_not_available.setAttribute("value", "Not Available");
                                            option_not_available.textContent = "Not Available";

                                            if (`${value}` == "Internal") {
                                                option_internal.setAttribute("selected", true);
                                            } else if (`${value}` == "External") {
                                                option_external.setAttribute("selected", true);
                                            } else if (`${value}` == "Not Available") {
                                                option_not_available.setAttribute("selected", true);
                                            }

                                            select.appendChild(option_internal);
                                            select.appendChild(option_external);
                                            select.appendChild(option_not_available);

                                            div_select.appendChild(select);

                                            div.appendChild(label);
                                            div.appendChild(div_select);

                                            myform.appendChild(div);
                                            continue;
                                        } else if (`${key}` == "mounting") {
                                            // MOUNTING
                                            let div = document.createElement("div");
                                            div.setAttribute("class", "form-group row mb-1");

                                            let label = document.createElement("label");
                                            label.setAttribute("class", "col-form-label col-xl-10 fw-bold");
                                            label.textContent = "Mounting";

                                            let div_select = document.createElement("div");
                                            div_select.setAttribute("class", "input-group col-xl-10");

                                            let select = document.createElement("select");
                                            select.setAttribute("name", `${key + status}`);
                                            select.setAttribute("id", `${key + status}`);
                                            select.setAttribute("class", "form-select");
                                            select.setAttribute("aria-label", "Default select example");
                                            select.setAttribute("value", (`${value}` != "null") ? `${value}` : "");

                                            let option_horizontal = document.createElement("option");
                                            option_horizontal.setAttribute("value", "Horizontal");
                                            option_horizontal.textContent = "Horizontal";

                                            let option_vertical = document.createElement("option");
                                            option_vertical.setAttribute("value", "Vertical");
                                            option_vertical.textContent = "Vertical";

                                            let option_vh = document.createElement("option");
                                            option_vh.setAttribute("value", "V/H");
                                            option_vh.textContent = "V/H";

                                            let option_mgm = document.createElement("option");
                                            option_mgm.setAttribute("value", "MGM");
                                            option_mgm.textContent = "MGM";

                                            if (`${value}` == "Horizontal") {
                                                option_horizontal.setAttribute("selected", true);
                                            } else if (`${value}` == "Vertical") {
                                                option_vertical.setAttribute("selected", true);
                                            } else if (`${value}` == "V/H") {
                                                option_vh.setAttribute("selected", true);
                                            } else if (`${value}` == "MGM") {
                                                option_mgm.setAttribute("selected", true);
                                            }

                                            select.appendChild(option_horizontal);
                                            select.appendChild(option_vertical);
                                            select.appendChild(option_vh);
                                            select.appendChild(option_mgm);

                                            div_select.appendChild(select);

                                            div.appendChild(label);
                                            div.appendChild(div_select);

                                            myform.appendChild(div);
                                            continue;
                                        } else {

                                            printGeneralInputValue(`${key}`, `${value}`, status, myform);
                                            // console.info(`${key}: ${value}`);
                                            // INPUT FORM GENERALLY
                                            // let div = document.createElement("div");
                                            // div.setAttribute("class", "form-group row mb-1");

                                            // let content = `${key}`.split("_");
                                            // if (content.length > 1) {
                                            //     label_text = content[0].charAt(0).toUpperCase() + content[0].slice(1) + " " + content[1];
                                            // } else {
                                            //     label_text = content[0].charAt(0).toUpperCase() + content[0].slice(1);
                                            // }

                                            // let label = document.createElement("label");
                                            // label.setAttribute("class", "col-form-label col-xl-10 fw-bold");
                                            // label.textContent = label_text;

                                            // let div_input = document.createElement("div");
                                            // div_input.setAttribute("class", "input-group col-xl-10");

                                            // let input = document.createElement("input");
                                            // input.setAttribute("name", `${value}`);
                                            // input.setAttribute("value", (`${value}` != "null") ? `${value}` : "");
                                            // input.setAttribute("type", "text");
                                            // input.setAttribute("class", "form-control");
                                            // // input.setAttribute("placeholder", `${key}`);

                                            // div_input.appendChild(input);
                                            // div.appendChild(label);
                                            // div.appendChild(div_input);

                                            // myform.appendChild(div);
                                        }
                                    }
                                } else {
                                    // EMO TABLE
                                    if (`${key}` == "id") {
                                        // EMO

                                        let input = document.createElement("input");
                                        input.setAttribute("id", `${key + status}`);
                                        input.setAttribute("name", `${key + status}`);
                                        input.setAttribute("type", "hidden");
                                        input.setAttribute("class", "form-control");
                                        // input.setAttribute("placeholder", "Equipment");
                                        input.setAttribute("value", (`${value}` != "null") ? `${value}` : "");
                                        myform.appendChild(input);
                                        continue;
                                    } else if (`${key}` == "status") {
                                        // STATUS
                                        let div = document.createElement("div");
                                        div.setAttribute("class", "form-group row mb-1");

                                        let label = document.createElement("label");
                                        label.setAttribute("class", "col-form-label col-xl-10 fw-bold");
                                        label.textContent = "Status";

                                        let div_select = document.createElement("div");
                                        div_select.setAttribute("class", "input-group col-xl-10");

                                        let select = document.createElement("select");
                                        select.setAttribute("name", `${key + status }`);
                                        select.setAttribute("id", `${key + status}`);
                                        select.setAttribute("class", "form-select");
                                        select.setAttribute("aria-label", "Default select example");
                                        select.setAttribute("value", (`${value}` != "null") ? `${value}` : "");
                                        let option_available = document.createElement("option");
                                        option_available.setAttribute("value", "Available");
                                        option_available.textContent = "Available";

                                        let option_installed = document.createElement("option");
                                        option_installed.setAttribute("value", "Installed");
                                        option_installed.textContent = "Installed";

                                        let option_repaired = document.createElement("option");
                                        option_repaired.setAttribute("value", "Repaired");
                                        option_repaired.textContent = "Repaired";

                                        if (`${value}` == "Installed") {
                                            option_installed.setAttribute("selected", true);
                                        } else if (`${value}` == "Repaired") {
                                            option_repaired.setAttribute("selected", true);
                                        } else {
                                            option_available.setAttribute("selected", true);
                                        }

                                        select.appendChild(option_available);
                                        select.appendChild(option_installed);
                                        select.appendChild(option_repaired);

                                        div_select.appendChild(select);

                                        div.appendChild(label);
                                        div.appendChild(div_select);

                                        myform.appendChild(div);
                                        continue;
                                    } else if (`${key}` == "updated_at") {
                                        // UPDATED AT
                                        let div = document.createElement("div");
                                        div.setAttribute("class", "form-group row mb-1");

                                        let content = `${key}`.split("_");
                                        if (content.length > 1) {
                                            label_text = content[0].charAt(0).toUpperCase() + content[0].slice(1) + " " + content[1];
                                        } else {
                                            label_text = content[0].charAt(0).toUpperCase() + content[0].slice(1);
                                        }

                                        let label = document.createElement("label");
                                        label.setAttribute("class", "col-form-label col-xl-10 fw-bold");
                                        label.textContent = label_text;

                                        let div_input = document.createElement("div");
                                        div_input.setAttribute("class", "input-group col-xl-10");

                                        if (`${value}` == "null") {
                                            udpated_at_value = "";
                                        } else {
                                            let d = new Date(`${value}`);
                                            udpated_at_value = d.getFullYear() + "-" + addZero(d.getMonth() + 1) + "-" + addZero(d.getDate()) + " " + addZero(d.getHours()) + ":" + addZero(d.getMinutes()) + ":" + addZero(d.getSeconds());
                                        }

                                        let input = document.createElement("input");
                                        input.setAttribute("id", `${key + status}`);
                                        input.setAttribute("name", `${key + status}`);
                                        input.setAttribute("value", udpated_at_value);
                                        input.setAttribute("type", "text");
                                        input.setAttribute("class", "form-control");
                                        // input.setAttribute("placeholder", `${key}`);

                                        div_input.appendChild(input);
                                        div.appendChild(label);
                                        div.appendChild(div_input);

                                        myform.appendChild(div);
                                        continue;
                                    }

                                    // INPUT FORM GENERALLY
                                    printGeneralInputValue(`${key}`, `${value}`, status, myform);
                                    // let div = document.createElement("div");
                                    // div.setAttribute("class", "form-group row mb-1");

                                    // let content = `${key}`.split("_");
                                    // if (content.length > 1) {
                                    //     label_text = content[0].charAt(0).toUpperCase() + content[0].slice(1) + " " + content[1];
                                    // } else {
                                    //     label_text = content[0].charAt(0).toUpperCase() + content[0].slice(1);
                                    // }

                                    // let label = document.createElement("label");
                                    // label.setAttribute("class", "col-form-label col-xl-10 fw-bold");
                                    // label.textContent = label_text;

                                    // let div_input = document.createElement("div");
                                    // div_input.setAttribute("class", "input-group col-xl-10");

                                    // let input = document.createElement("input");
                                    // input.setAttribute("name", `${value}`);
                                    // input.setAttribute("value", (`${value}` != "null") ? `${value}` : "");
                                    // input.setAttribute("type", "text");
                                    // input.setAttribute("class", "form-control");
                                    // // input.setAttribute("placeholder", `${key}`);

                                    // div_input.appendChild(input);
                                    // div.appendChild(label);
                                    // div.appendChild(div_input);

                                    // myform.appendChild(div);

                                    // console.info(`${key}: ${value}`)
                                }
                            }



                            // for (const [key, value] of Object.entries(response_object)) {

                            //     let input = document.getElementById(`${key + status}`);
                            //     console.info(input);

                            //     if (`${value}` != "null") {
                            //         input.value = "";
                            //     } else {

                            //         if (`${key}` == "updated_at") {
                            //             let d = new Date(`${value}`);
                            //             input.value = d.getFullYear() + "-" + addZero(d.getMonth() + 1) + "-" + addZero(d.getDate()) + " " + addZero(d.getHours()) + ":" + addZero(d.getMinutes()) + ":" + addZero(d.getSeconds());
                            //         } else if (`${key}` === "emo_details") {

                            //         } else {
                            //             input.value = `${value}`;
                            //             // console.info(`${key}: ${value}`)
                            //         }
                            //     }

                            // }
                        } else {
                            alert("Equipment not found.")
                        }
                        showButtonSubmit()
                    }
                }
                ajax.send(`equipment=${search_input.value}`);
                event.preventDefault();
            }
        }


        enabledButtonSearchEquipment(search_equipment_install, button_search_install)
        enabledButtonSearchEquipment(search_equipment_dismantle, button_search_dismantle)

        getEquipment(search_equipment_install, button_search_install, "_install", install_form);
        getEquipment(search_equipment_dismantle, button_search_dismantle, "_dismantle", dismantle_form);
        // SEARCH FORM LOGIC

        // HIDE ALERT
        const alert_response = document.getElementById("alert_response");
        alert_response.onclick = () => {
            alert_response.style.display = "none";
        }

        // CHANGE VALUE OF SELECT INPUT START
        // setTimeout(function() {
        //     let selects = document.getElementsByTagName("select");
        //     for (let i = 0; i < selects.length; i++) {
        //         let select_value = selects[i].getAttribute("value");
        //         let options = selects[i].children;

        //         for (let j = 0; j < options.length; j++) {
        //             if (options[j].hasAttribute("value") && options[j].getAttribute("value") == select_value) {
        //                 options[j].setAttribute("selected", true);
        //             }
        //         }
        //     }
        // }, 1000)
        // CHANGE VALUE OF SELECT INPUT END
    </script>
</body>

</html>