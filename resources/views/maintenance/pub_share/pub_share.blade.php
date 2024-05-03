<x-app-layout>

    <x-modal-confirm></x-modal-confirm>


    <section class="mb-4">
        <x-h3>{{ $title }}</x-h3>

        <x-alert-info :information='["These pub share are private", "Only for transferring from factories computer to your phone and vice versa"]' />

        <form id="form" action="/pub-share" method="POST" enctype="multipart/form-data">
            <div class="row mb-3">
                @csrf
                {{-- FILE --}}
                <!-- <div class="col-md pe-md-1 mb-2 mb-md-0"> -->
                <div class="col mb-2 pe-1">
                    <x-input-label for="file" :value="__('File *')" />
                    <x-input-file id="file" name="file" required />
                    <div id="message_file_input">
                        <x-input-error :message="$errors->first('file')" />
                    </div>
                </div>
                {{-- TITLE --}}
                <!-- <div class="col-md ps-md-1"> -->
                <div class="col mb-2 ps-1">
                    <!-- class="d-none d-md-block" -->
                    <x-input-label for="title" :value="__('Title')" />
                    <div class=" input-group">
                        <x-input-text type="text" id="title" name="title" :placeholder='"Rename"' value='{{ old("title") }}' />
                        <x-button-primary id="button_upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z" />
                            </svg>
                        </x-button-primary>
                    </div>
                    <x-input-error :message="$errors->first('title')" />
                </div>
            </div>
        </form>

        @if(session("alert"))
        <x-alert :alert='session("alert")' :button_close='true'></x-alert>
        @endisset
    </section>

    @if ($files->count() >= 1)
    <section class="mb-4 overflow-x-auto">
        {{-- TABLE --}}
        <table class="rounded table table-hover mb-0 border border-1 shadow-sm table-responsive-md" style="min-width: 600px;">
            <thead>
                <tr>
                    <th style="line-height: 30px; width: 30px;">#</th>
                    <th style="line-height: 30px">Title</th>
                    <th style="width: 100px; line-height: 30px">Size</th>
                    <th style="width: 50px; line-height: 30px">Preview</th>
                    <th style="width: 50px; line-height: 30px">Download</th>
                    <th style="width: 50px; line-height: 30px">Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($files as $file)
                <tr class="table-row">
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-break">{{ $file->attachment }}</td>
                    <td>{{ $file->size }}</td>
                    {{-- PREVIEW --}}
                    @if (
                    explode('.', $file->attachment)[1] == 'png' ||
                    explode('.', $file->attachment)[1] == 'jpg' ||
                    explode('.', $file->attachment)[1] == 'jpeg' ||
                    explode('.', $file->attachment)[1] == 'pdf'
                    )
                    <td class="text-center">
                        <a href="storage/pub_share/{{ Auth::user()->nik . '/' . $file->attachment }}">
                            @switch(explode('.', $file->attachment)[1])
                            @case('pdf')
                            <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="#dc3545" class="bi bi-file-earmark-pdf-fill" viewBox="0 0 16 16">
                                <path d="M5.523 12.424q.21-.124.459-.238a8 8 0 0 1-.45.606c-.28.337-.498.516-.635.572l-.035.012a.3.3 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548m2.455-1.647q-.178.037-.356.078a21 21 0 0 0 .5-1.05 12 12 0 0 0 .51.858q-.326.048-.654.114m2.525.939a4 4 0 0 1-.435-.41q.344.007.612.054c.317.057.466.147.518.209a.1.1 0 0 1 .026.064.44.44 0 0 1-.06.2.3.3 0 0 1-.094.124.1.1 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256M8.278 6.97c-.04.244-.108.524-.2.829a5 5 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.5.5 0 0 1 .145-.04c.013.03.028.092.032.198q.008.183-.038.465z" />
                                <path fill-rule="evenodd" d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.7 11.7 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.86.86 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.84.84 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.8 5.8 0 0 0-1.335-.05 11 11 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.24 1.24 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a20 20 0 0 1-1.062 2.227 7.7 7.7 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103" />
                            </svg>
                            @break
                            @default
                            <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-image" viewBox="0 0 16 16">
                                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1z" />
                            </svg>
                            @endswitch
                        </a>
                    </td>
                    @else
                    <td></td>
                    @endif

                    {{-- DOWNLOAD --}}
                    <td class="text-center">
                        <a href="pub-share/{{ $file->id }}/download">
                            <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" style="cursor: pointer" class="bi bi-download" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z" />
                            </svg>
                        </a>
                    </td>
                    {{-- DELETE --}}
                    <td class="text-center" style="width: 50px;">
                        <span data-bs-toggle="modal" data-bs-target="#modal_confirm" onclick="return JS.modalConfirm('/pub-share/delete/{{ $file->id }}')" style="cursor: pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#dc3545" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                            </svg>
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
    @endif

    <script>
        const file = document.getElementById("file");
        const buttonUpload = document.getElementById('button_upload');
        const form = document.getElementById('form');
        const messageFileInput = document.getElementById('message_file_input');

        file.onchange = (e) => checkFileSize(e);

        function checkFileSize(e) {
            let fileSize = e.target.files[0].size;

            if (fileSize > 40000000) {
                alert('The maximum upload file size is 40 MB.')
                form.reset();
                clearMessageFile();
            } else {

                clearMessageFile();
                let messageFileSize = document.createElement('div');
                messageFileSize.classList.add('form-text', 'text-success');

                if (fileSize < 1000) {
                    messageFileSize.textContent = `File size: ${fileSize} Byte.`;
                } else if (fileSize > 1000 && fileSize < 1000000) {
                    messageFileSize.textContent = `File size: ${Math.round(((fileSize / 1000) + Number.EPSILON) * 100) / 100} KB.`;
                } else {
                    messageFileSize.textContent = `File size: ${Math.round(((fileSize / 1000000) + Number.EPSILON) * 100) / 100} MB.`;
                }

                messageFileInput.appendChild(messageFileSize);
            }
        }

        function clearMessageFile() {
            while (messageFileInput.firstChild) {
                messageFileInput.firstChild.remove();
            }
        }
    </script>

</x-app-layout>