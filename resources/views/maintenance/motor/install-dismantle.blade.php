@include('utility.prefix')

<div class="py-4">

    <div class="mb-3">
        <h3 class="mb-1">{{ $title }}</h3>
        <nav aria-label=" breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/motors">Table</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>

    <form id="installDismantleForm" action="/motor-install-dismantle" method="post">
        @csrf

        <div class="row">

            <!-- FORM DISMANTLED -->
            <div class="pe-1 col">
                <div>
                    <!-- SEARCH FORM -->
                    <div class="form-group row mb-3">
                        <!-- LABEL -->
                        <label for="equipment_to_dismantle" class="col-form-label col-xl-10 fw-bold">
                            <svg class="mb-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#dc3545" class="bi bi-box-arrow-up" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M3.5 6a.5.5 0 0 0-.5.5v8a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5v-8a.5.5 0 0 0-.5-.5h-2a.5.5 0 0 1 0-1h2A1.5 1.5 0 0 1 14 6.5v8a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 14.5v-8A1.5 1.5 0 0 1 3.5 5h2a.5.5 0 0 1 0 1z" />
                                <path fill-rule="evenodd" d="M7.646.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 1.707V10.5a.5.5 0 0 1-1 0V1.707L5.354 3.854a.5.5 0 1 1-.708-.708z" />
                            </svg>
                            Dismantle
                        </label>
                        <!-- INPUT -->
                        <div class="input-group col-xl-10">
                            <input id="equipment_to_dismantle" oninput="return toupper(this)" maxlength="9" type="text" class="form-control pe-0" style="border-width: 1px; border-color: #dc3545" placeholder="Equipment">
                            <div id="button_search_dismantle" class="btn btn-danger">
                                <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="form-text">Dismantled equipment.</div>
                    </div>
                    <!-- SEARCH FORM -->

                    <div id="dismantle_form">
                        <!-- DATA RENDER HERE -->
                    </div>
                </div>
            </div>
            <!-- FORM DISMANTLED -->

            <!-- ================================================================================================================================================================================ -->

            <!-- FORM INSTALLED START -->
            <div class="ps-1 col">
                <div>
                    <!-- SEARCH FORM -->
                    <div class="form-group row mb-3">
                        <!-- LABEL -->
                        <label for="equipment_to_install" class="col-form-label col-xl-10 fw-bold">
                            <svg class="mb-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#0d6efd" class="bi bi-box-arrow-in-down" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M3.5 6a.5.5 0 0 0-.5.5v8a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5v-8a.5.5 0 0 0-.5-.5h-2a.5.5 0 0 1 0-1h2A1.5 1.5 0 0 1 14 6.5v8a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 14.5v-8A1.5 1.5 0 0 1 3.5 5h2a.5.5 0 0 1 0 1z" />
                                <path fill-rule="evenodd" d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z" />
                            </svg>
                            Install
                        </label>
                        <!-- INPUT -->
                        <div class="input-group col-xl-10">
                            <input id="equipment_to_install" oninput="return toupper(this)" maxlength="9" type="text" class="form-control pe-0" style="border-width: 1px; border-color: #0d6efd" placeholder="Equipment">
                            <div id="button_search_install" class="btn btn-primary">
                                <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="form-text">Installed equipment.</div>
                    </div>
                    <!-- SEARCH FORM -->

                    <div id="install_form">
                        <!-- DATA RENDER HERE -->
                    </div>
                </div>
            </div>
            <!-- FORM INSTALLED -->
        </div>

        <!-- BUTTON SUBMIT -->
        <div id="do_install_dismantle" class="d-none mb-3">
            <button class="w-100 btn btn-primary">
                <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5m14-7a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H14.5a.5.5 0 0 1 .5.5" />
                </svg>
                Swap
            </button>
        </div>

    </form>
</div>

@include('utility.script.prevent-submit-form')
<script>
    let installDismantleForm = document.getElementById('installDismantleForm');
    preventSubmitForm(installDismantleForm);

    // RENDER DATA
    let dismantle_form = document.getElementById('dismantle_form');
    let install_form = document.getElementById('install_form');

    // INPUT FORM
    let equipment_to_dismantle = document.getElementById('equipment_to_dismantle');
    let equipment_to_install = document.getElementById('equipment_to_install');

    // BUTTON DISMANTLE
    let button_search_dismantle = document.getElementById('button_search_dismantle');
    button_search_dismantle.onclick = () => {
        doAjaxRequest(dismantle_form, equipment_to_dismantle, 'Installed');
    }

    // BUTTON INSTALL
    let button_search_install = document.getElementById('button_search_install');
    button_search_install.onclick = () => {
        doAjaxRequest(install_form, equipment_to_install, 'Available');
    }

    // DO REQUEST
    function doAjaxRequest(form, input, status) {
        removeAllChildren(form)
        if (input.value.length == 9) {
            createAjaxRequest(input, '/equipment-motor', form, status)
        }
        setTimeout(() => {
            enableButtonSubmit();
        }, 1000);
    }
