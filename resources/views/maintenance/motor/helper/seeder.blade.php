@foreach ($motorService->getAll() as $motor)
@php
$id = $loop->iteration < 10 ? '0' . $loop->iteration : $loop->iteration;
    @endphp

    $motor{{ $id }} = new Motor();</br>
    $motor{{ $id }}->id = '{{ $motor->id }}';</br>
    $motor{{ $id }}->status = '{{ $motor->status }}';</br>
    $motor{{ $id }}->funcloc = {{ null == $motor->funcloc ? 'null' : "'" . $motor->funcloc . "'" }};</br>
    $motor{{ $id }}->sort_field = {{ null == $motor->sort_field ? 'null' : "'" . $motor->sort_field . "'" }};</br>
    $motor{{ $id }}->description = {{ null == $motor->description ? 'null' : "'" . $motor->description . "'" }};</br>
    $motor{{ $id }}->material_number = {{ null == $motor->material_number ? 'null' : "'" . $motor->material_number . "'" }};</br>
    $motor{{ $id }}->unique_id = '{{ $motor->unique_id }}';</br>
    $motor{{ $id }}->qr_code_link = '{{ $motor->qr_code_link }}';</br>
    $motor{{ $id }}->created_at = Carbon::now();</br>
    $motor{{ $id }}->updated_at = null;</br>
    $motor{{ $id }}->save();</br>
    <br>

    @endforeach