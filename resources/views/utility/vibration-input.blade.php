<div class="mb-3">
    <div class="mb-2">
        <label for="{{ $column }}" class="fw-bold form-label">{{ str_replace(' value', '', ucfirst(str_replace('_', ' ', $column))) }}</label>
        <input inputmode="numeric" type="text" step="0.01" min="0.00" max="45.0" maxlength="5" onkeypress="return onlynumbercoma(event)" class="form-control vibration_value" placeholder="Vibration value (mm/s)" name="{{ $column }}" id="{{ $column }}">
    </div>
    <select disabled id="{{ str_replace('value', 'desc', $column) }}" name="{{ str_replace('value', 'desc', $column) }}" class="vibration form-select vibration_description" aria-label="Default select example">
        @foreach ($motorService->vibrationDescriptionEnum() as $option )
        <option @selected(old(str_replace('value', 'desc' , $column))!=null) value="{{ $option }}">{{ $option }}</option>
        @endforeach
    </select>
    @include('utility.error-help')
</div>