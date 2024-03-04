@props(['modal'])

<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="min-width: 330px;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class=" modal-title fs-5" id="exampleModalLabel">{{ $modal->header }}</h1>
            </div>
            <div class="modal-body">
                {{ $modal->message }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    let myModal = new bootstrap.Modal(document.getElementById('modal'), {});
    myModal.show();
</script>