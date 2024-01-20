<!-- MOTOR DETAILS -->
<div>
    @foreach ($motorService->getColumns('motor_details', ['id', 'motor_detail', 'created_at', 'updated_at']) as $column) <!-- FORM MOTOR DETAILS -->
    <div class="mb-3">
        @switch($column)

        {{-- max:5 --}}
        @case('pole')
        @case('phase_supply')
        @case('cos_phi')
        @case('efficiency')
        @case('insulation_class')
        @case('duty')
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        @if ($column == 'phase_supply')
        <input maxlength="1" value="{{ old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" class="form-control" onkeypress="return onlynumber(event, 48, 57)">
        @elseif ($column == 'cos_phi' || $column == 'efficiency')
        <input maxlength="5" value="{{ old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" class="form-control" onkeypress="return onlynumber(event, 46, 57)">
        @else
        <input maxlength="5" value="{{ old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" class="form-control">
        @endif
        @break

        {{-- max:6 --}}
        @case('shaft_diameter')
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <input maxlength="6" value="{{ old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" class="form-control">
        @break

        {{-- max:10 --}}
        @case('power_rate')
        @case('voltage')
        @case('curent_nominal')
        @case('frequency')
        @case('rpm')
        @case('ip_rating')
        @case('greasing_qty_de')
        @case('greasing_qty_nde')
        @case('length')
        @case('width')
        @case('height')
        @case('weight')
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        @if ($column == 'power_rate' || $column == 'rpm' || $column == 'curent_nominal')
        <input maxlength="10" value="{{ old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" class="form-control" onkeypress="return onlynumber(event, 46, 57)">
        @else
        <input maxlength="10" value="{{ old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" class="form-control">
        @endif
        @break

        {{-- max:25 --}}
        @case('bearing_de')
        @case('bearing_nde')
        @case('frame_type')
        @case('connection_type')
        @case('greasing_type')
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <input maxlength="25" value="{{ old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" class="form-control">
        @break

        @case('power_unit')
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <select id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">
            @foreach ($motorService->powerUnitEnum() as $option )
            <option @selected(old($column)==$option) value="{{ $option }}">{{ $option }}</option>
            @endforeach
        </select>
        @break

        @case('electrical_current')
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <select id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">
            @foreach ($motorService->electricalCurrentEnum() as $option )
            <option @selected(old($column)==$option) value="{{ $option }}">{{ $option }}</option>
            @endforeach
        </select>
        @break

        @case('nipple_grease')
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <select id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">
            @foreach ($motorService->nippleGreaseEnum() as $option )
            <option @selected(old($column)==$option) value="{{ $option }}">{{ $option }}</option>
            @endforeach
        </select>
        @break

        @case('cooling_fan')
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <select id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">
            @foreach ($motorService->coolingFanEnum() as $option )
            <option @selected(old($column)==$option) value="{{ $option }}">{{ $option }}</option>
            @endforeach
        </select>
        @break

        @case('mounting')
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <select id="{{ $column }}" name="{{ $column }}" class="form-select" aria-label="Default select example">
            @foreach ($motorService->mountingEnum() as $option )
            <option @selected(old($column)==$option) value="{{ $option }}">{{ $option }}</option>
            @endforeach
        </select>
        @break

        @default
        {{-- max:50 --}}
        <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
        <input maxlength="50" value="{{ old($column) }}" id="{{ $column }}" name="{{ $column }}" type="text" class="form-control text-uppercase">
        @endswitch
        @include('utility.error-help')
    </div>
    @endforeach <!-- FORM MOTOR DETAILS -->
</div>
<!-- MOTOR DETAILS -->