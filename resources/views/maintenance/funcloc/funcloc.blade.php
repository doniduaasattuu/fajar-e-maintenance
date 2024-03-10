<x-app-layout>

    @inject('utility', 'App\Services\Utility')

    @php
    $skipped = ['created_at', 'updated_at'];
    @endphp

    <section class="mb-4">
        <x-h3>{{ $title }}</x-h3>

        @if (Auth::user()->isAdmin())
        {{-- BUTTON NEW --}}
        <x-button-new :href='"/funcloc-registration"'>
            {{ __('New funcloc') }}
        </x-button-new>
        @endif

        {{-- FILTERING --}}
        <div class="row mb-3">
            {{-- FILTER SEARCH --}}
            <div class="col">
                <x-input-label for="search" :value="__('Search')" />
                <x-input-text id="search" type="text" name="search" placeholder="Functional location or description"></x-input-text>
            </div>
            <x-footer-header-table :paginator='$paginator' />
        </div>
    </section>

    {{-- FUNCLOC DATA --}}
    <section class="mb-4 overflow-x-auto">
        {{-- TABLE --}}
        <table class="rounded table table-hover mb-0 border border-1 shadow-sm table-responsive-md" style="min-width: 600px;">
            <thead>
                <tr>
                    @foreach ($utility::getColumns('funclocs', $skipped) as $column)
                    <th style="line-height: 30px">{{ $column == 'id' ? 'Functional location' : ucfirst(str_replace('_' , ' ', $column)) }}</th>
                    @endforeach

                    {{-- VIEW OR EDIT FUNCLOC --}}
                    @if (Auth::user()->isAdmin())
                    <th style="width: 50px; line-height: 30px">Edit</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($paginator->items() as $funcloc)
                <tr class="table-row">
                    @foreach ($utility::getColumns('funclocs', $skipped) as $column)
                    <td>{{ $funcloc->$column }}</td>
                    @endforeach

                    @if (Auth::user()->isAdmin())
                    <td class="text-center" style="width: 40px">
                        <a href="/funcloc-edit/{{ $funcloc->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
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

        JS.fillInputFilterFromUrlSearchParams(search)

        function doFilter() {
            JS.filter(search);
        }

        search.oninput = JS.debounce(doFilter, 300);
    </script>

</x-app-layout>