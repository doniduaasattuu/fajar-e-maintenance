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
'updated_at'];
@endphp

@include('utility.prefix')
<div class="py-4">

    {{-- HEADER --}}
    @isset($motor)
    <div class="mb-3">
        @if ($motor->status != 'Installed')
        <h5 class="text-break lh-sm mb-0">{{ $motor->status }}</h5>
        @endif
        <h5 class="text-break lh-sm mb-0">{{ ($motor->sort_field != null) ? $motor->sort_field : '' }}</h5>
        <p class="text-break mb-0 text-secondary">{{ ($motor->description != null) ? $motor->description : '' }}</p>
        <p class="text-break lh-sm mb-0 text-secondary">{{ ($motor->funcloc != null) ? $motor->funcloc : '' }}</p>
        <p class="text-break lh-sm mb-0 text-secondary">{{ $motor->id . ' (' .$motor->unique_id .')' }}</p>
    </div>
    @endisset

    {{-- HEADER FOR RECORD EDIT --}}
    @isset($record)
    <div class="mb-3">
        <h4 class="text-break lh-sm">{{ $title }}</h4>
        <p class="text-break lh-sm mb-0 text-secondary">{{ $record->sort_field }}</p>
        <p class="text-break lh-sm mb-0 text-secondary">{{ $record->funcloc }}</p>
        <p class="text-break lh-sm mb-0 text-secondary">{{ $record->motor }}</p>
    </div>
    @endisset

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible" role="alert">
        <!-- The data you submitted is invalid. -->
        {{ $errors->first() }}
    </div>
    @endif

    {{-- ALERT SUCCESS CHECKING FORM --}}
    @isset($motor)
    @include('utility.alert-with-link')
    @endisset

    {{-- ALERT SUCCESS FOR UPDATE RECORD --}}
    @isset($record)
    @include('utility.alert')
    @endisset

    {{-- TREND --}}
    @isset($motor)
    <a href="/equipment-trend/{{ isset($motor) ? $motor->id : '' }}" title="Year to date">
        <button class="btn btn-success mb-2 text-white">
            <svg class="mb-1 me-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-graph-up" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M0 0h1v15h15v1H0V0Zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07Z" />
            </svg>
            <div class="d-inline fw-semibold">TRENDS</div>
        </button>
    </a>
    @endisset

    {{-- MOTOR DETAIL --}}
    @isset($motorDetail)
    @include('utility.motor-detail-accordion')
    @endisset

    <!-- ========================================= -->
    <!-- ========== CHECKING FORM START ========== -->
    <!-- ========================================= -->
    <form id="myform" action="{{ isset($action) ? $action :'/record-motor' }}" method="post" enctype="multipart/form-data"> <!-- CHECKING FORM -->
        @csrf

        {{-- DATA MOTOR SEND TO RECORD --}}
        @isset($motor)
        <input type="hidden" name="funcloc" id="funcloc" value="{{ isset($motor) ? $motor->funcloc : '' }}">
        <input type="hidden" name="motor" id="motor" value="{{ isset($motor) ? $motor->id : '' }}">
        <input type="hidden" name="sort_field" id="sort_field" value="{{ isset($motor) ? $motor->sort_field : '' }}">
        <input type="hidden" name="nik" id="nik" value="{{ session('nik') }}">
        @endisset

        {{-- DATA RECORD TO UPDATE --}}
        @isset($record)
        <input type="hidden" name="id" id="id" value="{{ isset($record) ? $record->id : '' }}">
        <input type="hidden" name="funcloc" id="funcloc" value="{{ isset($record) ? $record->funcloc : '' }}">
        <input type="hidden" name="motor" id="motor" value="{{ isset($record) ? $record->motor : '' }}">
        <input type="hidden" name="sort_field" id="sort_field" value="{{ isset($record) ? $record->sort_field : '' }}">
        <input type="hidden" name="nik" id="nik" value="{{ session('nik') }}">
        @endisset

        <div> <!-- MOTOR RECORD WRAPPER -->

            @foreach ($motorService->getColumns('motor_records', $skipped) as $column) <!-- MOTOR RECORD COLUMNS -->

            {{-- IMAGE FOR TEMPERATURE --}}
            @if ($loop->iteration == 5)
            @include('utility.image-temperature')
            @endif

            {{-- IMAGE FOR VIBRATION --}}
            @if ($loop->iteration == 8)
            @include('utility.image-vibration')
            @endif

            {{-- MOTOR STATUS --}}
            @switch($column)
            @case('motor_status')
            @case('cleanliness')
            @case('nipple_grease')
            @case('noise_de')
            @case('noise_nde')
            <div class="mb-3">
                <label for="{{ $column }}" class="fw-semibold form-label">{{ ucfirst(str_replace('_', ' ', $column)) }}</label>
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

            {{-- TEMPERATURE --}}
            @case('temperature_de')
            @case('temperature_body')
            @case('temperature_nde')
            @include('utility.temperature-input')
            @break

            {{-- VIBRATION --}}
            @case('vibration_de_vertical_value')
            @case('vibration_de_horizontal_value')
            @case('vibration_de_axial_value')
            @case('vibration_de_frame_value')
            @case('vibration_nde_vertical_value')
            @case('vibration_nde_horizontal_value')
            @case('vibration_nde_frame_value')
            @include('utility.vibration-input')
            @break

            @include('utility.errors')

            {{-- DEFAULT INPUT FORM --}}
            @default
            <div class="mb-3">
                <label for="{{ $column }}" class="fw-semibold form-label">{{ ucfirst(str_replace('_', ' ', $column)) }}</label>
                <input value="{{ isset($record) ? $record->$column : old($column) }}" inputmode="numeric" class="form-control" name="{{ $column }}" id="{{ $column }}" type="text" step="10" min="0" max="255" onkeypress="return onlynumber(event, 48, 57)" oninput="return preventmax(this.id, 255)" pattern="\d*" maxlength="4">
                @include('utility.error-help')
            </div>

            @endswitch
            @endforeach <!-- MOTOR RECORD COLUMNS -->

        </div> <!-- MOTOR RECORD WRAPPER -->

        {{-- FINDING FORM --}}
        @include('utility.finding-checking-form')

        {{-- BUTTON SUBMIT --}}
        @isset($motor)
        @if ($motor->status == 'Installed')
        <div>
            <input id="buttonSubmit" class="btn btn-primary" type="submit" value="Submit">
        </div>
        @endif
        @endisset

        {{-- BUTTON UPLOAD --}}
        @isset($record)
        <div>
            <input id="buttonSubmit" class="btn btn-primary" type="submit" value="Update">
        </div>
        @endisset

    </form> <!-- CHECKING FORM -->

