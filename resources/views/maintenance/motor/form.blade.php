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

</x-app-layout>