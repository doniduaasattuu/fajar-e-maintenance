@php
$vibration_description = str_replace('value', 'desc', $column);
@endphp

<div class="mb-3">
    <div class="mb-2">
        <label for="{{ $column }}" class="fw-semibold form-label">{{ str_replace(' value', '', ucfirst(str_replace('_', ' ', $column))) }}</label>
        <input value="{{ isset($record) ? $record->$column : old($column) }}" inputmode="numeric" type="text" step="0.01" min="0.00" max="45.0" maxlength="5" onkeypress="return onlynumbercoma(event)" oninput="return changeVibrationDescriptionColor(this.id)" class="form-control" placeholder="Vibration value (mm/s)" name="{{ $column }}" id="{{ $column }}">
    </div>
    <select id="{{ $vibration_description }}" name="{{ $vibration_description }}" class="form-select vibration_description" aria-label="Default select example">
        @foreach ($motorService->vibrationDescriptionEnum() as $option )
        <option @selected( isset($record) ? ($record->$vibration_description==$option) : old($vibration_description)==$option ) value="{{ $option }}">{{ $option }}</option>
        @endforeach
    </select>
    @include('utility.error-help')
    @error($vibration_description)
    <div class="form-text text-danger">{{ $message }}</div>
    @enderror
</div>