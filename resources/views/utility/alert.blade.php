@isset($alert)
<div class="alert {{ $alert-variant }}" role="alert">
    {{ $alert->message }}
</div>
@endisset