@include('utility.prefix')

<div class="py-4">

    <div class="my-4 py-5 position-absolute top-50 start-50 translate-middle" style="min-width: 300px;">

        <form id="/populating-forms" method="post">
            @csrf

            <h3 class="mb-3">{{ $title }}</h3>

            <div class="mb-3">
                <label for="equipments" class="form-label">Equipments</label>
                <input type="text" id="equipments" name="equipments" class="form-control" aria-describedby="equipment">
                @isset($links)
                @if (count($links) < 1) <div class="form-text text-danger">No equipment found.
            </div>
            @endif
            @endisset
    </div>

    <button type="submit" class="btn btn-primary">Populate</button>

    </form>
</div>

@isset($links)
<script>
    let links = <?php echo json_encode($links) ?>;
    for (i = 0; i < links.length; i++) {
        window.open(links[i], '_blank');
    }
</script>
@endisset
</div>

@include('utility.script.toupper')
@include('utility.suffix')