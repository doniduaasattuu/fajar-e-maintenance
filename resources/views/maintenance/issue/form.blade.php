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

            {{-- STATUS --}}
            <div class="mb-3">
                <x-input-label for='status' :value="__('Status *')" />
                <x-input-select id='status' name='status' :options='["NOT", "MONITORING", "DONE"]' :value="old('status')" />
                <x-input-error :message="$errors->first('status')" />
            </div>

            {{-- TARGET DATE --}}
            <div class="mb-3">
                <x-input-label for='target_date' :value="__('Target date *')" />
                <x-input-date id='target_date' name='target_date' :value="old('target_date')" />
                <x-input-error :message="$errors->first('target_date')" />
            </div>

            {{-- SECTION --}}
            <div class="mb-3">
                <x-input-label for='section' :value="__('Section *')" />
                <x-input-select id='section' name='section' :options='["ELC", "INS", "ELC/INS"]' :value="old('target_date')" />
                <x-input-error :message="$errors->first('target_date')" />
            </div>

            {{-- AREA --}}
            <div class="mb-3">
                <x-input-label for='area' :value="__('Area *')" />
                <x-input-select id='area' name='area' :options='$utility->areas()' :value="old('area')" />
                <x-input-error :message="$errors->first('area')" />
            </div>

            {{-- DESCRIPTION --}}
            <div class="mb-3">
                <x-input-label for='description' :value="__('Description *')" />
                <x-input-textarea id='description' name='description' :value="old('description')" :placeholder='"Write clearly"' />
                <x-input-error :message="$errors->first('description')" />
            </div>

            {{-- CORRECTIVE ACTION --}}
            <div class="mb-3">
                <x-input-label for='corrective_action' :value="__('Corrective action')" />
                <x-input-textarea id='corrective_action' name='corrective_action' :value="old('corrective_action')" :placeholder='"Write clearly"' />
                <x-input-error :message="$errors->first('corrective_action')" />
            </div>

            {{-- ROOT CAUSE --}}
            <div class="mb-3">
                <x-input-label for='root_cause' :value="__('Root cause')" />
                <x-input-textarea id='root_cause' name='root_cause' :value="old('root_cause')" :placeholder='"Write clearly"' />
                <x-input-error :message="$errors->first('root_cause')" />
            </div>

            {{-- PREVENTIVE ACTION --}}
            <div class="mb-3">
                <x-input-label for='preventive_action' :value="__('Preventive action')" />
                <x-input-textarea id='preventive_action' name='preventive_action' :value="old('preventive_action')" :placeholder='"Write clearly"' />
                <x-input-error :message="$errors->first('preventive_action')" />
            </div>

            {{-- REMARK --}}
            <div class="mb-3">
                <x-input-label for='remark' :value="__('Remark')" />
                <x-input-text id='remark' name='remark' :value="old('remark')" />
                <x-input-error :message="$errors->first('remark')" />
            </div>

            <div class="mb-3">
                <x-button-primary>
                    {{ __('Submit') }}
                </x-button-primary>
            </div>

        </form>
    </section>

</x-app-layout>