@foreach ($trafoService->getAll() as $trafo)
@php
$id = $loop->iteration < 10 ? '0' . $loop->iteration : $loop->iteration;
    @endphp

    $trafo{{ $id }} = new Trafo();</br>
    $trafo{{ $id }}->id = '{{ $trafo->id }}';</br>
    $trafo{{ $id }}->status = '{{ $trafo->status }}';</br>
    $trafo{{ $id }}->funcloc = {{ null == $trafo->funcloc ? 'null' : "'" . $trafo->funcloc . "'" }};</br>
    $trafo{{ $id }}->sort_field = {{ null == $trafo->sort_field ? 'null' : "'" . $trafo->sort_field . "'" }};</br>
    $trafo{{ $id }}->description = {{ null == $trafo->description ? 'null' : "'" . $trafo->description . "'" }};</br>
    $trafo{{ $id }}->material_number = {{ null == $trafo->material_number ? 'null' : "'" . $trafo->material_number . "'" }};</br>
    $trafo{{ $id }}->unique_id = '{{ $trafo->unique_id }}';</br>
    $trafo{{ $id }}->qr_code_link = '{{ $trafo->qr_code_link }}';</br>
    $trafo{{ $id }}->created_at = Carbon::now();</br>
    $trafo{{ $id }}->updated_at = null;</br>
    $trafo{{ $id }}->save();</br>
    <br>

    @endforeach