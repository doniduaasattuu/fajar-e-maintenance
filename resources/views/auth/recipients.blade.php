<x-app-layout>

    @inject('utility', 'App\Services\Utility')

    @php
    $skipped = ['updated_at'];
    @endphp

    @if (Auth::user()->isSuperAdmin())
    <x-modal-confirm></x-modal-confirm>
    @endif

    <section class="mb-4">
        <x-h3>{{ $title }}</x-h3>

        <div class="row mb-3">
            {{-- ADD RECIPIENT --}}
            <div class="col pe-1">
                <form action="{{ route('add-email-recipient') }}" method="POST">
                    @csrf
                    <x-input-label for="email" :value="__('Add')" />
                    <div class="input-group">
                        <x-input-text id="email" type="email" name="email" placeholder="Email" :value='old("email")' />
                        <x-button-primary-outline>
                            {{ __('Add') }}
                        </x-button-primary-outline>
                    </div>
                </form>
            </div>
            {{-- FILTER SEARCH --}}
            <div class="col ps-1">
                <x-input-label for="search" :value="__('Search')" />
                <x-input-text id="search" type="text" name="search" placeholder="Email"></x-input-text>
            </div>
            @if ($errors->first('email'))
            <x-input-error :message='$errors->first("email")' />
            @else
            <x-footer-header-table :paginator='$paginator' />
            @endif
        </div>
    </section>

    {{-- RECIPIENTS DATA --}}
    <section class="mb-4 overflow-x-auto">
        {{-- TABLE --}}
        <table class="rounded table table-hover mb-0 border border-1 shadow-sm table-responsive-md" style="min-width: 600px;">
            <thead>
                <tr>
                    <th style="line-height: 30px; min-width: 30px;">#</th>
                    @foreach ($utility::getColumns('email_recipients', $skipped) as $column)
                    <th style="line-height: 30px">{{ $column == 'created_at' ? 'Subscribed at' : ucfirst(str_replace('_' , ' ', $column)) }}</th>
                    @endforeach

                    {{-- DELETE RECIPIENT --}}
                    @if (Auth::user()->isSuperAdmin())
                    <th style="width: 50px;">Delete</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($paginator->items() as $recipient)
                <tr class="table-row">
                    <td style="min-width: 30px;">{{ $loop->iteration }}</td>
                    @foreach ($utility::getColumns('email_recipients', $skipped) as $column)
                    <td>{{ $recipient->$column }}</td>
                    @endforeach

                    @if (Auth::user()->isSuperAdmin())
                    {{-- DELETE RECIPIENT --}}
                    <td class="text-center" style="width: 50px;">
                        <span data-bs-toggle="modal" data-bs-target="#modal_confirm" onclick="return JS.modalConfirm('/recipient-delete/{{ $recipient->email }}')" style="cursor: pointer">
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