@props(['value' => 'Good', 'disabled' => false, 'readonly' => false])

<input {{ $disabled ? 'disabled' : '' }} {{ $readonly ? 'readonly' : '' }} value="{{ $value }}" {!! $attributes->merge(['class' => 'mt-2 form-control bg-success text-white', 'type' => 'text', 'tabindex' => '-1']) !!} style="cursor: default;" >