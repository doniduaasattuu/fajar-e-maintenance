<x-app-layout>

    <x-modal-confirm></x-modal-confirm>

    <section class="mb-4">
        <x-h3>{{ $title }}</x-h3>

        {{-- FILTERING --}}
        <div class="row mb-3">

            {{-- BY FILE --}}
            <div class="col-md pe-md-1 mb-2 mb-md-0">
                <x-input-label for="file" :value="__('File *')" />
                <x-input-file id="file" name="file" />
            </div>

            {{-- FILE NAME --}}
            <div class="col-md ps-md-1">
                <x-input-label for="file_name" :value="__('File name')" class="d-none d-md-block" />
                <div class=" input-group">
                    <x-input-text id="file_name" type="text" name="file_name" :placeholder='"Leave blank to use the original name"' />
                    <x-button-primary>
                        {{ __('Upload') }}
                    </x-button-primary>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-4 overflow-x-auto">
        {{-- TABLE --}}
        <table class="rounded table table-hover mb-0 border border-1 shadow-sm table-responsive-md" style="min-width: 800px;">
            <thead>
                <tr>
                    <th style="line-height: 30px">#</th>
                    <th style="line-height: 30px">Id</th>
                    <th style="line-height: 30px">File Name</th>
                    <th style="line-height: 30px">Uploaded by</th>
                    <th style="line-height: 30px">File</th>
                    <th style="width: 50px; line-height: 30px">Delete</th>
                </tr>
            </thead>
            <tbody>
                <tr class="table-row">
                    <td>1</td>
                    <td>7fbcd1</td>
                    <td>Foto Finding.jpg</td>
                    <td>Doni Darmawan</td>
                    {{-- DOWNLOAD --}}
                    <td>
                        <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" style="cursor: pointer" class="bi bi-download" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z" />
                        </svg>
                    </td>
                    {{-- DELETE --}}
                    <td class="text-center" style="width: 50px;">
                        <span data-bs-toggle="modal" data-bs-target="#modal_confirm" onclick="return JS.modalConfirm('/pub-share/delete')" style="cursor: pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#dc3545" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                            </svg>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>

</x-app-layout>