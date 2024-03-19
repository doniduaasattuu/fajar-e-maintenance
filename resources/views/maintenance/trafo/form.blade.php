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

</x-app-layout>