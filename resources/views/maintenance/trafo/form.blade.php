@include('utility.prefix')

<div class="py-4">

    <div class="mb-3">
        <h3 class="mb-1">{{ $title }}</h3>
        <nav aria-label=" breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/trafos">Table</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ (isset($trafo) && $trafo != null) ? $trafo->id : $title }}</li>
            </ol>
        </nav>
    </div>

    @include('utility.alert')

    @switch($title)

    @case('Trafo registration')
    @include('maintenance.trafo.registration')
    @break

    @case('Edit trafo')
    @include('maintenance.trafo.edit')
    @break

    @default
    @include('maintenance.trafo.details')
    @endswitch

</div>

<script>
    let id = document.getElementById('id');
    let unique_id = document.getElementById('unique_id');
    let qr_code_link = document.getElementById('qr_code_link');
    let status = document.getElementById('status');
    let funcloc = document.getElementById('funcloc')
    let sort_field = document.getElementById('sort_field')
    let current_funcloc = <?php echo (isset($trafo)) ? (json_encode($trafo->funcloc)) : "''" ?>;
    let current_sort_field = <?php echo (isset($trafo)) ? (json_encode($trafo->sort_field)) : "''" ?>;

    function disabledFunclocAndSortField() {
        if (status.value == 'Repaired' || status.value == 'Available') {
            // IF STATUS VALUE IS NOT INSTALLED
            if (funcloc.value.length > 0 && sort_field.value.length > 0) {
                current_funcloc = funcloc.value;
                current_sort_field = sort_field.value;
            }

            funcloc.setAttribute('disabled', true);
            sort_field.setAttribute('disabled', true);

            funcloc.value = '';
            sort_field.value = '';
        } else if (status.value == 'Installed') {
            // IF STATUS VALUE IS INSTALLED
            funcloc.value = current_funcloc;
            sort_field.value = current_sort_field;

            funcloc.removeAttribute('disabled');
            sort_field.removeAttribute('disabled');
        }
    }

    status.onchange = () => {
        disabledFunclocAndSortField();
    }

    unique_id.oninput = () => {
        qr_code_link.value = "";
        let link = "https://www.safesave.info/MIC.php?id=Fajar-trafoList";
        qr_code_link.value = link + unique_id.value;
    }

    window.onload = () => {
        if (window.location.pathname.split('/')[1] !== 'trafo-details') {
            disabledFunclocAndSortField();
        }
    }
</script>
@include('utility.script.toupper')
@include('utility.script.onlynumber')
@include('utility.suffix')