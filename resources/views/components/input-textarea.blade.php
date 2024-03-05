@props(['disabled' => false])

<textarea {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => 'form-control', 'cols' => '30', 'rows' => '5']) }}>{{ $slot }}</textarea>