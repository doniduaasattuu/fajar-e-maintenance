@php
$trafoDetail = $trafo->TrafoDetail;
@endphp

<!-- ========================= FOR TRAFO DETAILS PAGE START ========================= -->
<!-- TRAFO -->
@foreach ($trafoService->getColumns('trafos') as $column) {{-- TRAFO FORM --}}
<div class="mb-3">
    <label for="{{ $column }}" class="form-label fw-semibold">{{ $column == 'id' ? 'Trafo' : ucfirst(str_replace("_", " ", $column)) }}</label>
    <input readonly value="{{ $trafo->$column }}" id="{{ $column }}" name="{{ $column }}" type="text" maxlength="9" class="form-control">
</div>
@endforeach {{-- TRAFO FORM --}}
<!-- TRAFO -->


<!-- TRAFO DETAIL IS SET / REGISTERED -->
@isset($trafo->TrafoDetail) {{-- TRAFO DETAIL --}}
@foreach ($trafo->TrafoDetail->toArray() as $key => $value)
@if ($key == 'id' || $key == 'trafo_detail' || $key == 'created_at' || $key == 'updated_at' )
@continue
@else
<div class="mb-3">
    <label for="{{ $key }}" class="form-label fw-semibold">{{ $key == 'id' ? 'Trafo' : ucfirst(str_replace("_", " ", $key)) }}</label>
    <input readonly value="{{ $value }}" id="{{ $key }}" name="{{ $key }}" type="text" class="form-control">
</div>
@endif
@endforeach
@endisset {{-- TRAFO DETAIL --}}
<!-- TRAFO DETAIL IS SET / REGISTERED  -->


<!-- TRAFO DETAIL NOT SET -->
@unless ($trafoDetail) {{-- TRAFO DETAIL NOT SET --}}
@foreach ($trafoService->getColumns('trafo_details', ['id', 'trafo_detail', 'updated_at', 'created_at']) as $column)

<div class="mb-3">
    <label for="{{ $column }}" class="form-label fw-semibold">{{ ucfirst(str_replace("_", " ", $column)) }}</label>
    <input value="Not set" readonly id="{{ $column }}" name="{{ $column }}" type="text" class="form-control">
</div>

@endforeach
@endunless {{-- Trafo DETAIL NOT SET --}}
<!-- TRAFO DETAIL NOT SET -->
<!-- =========================== FOR TRAFO DETAILS PAGE END ========================= -->