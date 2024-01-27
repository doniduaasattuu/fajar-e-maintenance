<!-- alert -->
@if (session('alert'))
<div class="alert {{ session('alert')['variant'] }} alert-dismissible" role=" alert">
    {{ session('alert')['message'] }}

    @if (session('alert')['record_id'])
    </br>
    <a href="/record-edit/{{ session('alert')['record_id'] }}" class="alert-link">Click here</a> to edit.
    @endif

    <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->

</div>
@endif