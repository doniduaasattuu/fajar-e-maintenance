<div class="form-group row mb-3">
    <label for="install_input" class="col-form-label col-xl-10 fw-semibold">
        <svg class="mb-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#0d6efd" class="bi bi-box-arrow-in-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M3.5 6a.5.5 0 0 0-.5.5v8a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5v-8a.5.5 0 0 0-.5-.5h-2a.5.5 0 0 1 0-1h2A1.5 1.5 0 0 1 14 6.5v8a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 14.5v-8A1.5 1.5 0 0 1 3.5 5h2a.5.5 0 0 1 0 1z" />
            <path fill-rule="evenodd" d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z" />
        </svg>
        Install
    </label>

    <div class="input-group col-xl-10">
        <x-input-text id="install_input" name="install_input" status="Available" oninput="return JS.toupper(this)" class="pe-0" maxlength="9" style="border-width: 1px; border-color: #0d6efd" placeholder="Equipment" />
        <div id="install_button" class="btn btn-primary">
            <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
            </svg>
        </div>
    </div>
    <div class="form-text">
        {{ $slot }}
    </div>
</div>