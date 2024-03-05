@props(['disabled' => false, 'readonly' => false])

<input onkeypress="return JS.onlynumbercoma(event)" {{ $readonly ? 'readonly' : '' }} {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-control', 'type' => 'text', 'min' => '0']) !!}>