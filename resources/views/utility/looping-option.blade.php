@foreach ($array as $option)
<option @selected(old($column)==$option) value="{{ $option }}">{{ $option }}</option>
@endforeach