@foreach ($funclocService->getAll() as $funcloc)
@php
$id = $loop->iteration < 10 ? '0' . $loop->iteration : $loop->iteration;
    @endphp

    $funcloc{{ $id }} = new Funcloc();</br>
    $funcloc{{ $id }}->id = '{{ $funcloc->id }}';</br>
    $funcloc{{ $id }}->description = {{ null == $funcloc->description ? 'null' : "'" . $funcloc->description . "'" }};</br>
    $funcloc{{ $id }}->created_at = Carbon::now();</br>
    $funcloc{{ $id }}->save();</br>
    <br>

    @endforeach