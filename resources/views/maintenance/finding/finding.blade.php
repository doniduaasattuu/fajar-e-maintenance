<x-app-layout>

    @inject('utility', 'App\Services\Utility')

    <x-modal-confirm></x-modal-confirm>

    <section class="mb-4">
        <x-h3>{{ $title }}</x-h3>

        {{-- BUTTON NEW --}}
        <x-finding.button-new :href='"/finding-registration"'>
            {{ __('New finding') }}
        </x-finding.button-new>

        {{-- FILTERING --}}
        <div class="row mb-3">

            {{-- BY DEPT --}}
            <div class="col pe-1">
                <x-input-label for="dept" :value="__('Dept')" />
                <x-input-select id="dept" name="dept" :options="$utility::getEnumValue('user', 'department')" :choose="''"></x-input-select>
                </select>
            </div>

            {{-- BY STATUS --}}
            <div class="col ps-1 pe-md-1">
                <x-input-label for="status" :value="__('Status')" />
                <x-input-select id="status" name="status" :options="['Open', 'Closed']" :choose="''"></x-input-select>
            </div>

            {{-- FILTER SEARCH --}}
            <div class="col-md ps-md-1 ps-md-1">
                <x-input-label for="search" class="d-none d-md-block" :value="__('Search')" />
                <x-input-text id="search" type="text" name="search" class="mt-3 mt-md-0" placeholder="Description"></x-input-text>
            </div>
            <x-footer-header-table :paginator='$paginator' />
        </div>
    </section>

    {{-- FINDING DATA --}}
    <section class="mb-4">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xxl-4 g-2">
            @foreach ($paginator->items() as $finding)
            <div class="col finding">
                <div class="card shadow-md">

                    {{-- FINDING IMAGE --}}
                    <div>
                        @isset($finding->image)
                        <span style="cursor: pointer;">
                            <a href="{{ '/storage/findings/' . $finding->image }}">
                                <img class="card-img-top p-2" style="border-radius: 12px; height: 300px; object-fit: cover;" src="{{ '/storage/findings/' . $finding->image }}" alt="{{ $finding->description }}">
                            </a>
                        </span>
                        @else
                        <div>
                            <img class="card-img-top p-2" style="border-radius: 12px; height: 300px; object-fit: cover;" src="/storage/assets/images/finding-default.png" alt="{{ $finding->description }}">
                        </div>
                        @endisset
                    </div>

                    {{-- FINDING DESCRIPTION --}}
                    <div class="card-body">
                        <div class="mb-2">
                            <h5 class="card-title fw-semibold" style="color: #9b9fa3">{{ $finding->department ?? '' }}</h5>
                            <p class="card-text" style="height: 50px; overflow: hidden;">{{ $finding->description ?? '' }}</p>
                        </div>
                        <div>

                            {{-- FINDING COLUMN --}}
                            @foreach ($utility::getColumns('findings', ['id', 'department', 'description', 'image', 'updated_at']) as $column)
                            @switch($column)

                            @case('funcloc')
                            <div class="row">
                                <div class="col-6 mb-0 fw-semibold" style="color: #9b9fa3">{{ ucfirst($column) }}</div>
                                <div class="col-6 mb-0 text-truncate" style="color: #9b9fa3">{{ str_replace('FP-01-', '', $finding->$column) }}</div>
                            </div>
                            @break

                            @default
                            <div class="row">
                                <div class="col-6 mb-0 fw-semibold" style="color: #9b9fa3">{{ ucfirst($column == 'created_at' ? 'Date' : $column) }}</div>
                                <div class="col-6 mb-0 text-truncate" style="color: #9b9fa3">{{ $column == 'created_at' ? Carbon\Carbon::create($finding->$column)->format('d M Y') : $finding->$column }}</div>
                            </div>
                            @endswitch
                            @endforeach

                        </div>

                        {{-- ACTION BUTTON --}}
                        <div class="row mt-3">
                            <div class="col pe-1">
                                <a href="/finding-edit/{{ $finding->id }}" class="btn btn-outline-primary btn-sm w-100">
                                    <svg class="mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                    </svg>
                                    Edit
                                </a>
                            </div>
                            <div class="col ps-1">
                                <span class="btn btn-outline-danger btn-sm w-100" data-bs-toggle="modal" data-bs-target="#modal_confirm" onclick="return JS.modalConfirm('/finding-delete/{{ $finding->id }}')" style="cursor: pointer">
                                    <svg class="mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                    </svg>
                                    Delete
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    {{-- PAGINATION --}}
    @if ($paginator->hasPages())
    <x-paginator :paginator="$paginator"></x-paginator>
    @endif

    <script type="module">
        let dept = document.getElementById("dept");
        let status = document.getElementById("status");
        let search = document.getElementById("search");

        JS.fillInputFilterFromUrlSearchParams(dept, status, search)

        function doFilter() {
            JS.filter(dept, status, search);
        }

        dept.oninput = JS.debounce(doFilter, 0);
        status.oninput = JS.debounce(doFilter, 0);
        search.oninput = JS.debounce(doFilter, 300);
    </script>


</x-app-layout>