</div>

{{-- IF MOTOR IS NOT INSTALLED FORM WILL BE DISABLED--}}
@isset($motor)
@if ($motor->status != 'Installed')
<script>
    for (input of myform) {
        input.setAttribute('disabled', true);
    }
</script>
@endif
@endisset

<!-- CHECKING FORM END -->
@include('utility.script.preventmax')
@include('utility.script.changevibrationdescriptioncolor')
@include('utility.script.onlynumber')
@include('utility.script.onlynumbercoma')
@include('utility.script.prevent-submit-form')

<script>
    // PREVENT SUBMIT ON ENTER
    let myform = document.getElementById('myform');
    preventSubmitForm(myform);

    window.onload = () => {
        let vibration_descriptions = document.getElementsByClassName('vibration_description');

        for (let i = 0; i < vibration_descriptions.length; i++) {
            if (vibration_descriptions[i].value == 'Good') {
                good(vibration_descriptions[i]);
            } else if (vibration_descriptions[i].value == 'Satisfactory') {
                satisfactory(vibration_descriptions[i]);
            } else if (vibration_descriptions[i].value == 'Unsatisfactory') {
                unsatisfactory(vibration_descriptions[i]);
            } else {
                unacceptable(vibration_descriptions[i]);
            }
        }
    }

    // CHANGE COLOR ON SELECT CHANGED
    let vibration_descriptions = document.getElementsByClassName('vibration_description');
    for (let i = 0; i < vibration_descriptions.length; i++) {
        vibration_descriptions[i].onchange = () => {
            select = vibration_descriptions[i];

            switch (select.value) {
                case 'Good':
                    good(select)
                    break;

                case 'Satisfactory':
                    satisfactory(select)
                    break;

                case 'Unsatisfactory':
                    unsatisfactory(select)
                    break;

                default:
                    unacceptable(select)
                    break;
            }
        }
    }

    // DELETE NUMBER OF GREASING WHEN NIPPLE GREASE IS NOT AVAILABLE
    let nipple_grease = document.getElementById('nipple_grease');
    let number_of_greasing = document.getElementById('number_of_greasing');

    nipple_grease.onchange = () => {
        if (nipple_grease.value !== 'Available') {
            number_of_greasing.value = '';
        }
    }
</script>

@include('utility.suffix')