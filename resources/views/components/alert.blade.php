@props(['alert' => new App\Data\Alert('Error ocurred.'), 'button_close' => false])

<div class="alert {{ $alert->variant }} alert-dismissible" role="alert">
    {{ $alert->message }}

    @if ($button_close)
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif

</div>