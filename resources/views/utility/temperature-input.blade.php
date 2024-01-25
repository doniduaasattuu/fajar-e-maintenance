<div class="mb-3">
    <label for="{{ $column }}" class="fw-semibold form-label">{{ ucfirst(str_replace('_', ' ', $column)) }}</label>
    <input value="{{ isset($record) ? $record->$column : old($column) }}" inputmode="numeric" type="text" onkeypress="return onlynumbercoma(event)" oninput="return preventmax(this.id, 255)" maxlength="5" class="form-control temperature unrequired" placeholder="°C" name="{{ $column }}" id="{{ $column }}">
    @include('utility.error-help')
</div>