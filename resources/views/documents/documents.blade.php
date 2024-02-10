@php
$skipped = ['id', 'created_at', 'updated_at'];
@endphp

@include('utility.prefix')
<div class="py-4" style="min-width: 350px;">

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
    <div class="row mb-3">
        <div class="col pe-1">
            <label for="filter_title" class="form-label fw-semibold">Filter</label>
            <input type="text" class="form-control" id="filter_title" name="filter_title" placeholder="Filter by title">
        </div>

        <div class="col ps-1">
            <label for="filter_area" class="form-label fw-semibold">Area</label>
            <select id="filter_area" name="filter_area" class="form-select" aria-label="Default select example">
                <option value="All" selected>All</option>
                @foreach ($documentService->areas() as $option)
                <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-text">The total document is {{ count($documentService->getAll()) }} records.</div>
    </div>

    {{-- TABLE DOCUMENT --}}
    <div class="mb-3">
        <table class="rounded table table-light table-hover mb-0 border border-1 shadow-sm">
            <thead>
                <tr>
                    <th class="iteration" style="line-height: 30px">#</th>
                    @foreach ($documentService->getColumns('documents', $skipped) as $column)

                    @switch($column)
                    @case('attachment')
                    <th style="line-height: 30px; width: 35px" class="text-center" scope="col">File</th>
                    @break

                    @case('area')
                    <th class="area-hide" style="line-height: 30px;" scope="col">{{ ucfirst(str_replace("_", " ", $column)) }}</th>
                    @break

                    @case('title')
                    <th style="line-height: 30px;" scope="col">{{ ucfirst(str_replace("_", " ", $column)) }}</th>
                    @break

                    @default
                    <th class="{{ $column }}" style="line-height: 30px;" scope="col">{{ ucfirst(str_replace("_", " ", $column)) }}</th>
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

                    <td class="iteration">{{ $loop->iteration }}</td>

                    @foreach ($documentService->getColumns('documents', $skipped) as $column)

                    @switch($column)

                    {{-- TITLE --}}
                    @case('title')
                    <td class="text-break {{ $column }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="{{ $document->area . ' | ' . $document->uploaded_by . ' | ' . Carbon\Carbon::create($document->created_at)->format('d-m-y') }}" scope="row">{{ $document->$column }}</td>
                    @break

                    {{-- ATTACHMENT --}}
                    @case('attachment')
                    <td class="text-center text-break {{ $column }}" scope="row">
                        <a href="/storage/documents/{{ $document->$column }}">

                            @switch(explode('.', $document->$column)[1])

                            {{-- PDF --}}
                            @case('pdf')
                            <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#dc3545" class="bi bi-file-earmark-pdf-fill" viewBox="0 0 16 16">
                                <path d="M5.523 12.424q.21-.124.459-.238a8 8 0 0 1-.45.606c-.28.337-.498.516-.635.572l-.035.012a.3.3 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548m2.455-1.647q-.178.037-.356.078a21 21 0 0 0 .5-1.05 12 12 0 0 0 .51.858q-.326.048-.654.114m2.525.939a4 4 0 0 1-.435-.41q.344.007.612.054c.317.057.466.147.518.209a.1.1 0 0 1 .026.064.44.44 0 0 1-.06.2.3.3 0 0 1-.094.124.1.1 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256M8.278 6.97c-.04.244-.108.524-.2.829a5 5 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.5.5 0 0 1 .145-.04c.013.03.028.092.032.198q.008.183-.038.465z" />
                                <path fill-rule="evenodd" d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.7 11.7 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.86.86 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.84.84 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.8 5.8 0 0 0-1.335-.05 11 11 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.24 1.24 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a20 20 0 0 1-1.062 2.227 7.7 7.7 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103" />
                            </svg>
                            @break

                            {{-- SPREADSHEET --}}
                            @case('xls')
                            @case('xlsx')
                            @case('ods')
                            <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#198754" class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 16">
                                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5zM3 12v-2h2v2zm0 1h2v2H4a1 1 0 0 1-1-1zm3 2v-2h3v2zm4 0v-2h3v1a1 1 0 0 1-1 1zm3-3h-3v-2h3zm-7 0v-2h3v2z" />
                            </svg>
                            @break

                            {{-- DOCUMENT WORD --}}
                            @case('docx')
                            <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#0dcaf0" class="bi bi-filetype-docx" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M14 4.5V11h-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zm-6.839 9.688v-.522a1.5 1.5 0 0 0-.117-.641.86.86 0 0 0-.322-.387.86.86 0 0 0-.469-.129.87.87 0 0 0-.471.13.87.87 0 0 0-.32.386 1.5 1.5 0 0 0-.117.641v.522q0 .384.117.641a.87.87 0 0 0 .32.387.9.9 0 0 0 .471.126.9.9 0 0 0 .469-.126.86.86 0 0 0 .322-.386 1.55 1.55 0 0 0 .117-.642m.803-.516v.513q0 .563-.205.973a1.47 1.47 0 0 1-.589.627q-.381.216-.917.216a1.86 1.86 0 0 1-.92-.216 1.46 1.46 0 0 1-.589-.627 2.15 2.15 0 0 1-.205-.973v-.513q0-.569.205-.975.205-.411.59-.627.386-.22.92-.22.535 0 .916.22.383.219.59.63.204.406.204.972M1 15.925v-3.999h1.459q.609 0 1.005.235.396.233.589.68.196.445.196 1.074 0 .634-.196 1.084-.197.451-.595.689-.396.237-.999.237zm1.354-3.354H1.79v2.707h.563q.277 0 .483-.082a.8.8 0 0 0 .334-.252q.132-.17.196-.422a2.3 2.3 0 0 0 .068-.592q0-.45-.118-.753a.9.9 0 0 0-.354-.454q-.237-.152-.61-.152Zm6.756 1.116q0-.373.103-.633a.87.87 0 0 1 .301-.398.8.8 0 0 1 .475-.138q.225 0 .398.097a.7.7 0 0 1 .273.26.85.85 0 0 1 .12.381h.765v-.073a1.33 1.33 0 0 0-.466-.964 1.4 1.4 0 0 0-.49-.272 1.8 1.8 0 0 0-.606-.097q-.534 0-.911.223-.375.222-.571.633-.197.41-.197.978v.498q0 .568.194.976.195.406.571.627.375.216.914.216.44 0 .785-.164t.551-.454a1.27 1.27 0 0 0 .226-.674v-.076h-.765a.8.8 0 0 1-.117.364.7.7 0 0 1-.273.248.9.9 0 0 1-.401.088.85.85 0 0 1-.478-.131.83.83 0 0 1-.298-.393 1.7 1.7 0 0 1-.103-.627zm5.092-1.76h.894l-1.275 2.006 1.254 1.992h-.908l-.85-1.415h-.035l-.852 1.415h-.862l1.24-2.015-1.228-1.984h.932l.832 1.439h.035z" />
                            </svg>
                            @break
                            @case('doc')
                            <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#0dcaf0" class="bi bi-filetype-doc" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2v-1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zm-7.839 9.166v.522q0 .384-.117.641a.86.86 0 0 1-.322.387.9.9 0 0 1-.469.126.9.9 0 0 1-.471-.126.87.87 0 0 1-.32-.386 1.55 1.55 0 0 1-.117-.642v-.522q0-.386.117-.641a.87.87 0 0 1 .32-.387.87.87 0 0 1 .471-.129q.264 0 .469.13a.86.86 0 0 1 .322.386q.117.255.117.641m.803.519v-.513q0-.565-.205-.972a1.46 1.46 0 0 0-.589-.63q-.381-.22-.917-.22-.533 0-.92.22a1.44 1.44 0 0 0-.589.627q-.204.406-.205.975v.513q0 .563.205.973.205.406.59.627.386.216.92.216.535 0 .916-.216.383-.22.59-.627.204-.41.204-.973M0 11.926v4h1.459q.603 0 .999-.238a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.59-.68q-.395-.234-1.004-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082H.79V12.57Zm7.422.483a1.7 1.7 0 0 0-.103.633v.495q0 .369.103.627a.83.83 0 0 0 .298.393.85.85 0 0 0 .478.131.9.9 0 0 0 .401-.088.7.7 0 0 0 .273-.248.8.8 0 0 0 .117-.364h.765v.076a1.27 1.27 0 0 1-.226.674q-.205.29-.55.454a1.8 1.8 0 0 1-.786.164q-.54 0-.914-.216a1.4 1.4 0 0 1-.571-.627q-.194-.408-.194-.976v-.498q0-.568.197-.978.195-.411.571-.633.378-.223.911-.223.328 0 .607.097.28.093.489.272a1.33 1.33 0 0 1 .466.964v.073H9.78a.85.85 0 0 0-.12-.38.7.7 0 0 0-.273-.261.8.8 0 0 0-.398-.097.8.8 0 0 0-.475.138.87.87 0 0 0-.301.398" />
                            </svg>
                            @break

                            {{-- IMAGES --}}
                            @case('png')
                            @case('jpeg')
                            @case('jpg')
                            <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="grey" class="bi bi-file-earmark-image" viewBox="0 0 16 16">
                                <path d="M6.502 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3" />
                                <path d="M14 14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zM4 1a1 1 0 0 0-1 1v10l2.224-2.224a.5.5 0 0 1 .61-.075L8 11l2.157-3.02a.5.5 0 0 1 .76-.063L13 10V4.5h-2A1.5 1.5 0 0 1 9.5 3V1z" />
                            </svg>
                            @break

                            @default
                            <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#198754" class="bi bi-file-earmark-text" viewBox="0 0 16 16">
                                <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5" />
                                <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                            </svg>
                            @endswitch

                        </a>
                    </td>
                    @break

                    @case('area')
                    <td class="text-break {{ $column }} area-hide" scope="row">{{ $document->$column }}</td>
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

    // FILTERING
    let table_rows = document.getElementsByClassName('table_row');
    let filter_title = document.getElementById('filter_title');
    let filter_area = document.getElementById('filter_area');
    let titles = document.getElementsByClassName('title');
    let areas = document.getElementsByClassName('area');

    function resetFilter(table_rows) {
        for (let i = 0; i < table_rows.length; i++) {
            table_rows[i].classList.remove("d-none");
        }
    }

    // FILTER BY TITLE
    let titlesText = [];
    for (title of titles) {
        titlesText.push(title.textContent.toUpperCase());
    }

    function filterByTitle() {
        for (let i = 0; i < titlesText.length; i++) {
            if (!titlesText[i].match(filter_title.value.trim().toUpperCase())) {
                table_rows[i].classList.add("d-none");
            }
        }
    }

    function doFilterByTitle() {
        if (filter_title.value.trim().length > 0) {
            resetFilter(table_rows);
            filterByTitle()
        } else {
            resetFilter(table_rows);
        }
    }

    filter_title.oninput = () => {
        if (filter_area.value != 'All') {
            doFilterByTitle();
            filterByArea();
        } else {
            doFilterByTitle();
        }
    }

    // FILTER BY AREA
    let areasText = [];
    for (area of areas) {
        areasText.push(area.textContent.toUpperCase());
    }

    function filterByArea() {
        for (let i = 0; i < areasText.length; i++) {
            if (areasText[i] != filter_area.value) {
                table_rows[i].classList.add("d-none");
            }
        }
    }

    function doFilterByArea() {
        if (filter_area.value != 'All') {
            resetFilter(table_rows);
            filterByArea();
        } else {
            resetFilter(table_rows);
        }
    }

    filter_area.onchange = () => {
        if (filter_title.value != '') {
            doFilterByArea();
            filterByTitle();
        } else {
            doFilterByArea();
        }
    }

    // ======================================

    // DO FILTER ALL
    function doFilter() {
        doFilterByTitle();
        doFilterByArea();
    }

    window.onload = () => {
        doFilter();
        doHideColumnOnPhone();
    }
