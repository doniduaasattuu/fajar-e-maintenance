@php
$skipped = ['id', 'created_at', 'updated_at', 'area', 'equipment', 'funcloc', 'uploaded_by'];
@endphp

@include('utility.prefix')
<div class="py-4">

    @include('utility.confirmation')

    <h3 class="mb-3">{{ $title }}</h3>

    {{-- REGISTRY NEW DOCUMENT --}}
    <div class="mb-3">
        <div class="btn-group">
            <button type="button" class="btn btn-primary">
                <a class="text-white nav-link d-inline-block" aria-current="page" href="/document-registration">
                    <svg class="my-1 me-1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0" />
                    </svg>
                    New document
                </a>
            </button>
        </div>
    </div>

    {{-- FILTER DOCUMENT --}}
    <div class="mb-3">
        <label for="filter" class="form-label fw-bold">Filter</label>
        <input type="text" class="form-control" id="filter" name="filter" placeholder="Filter by title">
        <div class="form-text">The total document is {{ count($documentService->getAll()) }} records.</div>
    </div>

    {{-- TABLE DOCUMENT --}}
    <div class="mb-3">
        <table class="rounded table table-light table-hover mb-0 border border-1 shadow-sm">
            <thead>
                <tr>

                    <th style="line-height: 30px">#</th>

                    @foreach ($documentService->getColumns('documents', $skipped) as $column)

                    @switch($column)
                    @case('attachment')
                    <th style="line-height: 30px; width: 35px" class="text-center" scope="col">File</th>
                    @break

                    @default
                    <th style="line-height: 30px;" scope="col">{{ ucfirst(str_replace("_", " ", $column)) }}</th>
                    @endswitch

                    @endforeach

                    {{-- EDIT --}}
                    <th style="line-height: 30px; width: 35px" class="text-center" scope="col">Edit</th>

                    {{-- DELETE --}}
                    <th style="line-height: 30px; width: 35px" class="text-center" scope="col">Drop</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($documentService->getAll() as $document)
                <tr class="table_row">

                    <td>{{ $loop->iteration }}</td>

                    @foreach ($documentService->getColumns('documents', $skipped) as $column)

                    @switch($column)

                    {{-- ATTACHMENT --}}
                    @case('attachment')
                    <td class="text-center text-break {{ $column }}" scope="row">
                        <a href="/storage/documents/{{ $document->$column }}">

                            {{-- PDF --}}
                            @if (explode('.', $document->$column)[1] == 'pdf')
                            <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#dc3545" class="bi bi-file-earmark-pdf-fill" viewBox="0 0 16 16">
                                <path d="M5.523 12.424q.21-.124.459-.238a8 8 0 0 1-.45.606c-.28.337-.498.516-.635.572l-.035.012a.3.3 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548m2.455-1.647q-.178.037-.356.078a21 21 0 0 0 .5-1.05 12 12 0 0 0 .51.858q-.326.048-.654.114m2.525.939a4 4 0 0 1-.435-.41q.344.007.612.054c.317.057.466.147.518.209a.1.1 0 0 1 .026.064.44.44 0 0 1-.06.2.3.3 0 0 1-.094.124.1.1 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256M8.278 6.97c-.04.244-.108.524-.2.829a5 5 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.5.5 0 0 1 .145-.04c.013.03.028.092.032.198q.008.183-.038.465z" />
                                <path fill-rule="evenodd" d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.7 11.7 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.86.86 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.84.84 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.8 5.8 0 0 0-1.335-.05 11 11 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.24 1.24 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a20 20 0 0 1-1.062 2.227 7.7 7.7 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103" />
                            </svg>

                            {{-- EXCEL --}}
                            @elseif (explode('.', $document->$column)[1] == 'xls' || 'xlsx')
                            <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#198754" class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 16">
                                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5zM3 12v-2h2v2zm0 1h2v2H4a1 1 0 0 1-1-1zm3 2v-2h3v2zm4 0v-2h3v1a1 1 0 0 1-1 1zm3-3h-3v-2h3zm-7 0v-2h3v2z" />
                            </svg>

                            {{-- ELSE --}}
                            @else
                            <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#198754" class="bi bi-file-earmark-text" viewBox="0 0 16 16">
                                <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5" />
                                <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                            </svg>
                            @endif

                        </a>
                    </td>
                    @break

                    @default
                    <td class="text-break {{ $column }}" scope="row">{{ $document->$column }}</td>
                    @endswitch

                    @endforeach

                    {{-- EDIT --}}
                    <td class="text-center" style="width: 30px">
                        <a href="/document-edit/{{ $document->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                            </svg>
                        </a>
                    </td>

                    {{-- DELETE --}}
                    <td data-bs-toggle="modal" data-bs-target="#confirmation_modal" url='/document-delete/{{ $document->id }}' class="text-center buttonDelete">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#dc3545" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                        </svg>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    // DELETE CONFIRMATION
    let buttonsDelete = document.getElementsByClassName('buttonDelete');

    function doConfirmation(buttons) {
        for (let i = 0; i < buttons.length; i++) {
            buttons[i].style.cursor = 'pointer';
            buttons[i].onclick = () => {
                let confirm_url = buttons[i].getAttribute('url');
                let modal_url = document.getElementById('confirmation_url');
                modal_url.setAttribute('href', confirm_url);
            }
        }
    }
    doConfirmation(buttonsDelete);


    // FILTER
    let table_rows = document.getElementsByClassName('table_row');
    let filter = document.getElementById('filter');
    let titles = document.getElementsByClassName('title');

    function resetFilter(table_rows) {
        for (let i = 0; i < table_rows.length; i++) {
            table_rows[i].classList.remove("d-none");
        }
    }

    let titlesText = [];
    for (title of titles) {
        titlesText.push(title.textContent.toUpperCase());
    }

    function doFilter() {
        // filter.value = filter.value.toUpperCase();

        if (filter.value.trim().length > 0) {
            resetFilter(table_rows);

            for (let i = 0; i < titlesText.length; i++) {
                if (!titlesText[i].match(filter.value.trim().toUpperCase())) {
                    table_rows[i].classList.add("d-none");
                }
            }
        } else {
            resetFilter(table_rows);
        }
    }

    filter.oninput = () => {
        doFilter();
    }
</script>

@include('utility.script.tooltip')
@include('utility.suffix')