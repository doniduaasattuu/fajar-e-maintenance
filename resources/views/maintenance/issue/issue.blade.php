<x-app-layout>

    @inject('utility', 'App\Services\Utility')
    @php
    $skipped = ['id', 'target_date', 'department', 'created_at', 'updated_at'];
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

            {{-- BY DESCRIPTION --}}
            <div class="col ps-1">
                <x-input-label for="search" :value="__('Search')" />
                <x-input-text id="search" type="text" name="search" placeholder="Any"></x-input-text>
            </div>

        </div>
    </section>

    {{-- FINDING DATA --}}
    <section class="mb-4">
        <div class="overflow-x-auto">
            <table class="rounded table table-hover table-striped mb-0 border border-1 shadow-sm table-responsive-md" style="min-width: 3500px;">
                <thead>
                    <tr>
                        <th style="width: 30px; line-height: 30px;">#</th>
                        @foreach ($utility::getColumns('issues', $skipped) as $column)
                        <th style="line-height: 30px">{{ ucfirst(str_replace('_' , ' ', $column)) }}</th>
                        @endforeach

                        @if (Auth::user()->isAdmin())
                        <th style="line-height: 30px" style="width: 50px;">Edit</th>
                        <th style="line-height: 30px" style="width: 50px;">Delete</th>
                        @endif
                    </tr>
                </thead>
                <tbody id="issue_data">
                    @foreach ($issues as $issue)
                    <tr class="table-row">
                        <td>{{ $loop->iteration }}</td>
                        @foreach ($utility::getColumns('issues', $skipped) as $column)

                        @if ($column == 'issued_date' || $column == 'target_date' )
                        <td style="width: 120px;">{{ Carbon\Carbon::create($issue->$column)->format('d-M-Y') }}</td>

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

                        @if (Auth::user()->isSuperAdmin())
                        {{-- EDIT ISSUE --}}
                        <td class="text-center" style="width: 50px;">
                            <a href="/issue-edit/{{ $issue->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#0d6efd" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                </svg>
                            </a>
                        </td>

                        {{-- DELETE ISSUE --}}
                        <td class="text-center" style="width: 50px;">
                            <span data-bs-toggle="modal" data-bs-target="#modal_confirm" onclick="return JS.modalConfirm('/issue-delete/{{ $issue->id }}')" style="cursor: pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#dc3545" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                </svg>
                            </span>
                        </td>
                        @endif

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