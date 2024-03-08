<x-app-layout>

    @php
    $skipped = ['sort_field', 'description', 'material_number', 'qr_code_link', 'created_at'];
    @endphp

    @inject('utility', 'App\Services\Utility')

    <section class="mb-4">
        <x-h3>{{ $title }}</x-h3>

        @if (Auth::user()->isAdmin())
        {{-- BUTTON NEW --}}
        <x-button-new :href='"/motor-registration"'>
            {{ __('New motor') }}
            <x-slot:dropdown>
                <x-dropdown-button :href='"/motor-install-dismantle"'>
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
                <x-input-text id="search" type="text" name="search" placeholder="Equipment"></x-input-text>
            </div>
            {{-- BY STATUS --}}
            <div class="col ps-1">
                <x-input-label for="status" :value="__('Status')" />
                <x-input-select id="status" name="status" :options="['Installed', 'Available', 'Repaired']" :choose="''"></x-input-select>
            </div>
            <x-footer-header-table :paginator='$paginator' />
        </div>
    </section>

    {{-- MOTOR DATA --}}
    <section class="mb-4 overflow-x-auto">
        {{-- TABLE --}}
        <table class="rounded table table-hover mb-0 border border-1 shadow-sm table-responsive-md" style="min-width: 800px;">
            <thead>
                <tr>
                    @foreach ($utility::getColumns('motors', $skipped) as $column)
                    <th style="line-height: 30px">{{ $column == 'funcloc' ? 'Functional location' : ucfirst(str_replace('_' , ' ', $column)) }}</th>
                    @endforeach

                    {{-- VIEW OR EDIT MOTOR --}}
                    @if (Auth::user()->isAdmin())
                    <th style="width: 50px;">Edit</th>
                    @else
                    <th style="width: 50px;">Details</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($paginator->items() as $motor)
                <tr class="table-row">
                    @foreach ($utility::getColumns('motors', $skipped) as $column)
                    <td>{{ $motor->$column }}</td>
                    @endforeach

                    @if (Auth::user()->isAdmin())
                    <td class="text-center" style="width: 40px">
                        <a href="/motor-edit/{{ $motor->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                            </svg>
                        </a>
                    </td>
                    @else
                    <td class="text-center text-danger" style="width: 50px">
                        <a href="/motor-details/{{ $motor->id }}">
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

    </section>

    {{-- PAGINATION --}}
    @if ($paginator->hasPages())
    <x-paginator :paginator="$paginator"></x-paginator>
    @endif

    <script type="module">
        let search = document.getElementById("search");
        let status = document.getElementById("status");

        JS.fillInputFilterFromUrlSearchParams(search, status)

        function doFilter() {
            JS.filter(search, status);
        }

        search.oninput = JS.debounce(doFilter, 300);
        status.oninput = JS.debounce(doFilter, 0);
    </script>

</x-app-layout>