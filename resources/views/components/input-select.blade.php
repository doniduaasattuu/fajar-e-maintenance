@props(['options' => [], 'value', 'choose'])

<select {!! $attributes->merge(['class' => 'form-select']) !!} >
    @isset ($choose)
    <option>{{ $choose }}</option>
    @endisset
    @foreach ($options as $option)
    <option @selected($value==$option) value="{{ $option }}">{{ $option }}</option>
    @endforeach
</select>