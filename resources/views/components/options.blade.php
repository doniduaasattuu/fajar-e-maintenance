@props(['options' => []])

@foreach ($options as $option)
<option value="{{ $option }}">{{ $option }}</option>
@endforeach