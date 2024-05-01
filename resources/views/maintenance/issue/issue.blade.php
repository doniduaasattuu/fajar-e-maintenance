<x-app-layout>

    @inject('utility', 'App\Services\Utility')
    @php
    $skipped = ['id', 'department', 'created_at', 'updated_at'];
    @endphp

    <x-modal-confirm />

    <section class="mb-4">
        <x-h3>What's going on {{ Auth::user()->department }}</x-h3>

        {{-- BUTTON NEW --}}
        <x-button-new :href='"/issue-registration"'>
            {{ __('New issue') }}
        </x-button-new>

        {{-- FILTERING --}}
        <div class="row mb-3">

            {{-- BY STATUS --}}
            <div class="col pe-1">
                <x-input-label for="status" :value="__('Status')" />
                <x-input-select id="status" name="status" :options="['NOT', 'MONITORING', 'DONE']" :choose="''"></x-input-select>
            </div>

            {{-- BY STATUS --}}
            <div class="col ps-1">
                <x-input-label for="search" :value="__('Search')" />
                <x-input-text id="search" type="text" name="search" placeholder="Description"></x-input-text>
            </div>

        </div>
    </section>

    {{-- FINDING DATA --}}
    <section class="mb-4">
        <div class="overflow-x-auto">
            <table class="rounded table table-hover mb-0 border border-1 shadow-sm table-responsive-md" style="min-width: 4000px;">
                <thead>
                    <tr>
                        <th style="width: 30px; line-height: 30px;">#</th>
                        @foreach ($utility::getColumns('issues', $skipped) as $column)
                        <th style="line-height: 30px">{{ ucfirst(str_replace('_' , ' ', $column)) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody id="issue_data">
                    @foreach ($issues as $issue)
                    <tr class="table-row">
                        <td>{{ $loop->iteration }}</td>
                        @foreach ($utility::getColumns('issues', $skipped) as $column)

                        @if ($column == 'issued_date' || $column == 'target_date' )
                        <td style="width: 120px;">{{ Carbon\Carbon::create($issue->$column)->format('d-m-Y') }}</td>

                        @elseif($column == 'section' || $column == 'area' || $column == 'status')
                        <td style="width: 100px;">{{ $issue->$column }}</td>

                        @elseif ($column == 'remaining_days')
                        @if ($issue->status !== 'DONE')
                        <td style="width: 180px;">{{ Carbon\Carbon::create($issue->$column)->diffForHumans() }}</td>
                        @else
                        <td style="width: 180px;">DONE</td>
                        @endif

                        @elseif ($column == 'description' || $column == 'corrective_action' || $column == 'root_cause' || $column == 'preventive_action')
                        <td style="width: 500px;">{{ $issue->$column }}</td>

                        @else
                        <td>{{ $issue->$column }}</td>

                        @endif
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <script type="module">
        let status = document.getElementById("status");
        let search = document.getElementById("search");

        JS.fillInputFilterFromUrlSearchParams(status, search)

        function doFilter() {
            JS.filter(status, search);
        }

        status.onchange = JS.debounce(doFilter, 0);
        search.oninput = JS.debounce(doFilter, 300);
    </script>

</x-app-layout>