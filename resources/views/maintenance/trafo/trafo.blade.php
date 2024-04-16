<x-app-layout>

    @inject('utility', 'App\Services\Utility')

    @php
    $skipped = ['description', 'material_number', 'qr_code_link', 'created_at'];
    @endphp

    <section class="mb-4">
        <x-h3>{{ $title }}</x-h3>

        @if (Auth::user()->isAdmin())
        {{-- BUTTON NEW --}}
        <x-button-new :href='"/trafo-registration"'>
            {{ __('New trafo') }}
            <x-slot:dropdown>
                <x-dropdown-button :href='"/trafo-install-dismantle"'>
                    {{ __('Install / Dismantle') }}
                </x-dropdown-button>
            </x-slot:dropdown>
        </x-button-new>

        @endif

        {{-- FILTERING --}}
        <div class="row mb-3">
            {{-- FILTER SEARCH --}}
            <div class="col pe-1">
                <x-input-label for="search" :value="__('Search')" />
                <x-input-text id="search" type="text" name="search" placeholder="Equipment" oninput="return JS.toupper(this)" onkeydown="event.keyCode == 13 ? JS.filter(this) : null" onkeyup="this.value.length == 0 && (event.keyCode == 46 || event.keyCode == 8 ) ? setTimeout(() => {if(!this.value.length > 0) {JS.filter(this)}}, 5000) : null" />
            </div>
            {{-- BY STATUS --}}
            <div class="col ps-1">
                <x-input-label for="status" :value="__('Status')" />
                <x-input-select id="status" name="status" :options="['Installed', 'Available', 'Repaired']" :choose="''"></x-input-select>
            </div>
            <div class="form-text">Total {{ $total }} entries.</div>
        </div>
    </section>

    {{-- TRAFO DATA --}}
    <section class="mb-2">
        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="rounded table table-hover mb-0 border border-1 shadow-sm table-responsive-md" style="min-width: 992px;">
                <thead>
                    <tr>
                        @foreach ($utility::getColumns('trafos', $skipped) as $column)
                        <th style="line-height: 30px">{{ $column == 'funcloc' ? 'Functional location' : ucfirst(str_replace('_' , ' ', $column)) }}</th>
                        @endforeach

                        {{-- VIEW OR EDIT TRAFO --}}
                        @if (Auth::user()->isAdmin())
                        <th style="width: 50px; line-height: 30px">Edit</th>
                        @else
                        <th style="width: 50px; line-height: 30px">Details</th>
                        @endif
                    </tr>
                </thead>
                <tbody id="trafo_data">
                    @foreach ($paginator->items() as $trafo)
                    <tr class="table-row">
                        @foreach ($utility::getColumns('trafos', $skipped) as $column)
                        <td>{{ $trafo->$column }}</td>
                        @endforeach

                        @if (Auth::user()->isAdmin())
                        <td class="text-center" style="width: 40px">
                            <a href="/trafo-edit/{{ $trafo->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                </svg>
                            </a>
                        </td>
                        @else
                        <td class="text-center text-danger" style="width: 40px">
                            <a href="/trafo-details/{{ $trafo->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-info-square-fill" viewBox="0 0 16 16">
                                    <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm8.93 4.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                                </svg>
                            </a>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <x-footer-header-table-cursor :paginator='$paginator' :total='$total' />
    </section>

    @if (!$paginator->onLastPage())
    <div id="button_load" onclick="loadData()" class="mb-3 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="#adb5bd" class="bi bi-arrow-down-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293z" />
        </svg>
    </div>
    @endif

    <script>
        const trafo_data = document.getElementById('trafo_data');
        let display_count = document.getElementById('display_count');
        const isAdmin = <?php echo json_encode(Auth::user()->isAdmin()); ?>;
        const button_load = document.getElementById('button_load');
        let nextPage = <?php echo json_encode($paginator->nextPageUrl()); ?>;

        async function getNextPageJSON(nextPage) {
            if (nextPage != null) {
                let link = nextPage + '&json=true';

                const response = await fetch(link);
                return response.json();
            }
        }

        document.body.onscroll = () => {
            loadData();
        }

        function loadData() {
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                setTimeout(() => {
                    if (nextPage) {
                        getNextPageJSON(nextPage)
                            .then((cursor) => {

                                display_count.textContent = Number(display_count.textContent) + cursor.data.length;

                                for (let trafo of cursor.data) {
                                    addtrafoRow(trafo);
                                }
                                nextPage = cursor.next_page_url;
                            })
                            .finally(() => {
                                if (nextPage == null) {
                                    button_load.classList.add('d-none');
                                }
                            })
                    }
                }, 500);
            }
        }

        function addtrafoRow(trafo) {
            let tr = document.createElement('tr');
            tr.classList.add('table-row');

            id = document.createElement('td');
            id.textContent = trafo.id ?? '';

            let status = document.createElement('td');
            status.textContent = trafo.status ?? '';

            let funcloc = document.createElement('td');
            funcloc.textContent = trafo.funcloc ?? '';

            let sort_field = document.createElement('td');
            sort_field.textContent = trafo.sort_field ?? '';

            let unique_id = document.createElement('td');
            unique_id.textContent = trafo.unique_id ?? '';

            let updated_at = document.createElement('td');
            updated_at.textContent = trafo.updated_at ?? '';

            let edit = document.createElement('td');
            edit.classList.add('text-center')
            edit.style.width = '40px';

            if (isAdmin) {
                edit.innerHTML = `
                <a href="/trafo-edit/${trafo.id}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                    </svg>
                </a>
                `;
            } else {
                edit.innerHTML = `
                <a href="/trafo-details/${trafo.id}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-info-square-fill" viewBox="0 0 16 16">
                        <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm8.93 4.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                    </svg>
                </a>
                `;
            }

            tr.appendChild(id)
            tr.appendChild(status)
            tr.appendChild(funcloc)
            tr.appendChild(sort_field)
            tr.appendChild(unique_id)
            tr.appendChild(updated_at)
            tr.appendChild(edit)

            trafo_data.appendChild(tr);
        }
    </script>

    <script type="module">
        let search = document.getElementById("search");
        let status = document.getElementById("status");

        JS.fillInputFilterFromUrlSearchParams(search, status)

        function doFilter() {
            JS.filter(search, status);
        }

        // search.oninput = JS.debounce(doFilter, 300);
        status.oninput = JS.debounce(doFilter, 0);
    </script>

</x-app-layout>