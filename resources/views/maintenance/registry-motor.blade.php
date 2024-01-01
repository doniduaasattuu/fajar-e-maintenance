<!DOCTYPE html>
<html lang="en">

@include('utility.head')

<body>

    @include('utility.navbar')

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

    <div class="container py-4">
        <h4 class="text-secondary mb-4">{{ $title }}</h4>
        <form id="registry_motor" action="/registry-motor" method="post">
            @csrf

            <div class="form-group row mb-3">
                <label class="col-form-label col-xl-2 fw-bold">Emo *</label>
                <div class="col-xl-10">
                    <input name="id" id="id" type="text" class="form-control">
                </div>
            </div>

            @foreach ($columns as $column)
            @if ($column == 'id' || $column == 'created_at' || $column == 'updated_at' )
            @continue

            @elseif ($column == 'status')
            <!-- IF STATUS_MOTOR -->
            <div class="form-group row mb-3">
                <label class="col-form-label col-xl-2 fw-bold">{{ str_replace("_", " ", ucwords($column)) }} *</label>
                <div class="col-xl-10">
                    <select name="{{ $column }}" id="{{ $column }}" class="form-select" aria-label="Default select example">
                        <option value="Repaired">Repaired</option>
                        <option value="Installed">Installed</option>
                        <option value="Available">Available</option>
                    </select>
                </div>
            </div>

            <!-- IMPORTANT ON EMOS TABLE -->
            @elseif ($column == 'equipment_description' || $column == 'emo_detail' || $column == 'unique_id' || $column == 'qr_code_link')
            <div class="form-group row mb-3">
                <label class="col-form-label col-xl-2 fw-bold">{{ str_replace("_", " ", ucwords($column)) }} *</label>
                <div class="col-xl-10">
                    @if ($column == 'unique_id')
                    <input onkeypress="return onlynumber(event)" name="{{ $column }}" id="{{ $column }}" type="text" class="form-control">
                    @else
                    <input name="{{ $column }}" id="{{ $column }}" type="text" class="form-control">
                    @endif
                </div>
            </div>
            <!-- IMPORTANT ON EMOS TABLE -->

            <!-- EMO DETAIL ENUM -->
            <!-- ======================================================================== -->
            @elseif ($column == "power_unit")
            <!-- POWER UNIT -->
            <div class="form-group row mb-3">
                <label class="col-form-label col-xl-2 fw-bold">{{ str_replace("_", " ", ucwords($column)) }}</label>
                <div class="col-xl-10">
                    <select name="{{ $column }}" id="{{ $column }}" class="form-select" aria-label="Default select example">
                        <option value="kW">kW</option>
                        <option value="HP">HP</option>
                    </select>
                </div>
            </div>
            <!-- ======================================================================== -->

            <!-- ======================================================================== -->
            @elseif ($column == "nipple_grease")
            <!-- NIPPLE GREASE -->
            <div class="form-group row mb-3">
                <label class="col-form-label col-xl-2 fw-bold">{{ str_replace("_", " ", ucwords($column)) }}</label>
                <div class="col-xl-10">
                    <select name="{{ $column }}" id="{{ $column }}" class="form-select" aria-label="Default select example">
                        <option value="Available">Available</option>
                        <option value="Not Available">Not Available</option>
                    </select>
                </div>
            </div>
            <!-- ======================================================================== -->

            <!-- ======================================================================== -->
            @elseif ($column == "cooling_fan")
            <!-- COOLING FAN -->
            <div class="form-group row mb-3">
                <label class="col-form-label col-xl-2 fw-bold">{{ str_replace("_", " ", ucwords($column)) }}</label>
                <div class="col-xl-10">
                    <select name="{{ $column }}" id="{{ $column }}" class="form-select" aria-label="Default select example">
                        <option value="Internal">Internal</option>
                        <option value="External">External</option>
                        <option value="Not Available">Not Available</option>
                    </select>
                </div>
            </div>

            @elseif ($column == 'mounting')
            <!-- MOUNTING -->
            <div class="form-group row mb-3">
                <label class="col-form-label col-xl-2 fw-bold">{{ str_replace("_", " ", ucwords($column)) }}</label>
                <div class="col-xl-10">
                    <select name="{{ $column }}" id="{{ $column }}" class="form-select" aria-label="Default select example">
                        <option value="Horizontal">Horizontal</option>
                        <option value="Vertical">Vertical</option>
                        <option value="V/H">V/H</option>
                        <option value="MGM">MGM</option>
                    </select>
                </div>
            </div>

            <!-- EMO DETAIL ENUM -->

            @else
            <!-- NOT ENUM TYPE -->
            <div class="form-group row mb-3">
                <label class="col-form-label col-xl-2 fw-bold">{{ str_replace("_", " ", ucwords($column)) }}</label>
                <div class="col-xl-10">
                    @if (
                    $column == 'voltage' ||
                    $column == 'frequency' ||
                    $column == 'rpm' ||
                    $column == 'phase_supply' ||
                    $column == 'material_number' )
                    <input onkeypress="return onlynumber(event)" name="{{ $column }}" id="{{ $column }}" type="text" class="form-control">
                    @elseif ( $column == 'shaft_diameter' || $column == 'length' || $column == 'width' || $column == 'height' )
                    <input onkeypress="return onlynumber(event)" name="{{ $column }}" id="{{ $column }}" type="text" class="form-control" placeholder="mm">
                    @elseif ( $column == 'greasing_qty_de' || $column == 'greasing_qty_nde')
                    <input onkeypress="return onlynumber(event)" name="{{ $column }}" id="{{ $column }}" type="text" class="form-control" placeholder="grams">
                    @elseif ( $column == 'weight')
                    <input onkeypress="return onlynumber(event)" name="{{ $column }}" id="{{ $column }}" type="text" class="form-control" placeholder="kilograms">
                    @elseif ( $column == 'power_rate' || $column == 'cos_phi' || $column == 'efficiency' || $column == 'current_nominal' || $column == 'pole')
                    <input onkeypress="return onlynumbercommaper(event)" name="{{ $column }}" id="{{ $column }}" type="text" class="form-control">
                    @else
                    <input name="{{ $column }}" id="{{ $column }}" type="text" class="form-control">
                    @endif
                </div>
            </div>
            <!-- NOT ENUM TYPE -->
            @endif

            @endforeach

            <div>
                <button type="button" class="mt-2 mb-4 btn btn-primary">
                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                        <path d="M11 2H9v3h2V2Z" />
                        <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0ZM1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5Zm3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4v4.5ZM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5V15Z" />
                    </svg>
                    Save
                </button>
            </div>

        </form>
    </div>

    <script>
        let myForm = document.getElementById('registry_motor');
        let id = document.getElementById('id');
        let emo_detail = document.getElementById('emo_detail');
        let unique_id = document.getElementById('unique_id');
        let qr_code_link = document.getElementById('qr_code_link');

        for (let a of myForm) {
            alert(a)
        }

        unique_id.oninput = () => {
            qr_code_link.value = '';
            qr_code_link.value = 'https://www.safesave.info/MIC.php?id=Fajar-MotorList' + unique_id.value;
        }

        id.oninput = () => {
            emo_detail.value = '';
            emo_detail.value = id.value;
        }

        id.onchange = () => {
            if (id.value.length != 9) {
                alert('Equipment is invalid');
            } else {
                let ajax = new XMLHttpRequest();
                ajax.open('POST', '/emo-check')
                ajax.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}')
                ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')

                ajax.onload = () => {
                    if (ajax.readyState == 4) {
                        if (ajax.responseText == 'Equipment is already registered') {
                            alert(ajax.responseText);
                            id.value = id.value.slice(0, 3)
                            emo_detail.value = id.value;
                        }
                    }
                }
                ajax.send(`emo=${id.value}`)
            }
        }

        unique_id.onchange = () => {
            if (unique_id.value.length < 1) {
                alert('Unique ID is invalid');
            } else {
                let ajax = new XMLHttpRequest();
                ajax.open('POST', '/unique-id-check')
                ajax.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}')
                ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')

                ajax.onload = () => {
                    if (ajax.readyState == 4) {
                        if (ajax.responseText == 'Unique id is already registered') {
                            alert(ajax.responseText);
                            unique_id.value = '';
                            qr_code_link.value = unique_id.value
                        }
                    }
                }
                ajax.send(`unique_id=${unique_id.value}`)
            }
        }

        emo_detail.onfocus = () => {
            emo_detail.value = id.value;
        }
        // ONLY NUMBER
        function onlynumber(evt) {
            let ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }

        // ONLY NUMBER COMMA
        function onlynumbercomma(evt) {
            let ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57) && ASCIICode != 46)
                return false;
            return true;
        }

        // ONLY NUMBER COMMA
        function onlynumbercommaper(evt) {
            let ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 46 || ASCIICode > 57))
                return false;
            return true;
        }
    </script>
</body>

</html>