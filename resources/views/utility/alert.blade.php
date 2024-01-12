<!-- @isset($alert)
<div class="alert {{ $alert->variant }}" role="alert">
    {{ $alert->message }}
</div>
@endisset -->

@if (session('alert'))
<div class="alert {{ session('alert')['variant'] }}" role="alert">
    {{ session('alert')['message'] }}
</div>
@endif