@php
$motorDetail = $motor->MotorDetail;
@endphp

<!-- ========================= FOR MOTOR DETAILS PAGE START ========================= -->
<!-- MOTOR -->
@foreach ($motorService->getTableColumns() as $column) {{-- MOTOR FORM --}}
<div class="mb-3">
    <label for="{{ $column }}" class="form-label fw-semibold">{{ $column == 'id' ? 'Motor' : ucfirst(str_replace("_", " ", $column)) }}</label>
    <input disabled readonly value="{{ $motor->$column }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="9" class="form-control">
</div>
@endforeach {{-- MOTOR FORM --}}
<!-- MOTOR -->


<!-- MOTOR DETAIL SET -->
@isset($motor->MotorDetail) {{-- MOTOR DETAIL --}}
@foreach ($motor->MotorDetail->toArray() as $key => $value)
@if ($key == 'id' || $key == 'motor_detail' || $key == 'created_at' || $key == 'updated_at' )
@continue
@else
<div class="mb-3">
    <label for="{{ $key }}" class="form-label fw-semibold">{{ $key == 'id' ? 'Motor' : ucfirst(str_replace("_", " ", $key)) }}</label>
    <input disabled value="{{ $value }}" id="{{ $key }}" name="{{ $key }}" type="text" class="form-control">
</div>
@endif
@endforeach
@endisset {{-- MOTOR DETAIL --}}
<!-- MOTOR DETAIL SET -->


<!-- MOTOR DETAIL NOT SET -->
@unless ($motorDetail) {{-- MOTOR DETAIL NOT SET --}}
@foreach ($motorService->getColumns('motor_details', ['id', 'motor_detail', 'updated_at', 'created_at']) as $column)

<div class="mb-3">
    <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
    <input value="Not set" disabled id="{{ $column }}" name="{{ $column }}" type="text" class="form-control">
</div>

@endforeach
@endunless {{-- MOTOR DETAIL NOT SET --}}
<!-- MOTOR DETAIL NOT SET -->
<!-- =========================== FOR MOTOR DETAILS PAGE END ========================= -->