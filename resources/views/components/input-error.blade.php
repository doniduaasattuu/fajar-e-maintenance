@props(['message'])

@if ($message)
<div {{ $attributes->merge(['class' => 'form-text text-danger']) }}>
    {{ $message }}
</div>
@endif