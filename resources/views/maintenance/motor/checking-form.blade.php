@php
$skipped = [
'id',
'funcloc',
'motor',
'sort_field',
'vibration_de_vertical_desc',
'vibration_de_horizontal_desc',
'vibration_de_axial_desc',
'vibration_de_frame_desc',
'vibration_nde_vertical_desc',
'vibration_nde_horizontal_desc',
'vibration_nde_frame_desc',
'nik',
'created_at',
'updated_at']
@endphp

@include('utility.prefix')
<div class="py-4">

    <!-- HEADER  -->
    <div class="mb-3">
        <h5 class="text-break lh-sm mb-0">C.06/PM3</h5>
        <p class="text-break mb-0 text-secondary">AC 380V,4P,105A,55kW</p>
        <p class="text-break lh-sm mb-0 text-secondary">FP-01-SP3-P098</p>
        <p class="text-break lh-sm mb-0 text-secondary">EMO000426</p>
    </div>

    <!-- TRENDS -->
    <form action="/equipment-trends" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="sort_field" name="sort_field" value="@{{ $motor->sort_field }}">
        <input type="hidden" id="equipment_id" name="equipment_id" value="@{{ $equipment_id }}">
        <input type="hidden" id="funcloc" name="funcloc" value="@{{ $motor->funcloc }}">
        <button class="btn btn-success fw-bold mb-2 text-white">
            <svg class="mb-1 me-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-graph-up" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M0 0h1v15h15v1H0V0Zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07Z" />
            </svg>
            <div class="d-inline fw-semibold">TRENDS</div>
        </button>
    </form>

    @include('utility.motor-detail-accordion')

    <!-- ========================================= -->
    <!-- ========== CHECKING FORM START ========== -->
    <!-- ========================================= -->
    <form id="myform" action="/checking-form/@{{ $motor->id }}" method="post"> <!-- CHECKING FORM -->
        @csrf

        <div> <!-- MOTOR RECORD WRAPPER -->

            @foreach ($motorService->getColumns('motor_records', $skipped) as $column) <!-- MOTOR RECORD COLUMNS -->
            @switch($column)

            {{-- MOTOR STATUS --}}
            @case('motor_status')
            @case('cleanliness')
            @case('nipple_grease')
            @case('noise_de')
            @case('noise_nde')
            <div class="mb-3">
                <label for="{{ $column }}" class="fw-bold form-label">{{ ucfirst(str_replace('_', ' ', $column)) }}</label>
                <select name="{{ $column }}" id="{{ $column }}" class="form-select" aria-label="Default select example">
                    @switch($column)

                    @case('motor_status')
                    @include('utility.looping-option', ['array' => $motorService->motorStatusEnum()])
                    @break

                    @case('cleanliness')
                    @include('utility.looping-option', ['array' => $motorService->cleanlinessEnum()])
                    @break

                    @case('nipple_grease')
                    @include('utility.looping-option', ['array' => $motorService->nippleGreaseEnum()])
                    @break

                    @case('noise_de')
                    @case('noise_nde')
                    @include('utility.looping-option', ['array' => $motorService->noiseEnum()])
                    @break

                    @default
                    <option></option>
                    @endswitch

                </select>
                @include('utility.error-help')
            </div>
            @break

            @once
            <div>
                <h3>Hello world</h3>
            </div>
            @endonce

            {{-- TEMPERATURE --}}
            @case('temperature_de')
            <div class="mb-3">
                <div class="row mb-3">

                    <!-- IMAGE LEFT SIDE -->
                    <div class="col-sm">
                        <figure>
                            <img class="img-fluid" src="/storage/assets/images/left-side.jpeg" alt="Left Side">
                            <figcaption class="figure-caption text-center">Left side</figcaption>
                        </figure>
                    </div>

                    <!-- IMAGE FRONT SIDE -->
                    <div class="col-sm">
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
            </div>

            @include('utility.temperature-input')
            @break

            {{-- TEMPERATURE --}}
            @case('temperature_body')
            @case('temperature_nde')
            @include('utility.temperature-input')
            @break

            {{-- VIBRATION --}}
            @case('vibration_de_vertical_value')
            <div class="mb-3">
                <div class="row">
                    <!-- IMAGE VIBRATION SEVERITY TABLE -->
                    <div class="col-sm">
                        <figure>
                            <img class="img-fluid mx-auto d-block" src="/storage/assets/images/vibration-iso-10816.jpg" alt="Vibration">
                            <figcaption id="figcaption_vibrations" class="figure-caption text-center">Vibration standard</figcaption>
                        </figure>
                    </div>
                    <!-- IMAGE VIBRATION INSPECTION GUIDE -->
                    <div class="col-sm">
                        <figure>
                            <img class="img-fluid mx-auto d-block" src="/storage/assets/images/vibration-inspection-guide.png" alt="Vibration inspection guide">
                            <figcaption id="figcaption_vibration" class="figure-caption text-center">Vibration inspection guide</figcaption>
                        </figure>
                    </div>
                </div>
            </div>


            @include('utility.vibration-input')
            @break

            {{-- VIBRATION --}}
            @case('vibration_de_horizontal_value')
            @case('vibration_de_axial_value')
            @case('vibration_de_frame_value')
            @case('vibration_nde_vertical_value')
            @case('vibration_nde_horizontal_value')
            @case('vibration_nde_frame_value')
            @include('utility.vibration-input')
            @break

            {{-- DEFAULT INPUT FORM --}}
            @default
            <div class="mb-3">
                <label for="{{ $column }}" class="fw-bold form-label">{{ ucfirst(str_replace('_', ' ', $column)) }}</label>
                <input inputmode="numeric" class="form-control" name="{{ $column }}" id="{{ $column }}" type="text" step="10" min="0" max="255" onkeypress="return onlynumber(event, 48, 57)" pattern="\d*" maxlength="4">
                @include('utility.error-help')
            </div>

            @endswitch
            @endforeach <!-- MOTOR RECORD COLUMNS -->

        </div> <!-- MOTOR RECORD WRAPPER -->

        <!-- BUTTON SUBMIT -->
        <div>
            <input id="buttonSubmit" class="btn btn-primary" type="button" value="Submit">
        </div>
    </form> <!-- CHECKING FORM -->

</div>
<!-- CHECKING FORM END -->
@include('utility.script.onlynumber')
@include('utility.script.onlynumbercoma')
@include('utility.suffix')