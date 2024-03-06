@props(['disabled' => false, 'readonly' => false])

<input {{ $readonly ? 'readonly' : '' }} {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-control', 'type' => 'date']) !!}>