@foreach ($array as $option)
<option @selected(old($column)!=null) value="{{ $option }}">{{ $option }}</option>
@endforeach