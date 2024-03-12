@props(['hidden' => []])

@foreach ($hidden as $hidden_input)
@if ($errors->get($hidden_input))
<x-alerts :alert='$errors->get($hidden_input)'></x-alerts>
@endif
@endforeach