<x-app-layout>

    @inject('utility', 'App\Services\Utility')

    {{-- BREADCUMB --}}
    <section>
        @isset($motor)
        <x-breadcumb-table :title='$title' :table="'Motors'" :table_item='$motor' />
        @else
        <x-breadcumb-table :title='$title' :table="'Motors'" />
        @endisset
    </section>

    @if(session("alert"))
    <x-alert :alert='session("alert")'>
    </x-alert>
    @endisset

    {{-- ALERT HIDDEN INPUT --}}
    <x-alert-hidden :hidden='["motor_detail"]' />

    <section>
        <form action="/{{ $action ?? '' }}" id="forms" method="POST">
            @csrf

            {{-- MOTOR DATA --}}
            @isset($motor)
            <x-form-equipment :equipment='$motor' :utility='$utility' :table='"motors"' />
            @else
            <x-form-equipment :utility='$utility' :table='"motors"' :qr_code_link='"id=Fajar-MotorList"' />
            @endisset

            {{-- MOTOR DETAIL --}}
            <x-alert :alert='new App\Data\Alert("All fields below can be blank.", "alert-info")' :button_close='true' />

            @isset($motorDetail)
            <x-input-number-text type="hidden" id="motor_detail" name="motor_detail" :value='old("motor_detail", $motorDetail->motor_detail ?? $motor->id ?? "" )' :disabled='!Auth::user()->isAdmin()' />
            <x-motor.motor-detail :motorDetail='$motorDetail' :utility='$utility' :motor='$motor' />
            @else
            <x-motor.motor-detail :utility='$utility' />
            @endisset

            @if (Auth::user()->isAdmin())
            {{-- BUTTON SUBMIT --}}
            <div class="mb-3">
                <x-button-primary>
                    @isset($motor)
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