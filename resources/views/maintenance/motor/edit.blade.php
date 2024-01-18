@php
$motorDetail = $motor->MotorDetail;
@endphp
<!-- =========================== FOR EDIT MOTOR PAGE START ========================== -->
<form action="/{{ $action }}" method="post" id="forms">
    @csrf
    @foreach ($motorService->getTableColumns() as $column) <!-- FORM MOTOR -->
    <div class="mb-3">
        @switch($column)

        @case('updated_at')
        @break

        @case('id')
        <label for="{{ $column }}" class="form-label fw-semibold">Motor</label>
        <input value="{{ $motor->$column }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="9" class="form-control">
        @break

        @case('status')
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <select value="{{ $motor->$column }}" id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">
            @foreach ($motorService->statusEnum() as $status )

            @if ($status == $motor->status)
            <option selected value="{{ $status }}">{{ $status }}</option>
            @else
            <option value="{{ $status }}">{{ $status }}</option>
            @endif

            @endforeach
        </select>
        @break

        @case('material_number')
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <input value="{{ $motor->$column }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="8" class="form-control" onkeypress="return onlynumber(event)">
        @break

        @case('unique_id')
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <input readonly value="{{ $motor->$column }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="6" class="form-control" onkeypress="return onlynumber(event)">
        @break

        @case('qr_code_link')
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <input readonly value="{{ $motor->$column }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="9" class="form-control">
        @break

        @default
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <input @readonly($column=='created_at' ) value="{{ $column == 'created_at' ? Carbon\Carbon::now() : $motor->$column }}" value="{{ $motor->$column }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="50" class="form-control">
        @endswitch
        @include('utility.error-help')
    </div>
    @endforeach <!-- FORM MOTOR -->

    <!-- MOTOR DETAILS -->
    @if ($motorDetail !== null)
    @foreach ($motorService->getColumns('motor_details') as $column) <!-- FORM MOTOR DETAILS -->
    <div class="mb-3">
        @switch($column)

        @case('id')
        @break

        @case('power_rate')
        @case('voltage')
        @case('curent_nominal')
        @case('frequency')
        @case('pole')
        @case('rpm')
        @case('shaft_diameter')
        @case('cos_phi')
        @case('efficiency')
        @case('ip_rating')
        @case('greasing_qty_de')
        @case('greasing_qty_nde')
        @case('length')
        @case('width')
        @case('height')
        @case('weight')
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <input onkeypress="return onlynumber(event)" value="{{ $motorDetail->$column }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="10" class="form-control">
        @break

        @case('power_unit')
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <select value="{{ $motorDetail->$column }}" id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">
            @foreach ($motorService->powerUnitEnum() as $status )
            @if ($status == $motorDetail->$column)
            <option selected value="{{ $status }}">{{ $status }}</option>
            @else
            <option value="{{ $status }}">{{ $status }}</option>
            @endif
            @endforeach
        </select>
        @break

        @case('electrical_current')
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <select value="{{ $motorDetail->$column }}" id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">
            @foreach ($motorService->electricalCurrentEnum() as $status )
            @if ($status == $motorDetail->$column)
            <option selected value="{{ $status }}">{{ $status }}</option>
            @else
            <option value="{{ $status }}">{{ $status }}</option>
            @endif
            @endforeach
        </select>
        @break

        @case('nipple_grease')
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <select value="{{ $motorDetail->$column }}" id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">
            @foreach ($motorService->nippleGreaseEnum() as $status )
            @if ($status == $motorDetail->$column)
            <option selected value="{{ $status }}">{{ $status }}</option>
            @else
            <option value="{{ $status }}">{{ $status }}</option>
            @endif
            @endforeach
        </select>
        @break

        @case('cooling_fan')
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <select value="{{ $motorDetail->$column }}" id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">
            @foreach ($motorService->coolingFanEnum() as $status )
            @if ($status == $motorDetail->$column)
            <option selected value="{{ $status }}">{{ $status }}</option>
            @else
            <option value="{{ $status }}">{{ $status }}</option>
            @endif
            @endforeach
        </select>
        @break

        @case('mounting')
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <select id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">
            @foreach ($motorService->mountingEnum() as $status )
            @if ($status == $motorDetail->$column)
            <option selected value="{{ $status }}">{{ $status }}</option>
            @else
            <option value="{{ $status }}">{{ $status }}</option>
            @endif
            @endforeach
        </select>
        @break

        @default
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <input @readonly($column=='updated_at' ||$column=='created_at' ) value="{{ ($column == 'created_at' || $column == 'updated_at') ? Carbon\Carbon::now() : $motorDetail->$column }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="50" class="form-control">
        @endswitch

        @include('utility.error-help')
    </div>
    @endforeach <!-- FORM MOTOR DETAILS -->
    @endif
    <!-- MOTOR DETAILS -->


    <!-- MOTOR DETAILS -->
    @unless ($motorDetail)
    @foreach ($motorService->getColumns('motor_details') as $column) <!-- FORM MOTOR DETAILS -->
    <div class="mb-3">
        @switch($column)

        @case('id')
        @case('motor_detail')
        @break

        @case('power_rate')
        @case('voltage')
        @case('curent_nominal')
        @case('frequency')
        @case('pole')
        @case('rpm')
        @case('shaft_diameter')
        @case('cos_phi')
        @case('efficiency')
        @case('ip_rating')
        @case('greasing_qty_de')
        @case('greasing_qty_nde')
        @case('length')
        @case('width')
        @case('height')
        @case('weight')
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <input onkeypress="return onlynumber(event)" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="10" class="form-control">
        @break

        @case('power_unit')
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <select id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">
            @foreach ($motorService->powerUnitEnum() as $status )
            <option value="{{ $status }}">{{ $status }}</option>
            @endforeach
        </select>
        @break

        @case('electrical_current')
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <select id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">
            @foreach ($motorService->electricalCurrentEnum() as $status )
            <option value="{{ $status }}">{{ $status }}</option>
            @endforeach
        </select>
        @break

        @case('nipple_grease')
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <select id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">
            @foreach ($motorService->nippleGreaseEnum() as $status )
            <option value="{{ $status }}">{{ $status }}</option>
            @endforeach
        </select>
        @break

        @case('cooling_fan')
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <select id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">
            @foreach ($motorService->coolingFanEnum() as $status )
            <option value="{{ $status }}">{{ $status }}</option>
            @endforeach
        </select>
        @break

        @case('mounting')
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <select id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">
            @foreach ($motorService->mountingEnum() as $status )
            <option value="{{ $status }}">{{ $status }}</option>
            @endforeach
        </select>
        @break

        @default
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <input @readonly($column=='updated_at' ||$column=='created_at' ) value="{{ ($column == 'created_at' || $column == 'updated_at') ? Carbon\Carbon::now() : null }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="50" class="form-control">
        @endswitch

        @include('utility.error-help')
    </div>
    @endforeach <!-- FORM MOTOR DETAILS -->
    @endunless
    <!-- MOTOR DETAILS -->


    <button type="submit" class="btn btn-primary">{{ isset($motor) ? 'Update' : 'Submit' }}</button>
</form>
<!-- ============================ FOR EDIT MOTOR PAGE END =========================== -->