@props(['errors' => []])

<div class="alert alert-danger">
    <ul class="m-0 px-3">
        @foreach ($errors->all() as $alert)
        <li>{{ $alert }}</li>
        @endforeach
    </ul>
</div>