@props(['information' => []])

<div class="alert alert-dismissible alert-info" role="alert">
    <ul class="px-3 m-0 pe-0">
        @foreach ($information as $info )
        <li>{{ $info }}</li>
        @endforeach
    </ul>

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>