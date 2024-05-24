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

    @if (session('alert'))
        <x-alert :alert="session('alert')">
        </x-alert>
    @endisset

    @if (session('errors'))
        <x-alerts></x-alerts>
    @endif

    {{-- FORM --}}
    <section>
        <form action="/{{ $action }}" id="forms" method="POST" enctype="multipart/form-data">
            @csrf
            @isset($issue)
                <x-input-hidden :id="'id'" :name="'id'" :value="$issue->id" />
            @endisset

            {{-- STATUS --}}
            <div class="mb-3">
                <x-input-label for='status' :value="__('Status *')" />
                <x-input-select id='status' name='status' :options="['NOT', 'MONITORING', 'DONE']" :value="old('status', $issue->status ?? '')" />
                <x-input-error :message="$errors->first('status')" />
            </div>

            {{-- ISSUED DATE --}}
            <div class="mb-3">
                <x-input-label for='issued_date' :value="__('Issued date *')" />
                <x-input-date id='issued_date' name='issued_date' :value="old(
                    'issued_date',
                    isset($issue)
                        ? Carbon\Carbon::create($issue->issued_date)->toDateString()
                        : Carbon\Carbon::now()->toDateString(),
                )" />
                <x-input-error :message="$errors->first('issued_date')" />
            </div>

            {{-- TARGET DATE --}}
            <div class="mb-3">
                <x-input-label for='target_date' :value="__('Target date *')" />
                <x-input-date id='target_date' name='target_date' :value="old(
                    'target_date',
                    isset($issue)
                        ? Carbon\Carbon::create($issue->target_date)->toDateString()
                        : Carbon\Carbon::now()->toDateString(),
                )" />
                <x-input-error :message="$errors->first('target_date')" />
            </div>

            {{-- SECTION --}}
            <div class="mb-3">
                <x-input-label for='section' :value="__('Section *')" />
                <x-input-select id='section' name='section' :options="['ELC', 'INS', 'ELC/INS']" :value="old('target_date', $issue->target_date ?? '')" />
                <x-input-error :message="$errors->first('section')" />
            </div>

            {{-- AREA --}}
            <div class="mb-3">
                <x-input-label for='area' :value="__('Area *')" />
                <x-input-select id='area' name='area' :options='$utility->areas()' :value="old('area', $issue->area ?? '')"
                    :choose="''" />
                <x-input-error :message="$errors->first('area')" />
            </div>

            {{-- DESCRIPTION --}}
            <div class="mb-3">
                <x-input-label for='description' :value="__('Description *')" />
                <x-input-textarea id='description' name='description'
                    :placeholder="'Write clearly'">{{ old('description', $issue->description ?? '') }}</x-input-textarea>
                <x-input-error :message="$errors->first('description')" />
            </div>

            {{-- CORRECTIVE ACTION --}}
            <div class="mb-3">
                <x-input-label for='corrective_action' :value="__('Corrective action')" />
                <x-input-textarea id='corrective_action' name='corrective_action'
                    :placeholder="'Write clearly'">{{ old('corrective_action', $issue->corrective_action ?? '') }}</x-input-textarea>
                <x-input-error :message="$errors->first('corrective_action')" />
            </div>

            {{-- ROOT CAUSE --}}
            <div class="mb-3">
                <x-input-label for='root_cause' :value="__('Root cause')" />
                <x-input-textarea id='root_cause' name='root_cause'
                    :placeholder="'Write clearly'">{{ old('root_cause', $issue->root_cause ?? '') }}</x-input-textarea>
                <x-input-error :message="$errors->first('root_cause')" />
            </div>

            {{-- PREVENTIVE ACTION --}}
            <div class="mb-3">
                <x-input-label for='preventive_action' :value="__('Preventive action')" />
                <x-input-textarea id='preventive_action' name='preventive_action'
                    :placeholder="'Write clearly'">{{ old('preventive_action', $issue->preventive_action ?? '') }}</x-input-textarea>
                <x-input-error :message="$errors->first('preventive_action')" />
            </div>

            {{-- REMARK --}}
            <div class="mb-3">
                <x-input-label for='remark' :value="__('Remark')" />
                <x-input-text id='remark' name='remark' :value="old('remark', $issue->remark ?? '')" />
                <x-input-error :message="$errors->first('remark')" />
            </div>

            <div class="mb-3">
                <x-button-primary>
                    @isset($issue)
                        {{ __('Save changes') }}
                    @else
                        {{ __('Submit') }}
                    @endisset
                </x-button-primary>
            </div>

        </form>
    </section>

</x-app-layout>
