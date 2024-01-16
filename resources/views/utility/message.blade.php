@if(session("message"))
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="bg-light modal-header">
                <h1 class=" modal-title fs-5" id="exampleModalLabel">{{ session('message')['header'] }}</h1>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                {{ session("message")['message'] }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    let myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {});
    myModal.show();
</script>
@endif