<x-app-layout>

    @inject('utility', 'App\Services\Utility')

    {{-- BREADCUMB --}}
    <section>
        @isset($funcloc)
        <x-breadcumb-table :title='$title' :table="'Funclocs'" :table_item='$funcloc' />
        @else
        <x-breadcumb-table :title='$title' :table="'Funclocs'" />
        @endisset
    </section>

    @if(session("alert"))
    <x-alert :alert='session("alert")'>
    </x-alert>
    @endisset

    <section>
        <form action="/{{ $action ?? '' }}" id="forms" method="POST">
            @csrf

            {{-- FUNCLOC DATA --}}
            @isset($funcloc)
            @foreach ($utility::getColumns('funclocs') as $column)
            <div class="mb-3">
                <x-input-label for="{{ $column }}" :value="__($column == 'id' ? 'Functional location' : ucfirst(str_replace('_' , ' ', $column)))" />
                <x-input-number-text id="{{ $column }}" name="{{ $column }}" :value='old($column, $funcloc->$column ?? "" )' :disabled='!Auth::user()->isAdmin()' :readonly='$column != "description"' />
                <x-input-error :message="$errors->first($column)" />
            </div>
            @endforeach
            @else
            @foreach ($utility::getColumns('funclocs') as $column)
            <div class="mb-3">
                <x-input-label for="{{ $column }}" :value="__($column == 'id' ? 'Functional location' : ucfirst(str_replace('_' , ' ', $column)))" />
                <x-input-number-text id="{{ $column }}" name="{{ $column }}" :value='old($column, ($column == "created_at" || $column == "updated_at") ? Carbon\Carbon::now()->toDateTimeString() : "" )' :disabled='!Auth::user()->isAdmin()' :readonly='$column == "created_at" || $column == "updated_at"' />
                <x-input-error :message="$errors->first($column)" />
            </div>
            @endforeach
            @endisset

            @if (Auth::user()->isAdmin())
            {{-- BUTTON SUBMIT --}}
            <div class="mb-3">
                <x-button-primary>
                    @isset($funcloc)
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