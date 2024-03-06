<x-app-layout>

    @php
    $trafo_installed = ($trafo->status != 'Installed');
    $power_rate = $trafoDetail->power_rate ?? 3000;
    $phases = ['r', 's', 't'];
    @endphp

    {{-- HEADER --}}
    <section>
        {{-- CHECKING FORM HEADER --}}
        <x-checking-form.header :equipment='$trafo' :record='isset($record)'>
        </x-checking-form.header>

        {{-- TREND --}}
        <x-checking-form.button-trend :equipment='$trafo'>
        </x-checking-form.button-trend>

        {{-- EQUIPMENT DETAIL --}}
        @isset($trafoDetail)
        <x-checking-form.equipment-detail :equipmentDetail='$trafoDetail' :table='"trafo_details"' :skipped='["id", "trafo_detail"]'>
            {{ __('TRAFO DETAIL') }}
        </x-checking-form.equipment-detail>
        @endisset
    </section>

    @if(session("alert"))
    <x-alert :alert='session("alert")'>
    </x-alert>
    @endisset

    {{-- FORM --}}
    <section>
        <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
            @csrf

            @isset($record)
            <input type="hidden" id="id" name="id" value="{{ $record->id }}">
            @endisset
            <input type="hidden" id="funcloc" name="funcloc" value="{{ $trafo->funcloc ?? $record->funcloc ?? '' }}">
            <input type="hidden" id="trafo" name="trafo" value="{{ $trafo->id ?? $record->trafo ?? '' }}">
            <input type="hidden" id="sort_field" name="sort_field" value="{{ $trafo->sort_field ?? $record->sort_field ?? '' }}">
            <input type="hidden" id="nik" name="nik" value="{{ Auth::user()->nik }}">

            {{-- TRAFO STATUS --}}
            <div class="mb-3">
                <x-input-label for="trafo_status" :value="__('Trafo status *')" />
                <x-input-select id="trafo_status" name="trafo_status" :options='["Online", "Offline"]' :value="old('trafo_status', $record->trafo_status ?? '')" :disabled='$trafo_installed' />
                <x-input-error :message="$errors->first('trafo_status')" />
            </div>

            {{-- PRIMARY CURRENT --}}
            <div class="mb-3">
                <label for="primary_current_phase_r" class="fw-semibold form-label">Primary current</label>
                <div class="row">
                    @foreach ($phases as $phase)
                    @php
                    $column = 'primary_current_phase_' . $phase
                    @endphp
                    <div class="col {{ $phase == 's' ? 'px-0' : ''}}">
                        <x-input-number-coma placeholder='Phase {{ strtoupper($phase) }}' id="{{ $column }}" name="{{ $column }}" :value="old($column, $record->$column ?? '')" :disabled='$trafo_installed' power_rate="{{ $power_rate }}" />
                        <x-input-error :message="$errors->first($column)" />
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- SECONDARY CURRENT --}}
            <div class="mb-3">
                <label for="secondary_current_phase_r" class="fw-semibold form-label">Secondary current</label>
                <div class="row">
                    @foreach ($phases as $phase)
                    @php
                    $column = 'secondary_current_phase_' . $phase
                    @endphp
                    <div class="col {{ $phase == 's' ? 'px-0' : ''}}">
                        <x-input-number-coma placeholder='Phase {{ strtoupper($phase) }}' id="{{ $column }}" name="{{ $column }}" :value="old($column, $record->$column ?? '')" :disabled='$trafo_installed' power_rate="{{ $power_rate }}" />
                        <x-input-error :message="$errors->first($column)" />
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- PRIMARY VOLTAGE --}}
            <div class="mb-3">
                <x-input-label for="primary_voltage" :value="__('Primary voltage')" />
                <x-input-number-coma placeholder="V" id="primary_voltage" name="primary_voltage" :value="old('primary_voltage', $record->primary_voltage ?? '')" :disabled='$trafo_installed' />
                <x-input-error :message="$errors->first('primary_voltage')" />
            </div>

            {{-- SECONDARY VOLTAGE --}}
            <div class="mb-3">
                <x-input-label for="secondary_voltage" :value="__('Secondary voltage')" />
                <x-input-number-coma placeholder="V" id="secondary_voltage" name="secondary_voltage" :value="old('secondary_voltage', $record->secondary_voltage ?? '')" :disabled='$trafo_installed' />
                <x-input-error :message="$errors->first('secondary')" />
            </div>

            {{-- TRAFO IMAGE --}}
            <div class="mb-3">
                <x-checking-form.image.trafo />
            </div>

            {{-- OIL TEMPERATURE --}}
            <div class="mb-3">
                <x-input-label for="oil_temperature" :value="__('Oil temperature')" />
                <x-input-number-coma placeholder="°C" id="oil_temperature" name="oil_temperature" :value="old('oil_temperature', $record->oil_temperature ?? '')" :disabled='$trafo_installed' />
                <x-input-error :message="$errors->first('oil_temperature')" />
            </div>

            {{-- WINDING TEMPERATURE --}}
            <div class="mb-3">
                <x-input-label for="winding_temperature" :value="__('Winding temperature')" />
                <x-input-number-coma placeholder="°C" id="winding_temperature" name="winding_temperature" :value="old('winding_temperature', $record->winding_temperature ?? '')" :disabled='$trafo_installed' />
                <x-input-error :message="$errors->first('winding_temperature')" />
            </div>

            {{-- CLEANLINESS --}}
            <div class="mb-3">
                <x-input-label for="cleanliness" :value="__('Cleanliness')" />
                <x-input-select id="cleanliness" name="cleanliness" :options='["Clean", "Dirty"]' :value="old('cleanliness', $record->cleanliness ?? '')" :disabled='$trafo_installed' />
                <x-input-error :message="$errors->first('cleanliness')" />
            </div>

            {{-- NOISE --}}
            <div class="mb-3">
                <x-input-label for="noise" :value="__('Noise')" />
                <x-input-select id="noise" name="noise" :options='["Normal", "Abnormal"]' :value="old('noise', $record->noise ?? '')" :disabled='$trafo_installed' />
                <x-input-error :message="$errors->first('noise')" />
            </div>

            {{-- SILICA GEL --}}
            <div class="mb-3">
                <x-input-label for="silica_gel" :value="__('Silica gel')" />
                <x-input-select id="silica_gel" name="silica_gel" :options='["Good", "Satisfactory", "Unsatisfactory", "Unacceptable"]' :value="old('silica_gel', $record->silica_gel ?? '')" :disabled='$trafo_installed' />
                <x-input-error :message="$errors->first('silica_gel')" />
            </div>

            {{-- EARTHING CONNECTION --}}
            <div class="mb-3">
                <x-input-label for="earthing_connection" :value="__('Earthing connection')" />
                <x-input-select id="earthing_connection" name="earthing_connection" :options='["No loose", "Loose"]' :value="old('earthing_connection', $record->earthing_connection ?? '')" :disabled='$trafo_installed' />
                <x-input-error :message="$errors->first('earthing_connection')" />
            </div>

            {{-- OIL LEAKAGE --}}
            <div class="mb-3">
                <x-input-label for="oil_leakage" :value="__('Oil leakage')" />
                <x-input-select id="oil_leakage" name="oil_leakage" :options='["No leaks", "Leaks"]' :value="old('oil_leakage', $record->oil_leakage ?? '')" :disabled='$trafo_installed' />
                <x-input-error :message="$errors->first('oil_leakage')" />
            </div>

            {{-- OIL LEVEL --}}
            <div class="mb-3">
                <x-input-label for="oil_level" :value="__('Oil level')" />
                <x-input-number placeholder="%" id="oil_level" name="oil_level" :value="old('oil_level', $record->oil_level ?? '')" :disabled='$trafo_installed' />
                <x-input-error :message="$errors->first('oil_level')" />
            </div>

            {{-- BLOWER CONDITION --}}
            <div class="mb-3">
                <x-input-label for="blower_condition" :value="__('Blower condition')" />
                <x-input-select id="blower_condition" name="blower_condition" :options='["Good", "Not good"]' :value="old('blower_condition', $record->blower_condition ?? '')" :disabled='$trafo_installed' />
                <x-input-error :message="$errors->first('blower_condition')" />
            </div>

            {{-- FINDING DESCRIPTION --}}
            <div class="mb-3">
                <x-input-label for="finding_description" :value="__('Finding description')" />
                <x-input-textarea id="finding_description" name="finding_description" placeholder="Description of findings if any (min 15 character)." :disabled='$trafo_installed'>{{ old('finding_description', $finding->description ?? '') }}</x-input-textarea>
                <x-input-error :message="$errors->first('finding_description')" />
            </div>

            {{-- FINDING IMAGE --}}
            <div class="mb-3">
                <x-input-label for="finding_image" :value="__('Finding image')" />
                <div class="input-group">
                    <x-input-file id="finding_image" name="finding_image" :disabled='$trafo_installed' accept="image/*"></x-input-file>
                    @if( isset($finding) && $finding->image !== null)
                    <button class="btn btn-outline-secondary" type="button" id="image"><a target="_blank" class="text-reset text-decoration-none" href="/storage/findings/{{ $finding->image }}">Existing</a></button>
                    @endif
                </div>

                @if ($errors->first('finding_image'))
                <x-input-error :message="$errors->first('finding_image')" />
                @else
                <x-input-help>
                    {{ __('Maximum upload file size: 5 MB.') }}
                </x-input-help>
                @endif
            </div>

            {{-- BUTTON SUBMIT --}}
            @if ($trafo->status === 'Installed')
            <div class="mb-3">
                <x-button-primary>
                    @isset($record)
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