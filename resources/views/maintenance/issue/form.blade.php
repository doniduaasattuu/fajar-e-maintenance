<x-app-layout>

    @inject('utility', 'App\Services\Utility')

    {{-- BREADCUMB --}}
    <section>
        @isset($issue)
        <x-breadcumb-table :title='$title' :table="'Issues'" :table_item='$issue' />
        @else
        <x-breadcumb-table :title='$title' :table="'Issues'" />
        @endisset
    </section>

    @if(session("alert"))
    <x-alert :alert='session("alert")'>
    </x-alert>
    @endisset

    {{-- FORM --}}
    <section>
        <form action="/{{ $action }}" id="forms" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- TARGET DATE --}}
            <div class="mb-3">
                <x-input-label for='target_date' :value="__('Target date *')" />
                <x-input-date />
            </div>

            {{-- SECTION --}}
            <div class="mb-3">
                <x-input-label for='section' :value="__('Section *')" />
                <x-input-select :options='["ELC", "INS", "ELC/INS"]' />
            </div>

            {{-- AREA --}}
            <div class="mb-3">
                <x-input-label for='area' :value="__('Area *')" />
                <x-input-select :options='$utility->areas()' />
            </div>

        </form>
    </section>

</x-app-layout>