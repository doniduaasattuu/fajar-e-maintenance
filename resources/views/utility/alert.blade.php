<!-- @isset($alert)
<div class="alert {{ $alert->variant }}" role="alert">
    {{ $alert->message }}
</div>
@endisset -->

@if (session('alert'))
<div class="alert {{ session('alert')['variant'] }} alert-dismissible" role=" alert">
    {{ session('alert')['message'] }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif