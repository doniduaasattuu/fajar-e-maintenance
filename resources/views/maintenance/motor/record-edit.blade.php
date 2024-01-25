@include('utility.prefix')
<div class="py-4">

    @foreach ($motorService->getColumns('motor_records', ['id', 'funcloc', 'motor', 'sort_field', 'nik', 'created_at', 'updated_at']) as $column)
    <div class="mb-3">
        <label for="{{ $column }}" class="fw-semibold form-label">{{ ucfirst(str_replace('_', ' ', $column)) }}</label>

        @if (sizeof(explode('_', $column)) > 3)

        {{-- VIBRATION VALUE --}}
        @switch($column)
        @case(explode('_', $column)[3] == 'value')
        <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="{{ $record->$column }}">
        @break

        {{-- VIBRATION DESC --}}
        @case(explode('_', $column)[3] == 'desc')
        <select name="{{ $column }}" id="{{ $column }}" class="form-select vibration_description" aria-label="Default select example">
            @foreach ($motorService->vibrationDescriptionEnum() as $option )
            <option class="form-control" @selected(old($record->$column)==$option) value="{{ $option }}">{{ $option }}</option>
            @endforeach
        </select>
        @break

        @default
        <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="{{ $record->$column }}">
        @endswitch

        @else
        <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="{{ $record->$column }}">
        @endif
    </div>
    @endforeach

</div>
@include('utility.suffix')