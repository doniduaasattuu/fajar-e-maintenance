@props(['disabled' => false, 'readonly' => false])

<input onkeypress="return JS.onlynumber(event)" {{ $readonly ? 'readonly' : '' }} {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-control', 'type' => 'number', 'min' => '0']) !!}>