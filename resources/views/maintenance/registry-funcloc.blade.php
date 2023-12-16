<!DOCTYPE html>
<html lang="en">

@include("utility.head")

<body>
    @include("utility.navbar")
    <div class="container py-4">

        <!-- MESSAGE -->
        @if (session("message"))
        <div class="modal fade" id="message" tabindex="-1" aria-labelledby="messageLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="bg-light modal-header">
                        <h1 class=" modal-title fs-5" id="messageLabel">Message</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ session("message") }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            let message = new bootstrap.Modal(document.getElementById('message'), {});
            message.show();
        </script>
        @endif
        <!-- MESSAGE -->

        <h3 class="mb-4">Funcloc Registration</h3>

        <form action="/register-funcloc" method="post">
            @csrf

            @foreach ($funcloc_table as $column )
            @if ($column == 'created_at' || $column == 'updated_at')
            @continue
            @else
            <!-- NOT ENUM TYPE -->
            <div class="form-group row mb-3">
                <label class="col-form-label col-xl-2 fw-bold">{{ str_replace("_", " ", ucwords($column == 'id' ? 'Funcloc' : $column)) }}</label>
                <div class="col-xl-10">
                    <input name="{{ $column }}" id="{{ $column }}" type="text" class="form-control">
                </div>
            </div>
            <!-- NOT ENUM TYPE -->
            @endif
            @endforeach

            <div>
                <button type="submit" class="mt-2 mb-4 btn btn-primary">
                    <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                        <path d="M11 2H9v3h2V2Z" />
                        <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0ZM1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5Zm3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4v4.5ZM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5V15Z" />
                    </svg>
                    Submit
                </button>
            </div>
        </form>

    </div>


</body>

</html>