@props(['id' => '', 'name' => '', 'value' => ''])

<input id="{{ $id }}" name="{{ $name }}" value="{{ $value }}" {!! $attributes->merge(['class' => 'form-control', 'type' => 'hidden']) !!}>
