@php
$trafoDetail = $trafo->TrafoDetail;
@endphp
<!-- =========================== FOR EDIT trafo PAGE START ========================== -->
<form action="/{{ $action }}" method="post" id="forms">
    @csrf
    <div>
        @foreach ($trafoService->getColumns('trafos', ['updated_at']) as $column) <!-- FORM TRAFO -->
        <div class="mb-3">
            <label for="{{ $column }}" class="form-label fw-semibold">{{ $column == 'id' ? 'Trafo' : ucfirst(str_replace("_", " ", $column)) }}</label>
            @switch($column)

            {{-- ID --}}
            @case('id')
            <input readonly value="{{ null != old($column) ? old($column) : $trafo->$column }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="9" class="form-control">
            @break

            {{-- STATUS --}}
            @case('status')
            <select id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">
                @foreach ($trafoService->equipmentStatus as $option )
                @if (null != $trafo && null == old($column))
                <option @selected($trafo->$column==$option) value="{{ $option }}">{{ $option }}</option>
                @else
                <option @selected(old($column)==$option) value="{{ $option }}">{{ $option }}</option>
                @endif
                @endforeach
            </select>
            @break

            {{-- FUNCLOC --}}
            @case('funcloc')
            <input value="{{ null != old($column) ? old($column) : $trafo->$column }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="50" class="form-control" onkeypress="return /[a-zA-Z0-9-]/i.test(event.key)" oninput="toupper(this)">
            @break

            {{-- MATERIAL NUMBER --}}
            @case('material_number')
            <input value="{{ null != old($column) ? old($column) : $trafo->$column }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="8" class="form-control" onkeypress="return onlynumber(event, 48, 57)">
            @break

            {{-- UNIQUE ID --}}
            @case('unique_id')
            <input readonly value="{{ null != old($column) ? old($column) : $trafo->$column }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="6" class="form-control" onkeypress="return onlynumber(event, 48, 57)">
            @break

            {{-- QR CODE LINK --}}
            @case('qr_code_link')
            <input readonly value="{{ null != old($column) ? old($column) : $trafo->$column }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="100" class="form-control">
            @break

            {{-- CREATED AT --}}
            @case('created_at')
            <input readonly value="{{ $trafo->$column }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="19" class="form-control">
            @break

            {{-- SORT FIELD, DESCRIPTION --}}
            @default
            <input value="{{ null != old($column) ? old($column) : $trafo->$column }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="50" class="form-control" oninput="toupper(this)">
            @endswitch
            @include('utility.error-help')
        </div>
        @endforeach <!-- FORM TRAFO -->
    </div>

    <input type="hidden" value="{{ $trafo->id }}" id="trafo_detail" name="trafo_detail">

    <div>
        @foreach ($trafoService->getColumns('trafo_details', ['id', 'trafo_detail', 'created_at', 'updated_at']) as $column) <!-- FORM trafo DETAILS -->
        <div class="mb-3">
            <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
            @switch($column)

            {{-- NUMERIC TYPE --}}
            @case('power_rate')
            <input value="{{ null != old($column) ? old($column) : (null != $trafoDetail ? $trafoDetail->$column : null) }}" id="{{ $column }}" name="{{ $column }}" type="text" class="form-control" onkeypress="return onlynumber(event, 46, 57)">
            @break
            {{-- NUMERIC TYPE --}}

            {{-- ENUM TYPE --}}
            @case('power_unit')
            <select id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">

                @if ($column == 'power_unit')
                @foreach ($trafoService->powerUnitEnum as $option )
                @if (null != $trafoDetail && null == old($column))
                <option @selected($trafoDetail->$column==$option) value="{{ $option }}">{{ $option }}</option>
                @else
                <option @selected(old($column)==$option) value="{{ $option }}">{{ $option }}</option>
                @endif
                @endforeach

                @endif
            </select>
            @break
            {{-- ENUM TYPE --}}

            @default
            <input maxlength="50" value="{{ null != old($column) ? old($column) : (null != $trafoDetail ? $trafoDetail->$column : null) }}" id="{{ $column }}" name="{{ $column }}" type="text" class="form-control">
            @endswitch
            @include('utility.error-help')
        </div>
        @endforeach <!-- FORM trafo DETAILS -->
    </div>

    <button type="submit" class="btn btn-primary">{{ isset($trafo) ? 'Update' : 'Submit' }}</button>
</form>
<!-- ============================ FOR EDIT trafo PAGE END =========================== -->