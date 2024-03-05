@props(['alert' => new App\Data\Alert('Error ocurred.'), 'button_close' => false])

<div class="alert {{ $alert->variant }} alert-dismissible" role="alert">
    {{ $alert->message }}

    @if ($alert->link)
    </br>
    <a href="/record-edit/{{ $alert->link }}" class="alert-link">Click here</a> to edit.
    @endif

    @if ($button_close)
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif

</div>