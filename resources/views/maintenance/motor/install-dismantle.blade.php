<x-app-layout>

    <section>
        <x-breadcumb-table :title='$title' :table="'Motors'" :action='"Instal dismantle"' />
        <x-alert-info :information='["Only installed motors can be dismantled.", "Only available motors can be installed.", "Dismantled motor automatically changes status to repair."]' />
    </section>

    <section>
        <form id="installDismantleForm" action="/motor-install-dismantle" method="post">
            @csrf

            <div class="row">

                <!-- FORM DISMANTLED -->
                <div class="pe-1 col">
                    <div>
                        <!-- SEARCH FORM -->
                        <div class="form-group row mb-3">
                            <!-- LABEL -->
                            <label for="equipment_to_dismantle" class="col-form-label col-xl-10 fw-semibold">
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
                            <label for="equipment_to_install" class="col-form-label col-xl-10 fw-semibold">
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
            <div id="do_install_dismantle" class="d-none mt-2 mb-3">
                <button class="w-100 py-2 btn btn-danger">
                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5m14-7a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H14.5a.5.5 0 0 1 .5.5" />
                    </svg>
                    Swap
                </button>
            </div>

        </form>
    </section>

</x-app-layout>