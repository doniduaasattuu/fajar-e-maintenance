@php
$motorDetail = $motor->MotorDetail;
@endphp

<!-- ========================= FOR MOTOR DETAILS PAGE START ========================= -->
@foreach ($motorService->getTableColumns() as $column)
<div class="mb-3">
    <label for="{{ $column }}" class="form-label fw-semibold">{{ $column == 'id' ? 'Motor' : ucfirst(str_replace("_", " ", $column)) }}</label>
    <input disabled readonly value="{{ $motor->$column }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="9" class="form-control">
</div>
@endforeach
<!-- MOTOR DETAILS START -->
@isset($motor->MotorDetail)
@foreach ($motor->MotorDetail->toArray() as $key => $value)
@if ($key == 'id' || $key == 'motor_detail' || $key == 'created_at' || $key == 'updated_at' )
@continue
@else
<div class="mb-3">
    <label for="{{ $key }}" class="form-label fw-semibold">{{ $key == 'id' ? 'Motor' : ucfirst(str_replace("_", " ", $key)) }}</label>
    <input disabled readonly value="{{ $value }}" id="{{ $key }}" name="{{ $key }}" type="text" class="form-control">
</div>
@endif
@endforeach
@endisset

@unless ($motorDetail)
@foreach ($motorService->getColumns('motor_details', ['id', 'motor_detail', 'updated_at', 'created_at']) as $column)

<div class="mb-3">
    <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
    <input value="Not set" disabled readonly id="{{ $column }}" name="{{ $column }}" type="text" class="form-control">
</div>

@endforeach
@endunless
<!-- MOTOR DETAILS END-->
<!-- =========================== FOR MOTOR DETAILS PAGE END ========================= -->