</script>

@include('utility.script.hidecolumn')
<script>
    function doHideColumnOnPhone() {
        if (window.innerWidth < 576) {
            hideColumnOnPhone('add', 'iteration');
            hideColumnOnPhone('add', 'area-hide');
            hideColumnOnPhone('add', 'equipment');
            hideColumnOnPhone('add', 'funcloc');
            hideColumnOnPhone('add', 'uploaded_by');
        } else if (window.innerWidth >= 576 && window.innerWidth < 768) {
            hideColumnOnPhone('remove', 'iteration');
            hideColumnOnPhone('remove', 'area-hide');
            hideColumnOnPhone('add', 'equipment');
            hideColumnOnPhone('add', 'funcloc');
            hideColumnOnPhone('add', 'uploaded_by');
        } else if (window.innerWidth >= 768 && window.innerWidth < 992) {
            hideColumnOnPhone('remove', 'iteration');
            hideColumnOnPhone('remove', 'area-hide');
            hideColumnOnPhone('remove', 'equipment');
            hideColumnOnPhone('add', 'funcloc');
            hideColumnOnPhone('add', 'uploaded_by');
        } else if (window.innerWidth >= 992 && window.innerWidth < 1200) {
            hideColumnOnPhone('remove', 'iteration');
            hideColumnOnPhone('remove', 'area-hide');
            hideColumnOnPhone('remove', 'equipment');
            hideColumnOnPhone('remove', 'funcloc');
            hideColumnOnPhone('add', 'uploaded_by');
        } else {
            hideColumnOnPhone('remove', 'area-hide');
            hideColumnOnPhone('remove', 'equipment');
            hideColumnOnPhone('remove', 'funcloc');
            hideColumnOnPhone('remove', 'uploaded_by');
        }
    }

    window.onresize = doHideColumnOnPhone;
</script>

@include('utility.script.tooltip')
@include('utility.suffix')