</script>

<script>
    // GET MOTOR USING AJAX
    function createAjaxRequest(input, url, form, status) {

        ajax = new XMLHttpRequest();
        ajax.open("POST", url);
        ajax.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        ajax.onload = () => {
            if (ajax.readyState == 4) {
                let response_object = JSON.parse(ajax.responseText);

                if (response_object.id !== undefined) {
                    for (const [key, value] of Object.entries(response_object)) {

                        //  RENDER DATA
                        if (key == 'motor_detail' && value != null) {
                            for (const [detail_key, detail_value] of Object.entries(value)) {

                                // CREATE ELEMENT MOTOR DETAIL
                                if (
                                    detail_key == 'id' ||
                                    detail_key == 'motor_detail' ||
                                    detail_key == 'created_at' ||
                                    detail_key == 'updated_at'
                                ) {
                                    continue;
                                } else {
                                    createElement(form, detail_key, detail_value);
                                }
                            }
                        } else {

                            // CREATE ELEMENT MOTOR
                            if (key == 'motor_detail' && value == null) {
                                continue;
                            } else if (key == 'created_at' || key == 'updated_at') {
                                continue;
                            } else if (key == 'qr_code_link') {
                                createElement(form, key, value.split('=')[1]);
                            } else {
                                createElement(form, key, value);
                            }
                        }
                    }
                } else {

                    // CREATE ALERT
                    createAlert(form, 'Not found.');
                }

            }
        }


        ajax.send(`equipment=${input.value}&status=${status}`);
    }
</script>

<script>
    function myucfirst(words) {
        const firstString = words.charAt(0);
        const firstStringCap = firstString.toUpperCase();
        const remainingLetters = words.slice(1);
        const result = firstStringCap + remainingLetters;
        return result;
    }

    function createElement(form, key, value) {
        let div = document.createElement('div');
        div.setAttribute('class', 'mb-3');

        let label = document.createElement('label');
        label.setAttribute('class', 'fw-semibold form-label');
        label.textContent = myucfirst(key).split('_').join(' ');

        let input = document.createElement('input');
        input.setAttribute('class', 'form-control');
        input.setAttribute('value', value ?? '');
        input.setAttribute('readonly', true);
        if (key == 'id') {
            switch (form.id) {
                case 'dismantle_form':
                    input.setAttribute('name', key + '_dismantle');
                    break;
                case 'install_form':
                    input.setAttribute('name', key + '_install');
                    break;
            }
        }

        div.appendChild(label)
        div.appendChild(input)
        form.appendChild(div);
    }

    function removeAllChildren(parent) {
        while (parent.firstChild) {
            parent.removeChild(parent.firstChild);
        }
    }

    function createAlert(form, message) {
        let alert = document.createElement('div');
        alert.setAttribute('class', 'alert alert-primary alert-dismissible');
        alert.setAttribute('role', 'alert');
        alert.textContent = message;
        form.appendChild(alert);
    }

    // function enableButton(input) {
    //     let buttonSearch = input.nextElementSibling;
    //     let svg = buttonSearch.firstElementChild
    //     if (input.value.length == 9) {
    //         svg.classList.remove('d-none');
    //     }
    // }

    // window.onload = () => {
    //     doAjaxRequest(dismantle_form, equipment_to_dismantle, 'Installed');
    //     doAjaxRequest(install_form, equipment_to_install, 'Available');
    // }

    function enableButtonSubmit() {

        let buttonSubmit = do_install_dismantle;
        let dismantledEquipment = dismantle_form.firstElementChild?.lastElementChild ?? null;
        let installedEquipment = install_form.firstElementChild?.lastElementChild ?? null;
        let installDismantleForm = document.getElementById('installDismantleForm');

        if (dismantledEquipment != null && installedEquipment != null) {
            buttonSubmit.classList.remove('d-none');
        } else {
            buttonSubmit.classList.add('d-none');
        }

    }
</script>

@include('utility.suffix')