@props(['motorDetail', 'utility', 'motor'])

@foreach ($utility::getColumns('motor_details', ['id', 'created_at', 'updated_at']) as $column)
<div class="mb-3">
    <x-input-label for="{{ $column }}" :value="ucfirst(str_replace('_',' ', $column))" />

    @switch($column)

    @case('motor_detail')
    <x-input-number-text type="hidden" id="{{ $column }}" name="{{ $column }}" :value='old($column, $motorDetail->$column ?? $motor->id ?? "" )' :disabled='!Auth::user()->isAdmin()' />
    @break

    @case('power_unit')
    @case('electrical_current')
    @case('nipple_grease')
    @case('cooling_fan')
    @case('mounting')
    <x-input-select id="{{ $column }}" name="{{ $column }}" :options="$utility::getEnumValue('motor', $column)" :value='old($column, $motorDetail->$column ?? "")' :disabled='!Auth::user()->isAdmin()' />
    @break

    @case('power_rate')
    <x-input-number-coma id="{{ $column }}" name="{{ $column }}" :value='old($column, $motorDetail->$column ?? "")' :disabled='!Auth::user()->isAdmin()' />
    @break

    @default
    <x-input-text id="{{ $column }}" name="{{ $column }}" :value='old($column, $motorDetail->$column ?? "")' :disabled='!Auth::user()->isAdmin()' />
    @endswitch


    <x-input-error :message="$errors->first('$column')" />
</div>
@endforeach