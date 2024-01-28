<!-- alert -->
@if (session('alert'))
<div class="alert {{ session('alert')['variant'] }} alert-dismissible" role="alert">
    {{ session('alert')['message'] }}

    <!-- button close alert -->
    @if (request()->path() != 'login')
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif

</div>
@endif