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
                            <input name="search_equipment" id="search_equipment_dismantle" type="text" class="form-control" placeholder="Equipment">
                            <button disabled id="button_search_dismantle" class="btn btn-primary">
                                <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <!-- SEARCH FORM -->

                    <div id="dismantled_form">
                        <!-- DATA -->
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

                        <!-- INPUT ID -->
                        <input name="id" id="id_dismantle" type="hidden" class="form-control" placeholder="Equipment">
                        <!-- INPUT ID -->

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

                        <div class="d-flex">
                            <button type="submit" class="ms-auto mt-3 btn btn-primary">
                                <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                                    <path d="M11 2H9v3h2V2Z" />
                                    <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0ZM1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5Zm3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4v4.5ZM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5V15Z" />
                                </svg>
                                Save
                            </button>
                        </div>
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
                            <input name="search_equipment_install" id="search_equipment_install" type="text" class="form-control" placeholder="Equipment">
                            <button disabled id="button_search_install" class="btn btn-primary">
                                <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <!-- SEARCH FORM -->

                    <form action="/update-equipment" method="post">
                        @csrf
                        <!-- DATA -->
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

                        <!-- INPUT ID -->
                        <input name="id" id="id_install" type="hidden" class="form-control" placeholder="Equipment">
                        <!-- INPUT ID -->

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

                        <div class="d-flex">
                            <button type="submit" class="ms-auto mt-3 btn btn-primary">
                                <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                                    <path d="M11 2H9v3h2V2Z" />
                                    <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0ZM1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5Zm3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4v4.5ZM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5V15Z" />
                                </svg>
                                Save
                            </button>
                        </div>
                        <!-- DATA -->
                    </form>
                </div>
            </div>
            <!-- FORM DISMANTLED -->
        </div>
    </div>


    <script>
        // SEARCH FORM LOGIC
        const dismantled_form = document.getElementById("dismantled_form");
        for (let i = 0; i < dismantled_form.children.length; i++) {
            console.info(dismantled_form.children[i].value);
        }
        console.info(dismantled_form.children);

        const search_equipment_dismantle = document.getElementById("search_equipment_dismantle");
        const button_search_dismantle = document.getElementById("button_search_dismantle");
        const search_equipment_install = document.getElementById("search_equipment_install");
        const button_search_install = document.getElementById("button_search_install");

        function enabledButtonSearchEquipment(search_input, button_search) {
            search_input.oninput = () => {
                if (search_input.value.length == 9) {
                    button_search.removeAttribute("disabled");
                } else {
                    button_search.setAttribute("disabled", true);
                }
            }
        }

        function getEquipment(search_input, button_search, status) {
            button_search.onclick = () => {
                const ajax = new XMLHttpRequest();
                ajax.open("POST", "/equipment");
                ajax.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
                ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                ajax.onload = () => {
                    if (ajax.readyState == 4) {

                        if (ajax.responseText.length != 6) {

                            let response_string = JSON.parse(ajax.responseText);
                            let response_object = JSON.parse(response_string);

                            for (const [key, value] of Object.entries(response_object)) {
                                if (`${key}` == "updated_at") {
                                    continue;
                                } else {
                                    let input = document.getElementById(`${key + status}`);
                                    if (`${value}` == "null") {
                                        input.value = "";
                                    } else {
                                        input.value = `${value}`;
                                    }
                                    // console.info(`${key}: ${value}`)
                                }
                            }
                        } else {
                            alert("Equipment not found.")
                        }

                    }
                }
                ajax.send(`equipment=${search_input.value}`);
            }
        }


        enabledButtonSearchEquipment(search_equipment_install, button_search_install)
        enabledButtonSearchEquipment(search_equipment_dismantle, button_search_dismantle)

        getEquipment(search_equipment_install, button_search_install, "_install");
        getEquipment(search_equipment_dismantle, button_search_dismantle, "_dismantle");
        // SEARCH FORM LOGIC

        // HIDE ALERT
        const alert_response = document.getElementById("alert_response");
        alert_response.onclick = () => {
            alert_response.style.display = "none";
        }
    </script>
</body>

</html>