@foreach ($array as $option)
<option @selected( isset($record) ? ($record->$column==$option) : old($column)==$option) value="{{ $option }}">{{ $option }}</option>
@endforeach