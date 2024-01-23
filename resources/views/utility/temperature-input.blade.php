<div class="mb-3">
    <label for="{{ $column }}" class="fw-bold form-label">{{ ucfirst(str_replace('_', ' ', $column)) }}</label>
    <input inputmode="numeric" type="text" onkeypress="return onlynumbercoma(event)" maxlength="5" class="form-control temperature unrequired" placeholder="°C" name="{{ $column }}" id="{{ $column }}">
    @include('utility.error-help')
</div>