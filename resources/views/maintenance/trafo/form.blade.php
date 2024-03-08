<x-app-layout>

    @inject('utility', 'App\Services\Utility')

    {{-- BREADCUMB --}}
    <section>
        @isset($trafo)
        <x-breadcumb-table :title='$title' :table="'Trafos'" :table_item='$trafo' />
        @else
        <x-breadcumb-table :title='$title' :table="'Trafos'" />
        @endisset
    </section>

    @if(session("alert"))
    <x-alert :alert='session("alert")'>
    </x-alert>
    @endisset

    {{-- ALERT HIDDEN INPUT --}}
    <x-alert-hidden :hidden='["trafo_detail"]' />

    <section>
        <form action="/{{ $action ?? '' }}" id="forms" method="POST">
            @csrf

            {{-- trafo DATA --}}
            @isset($trafo)
            <x-form-equipment :equipment='$trafo' :utility='$utility' :table='"trafos"' />
            @else
            <x-form-equipment :utility='$utility' :table='"trafos"' :qr_code_link='"id=Fajar-TrafoList"' />
            @endisset

            {{-- trafo DETAIL --}}
            <x-alert :alert='new App\Data\Alert("All fields below can be blank.", "alert-info")' :button_close='true' />

            @isset($trafoDetail)
            <x-trafo.trafo-detail :trafoDetail='$trafoDetail' :utility='$utility' :trafo='$trafo' />
            @else
            <x-trafo.trafo-detail :utility='$utility' />
            @endisset

            @if (Auth::user()->isAdmin())
            {{-- BUTTON SUBMIT --}}
            <div class="mb-3">
                <x-button-primary>
                    @isset($trafo)
                    {{ __('Save changes') }}
                    @else
                    {{ __('Submit') }}
                    @endisset
                </x-button-primary>
            </div>
            @endif

        </form>
    </section>

    <script>
        let current_funcloc = '';
        let current_sort_field = '';

        const status = document.getElementById('status');
        const funcloc = document.getElementById('funcloc');
        const sort_field = document.getElementById('sort_field');

        function disabledFunclocAndSortField(status, funcloc, sort_field) {
            if (status.value == 'Repaired' || status.value == 'Available') {
                // IF STATUS VALUE IS NOT INSTALLED
                if (funcloc.value.length > 0 || sort_field.value.length > 0) {
                    current_funcloc = funcloc.value;
                    current_sort_field = sort_field.value;
                }

                funcloc.setAttribute('disabled', true);
                sort_field.setAttribute('disabled', true);

                funcloc.value = '';
                sort_field.value = '';
            } else if (status.value == 'Installed') {
                // IF STATUS VALUE IS INSTALLED
                funcloc.value = current_funcloc;
                sort_field.value = current_sort_field;

                funcloc.removeAttribute('disabled');
                sort_field.removeAttribute('disabled');
            }
        }

        status.onchange = () => {
            disabledFunclocAndSortField(status, funcloc, sort_field);
        }
    </script>

</x-app-layout>