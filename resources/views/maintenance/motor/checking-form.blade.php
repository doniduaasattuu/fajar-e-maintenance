<x-app-layout>

    @php
    $motor_installed = ($motor->status != 'Installed');
    $power_rate = $motorDetail->power_rate ?? 45;
    @endphp

    {{-- HEADER --}}
    <section>
        {{-- CHECKING FORM HEADER --}}
        <x-checking-form.header :equipment='$motor' :record='isset($record)'>
        </x-checking-form.header>

        {{-- TREND --}}
        <x-checking-form.button-trend :equipment='$motor'>
        </x-checking-form.button-trend>

        {{-- EQUIPMENT DETAIL --}}
        @isset($motorDetail)
        <x-checking-form.equipment-detail :equipmentDetail='$motorDetail' :table='"motor_details"' :skipped='["id", "motor_detail"]'>
            {{ __('MOTOR DETAIL') }}
        </x-checking-form.equipment-detail>
        @endisset
    </section>

    @if(session("alert"))
    <x-alert :alert='session("alert")'>
    </x-alert>
    @endisset

    {{-- ALERT HIDDEN INPUT --}}
    <x-alert-hidden :hidden='["funcloc", "motor", "sort_field", "nik"]' />

    {{-- FORM --}}
    <section>
        <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
            @csrf

            @isset($record)
            <input type="hidden" id="id" name="id" value="{{ $record->id }}">
            @endisset
            <input type="hidden" id="funcloc" name="funcloc" value="{{ $motor->funcloc ?? $record->funcloc ?? '' }}">
            <input type="hidden" id="motor" name="motor" value="{{ $motor->id ?? $record->motor ?? '' }}">
            <input type="hidden" id="sort_field" name="sort_field" value="{{ $motor->sort_field ?? $record->sort_field ?? '' }}">
            <input type="hidden" id="nik" name="nik" value="{{ Auth::user()->nik }}">

            {{-- MOTOR STATUS --}}
            <div class="mb-3">
                <x-input-label for="motor_status" :value="__('Motor status *')" />
                <x-input-select id="motor_status" name="motor_status" :options='["Running", "Not Running"]' :value="old('motor_status', $record->motor_status ?? '')" :disabled='$motor_installed' />
                <x-input-error :message="$errors->first('motor_status')" />
            </div>

            {{-- CLEANLINESS --}}
            <div class="mb-3">
                <x-input-label for="cleanliness" :value="__('Cleanliness *')" />
                <x-input-select id="cleanliness" name="cleanliness" :options='["Clean", "Dirty"]' :value="old('cleanliness', $record->cleanliness ?? '')" :disabled='$motor_installed' />
                <x-input-error :message="$errors->first('cleanliness')" />
            </div>

            {{-- NIPPLE GREASE --}}
            <div class="mb-3">
                <x-input-label for="nipple_grease" :value="__('Nipple grease *')" />
                <x-input-select id="nipple_grease" name="nipple_grease" :options='["Available", "Not Available"]' :value="old('nipple_grease', $record->nipple_grease ?? '')" :disabled='$motor_installed' />
                <x-input-error :message="$errors->first('nipple_grease')" />
            </div>

            {{-- NUMBER OF GREASING --}}
            <div class="mb-3">
                <x-input-label for="number_of_greasing" :value="__('Number of greasing')" />
                <x-input-number id="number_of_greasing" name="number_of_greasing" :value="old('number_of_greasing', $record->number_of_greasing ?? '')" :disabled='$motor_installed' />
                <x-input-error :message="$errors->first('number_of_greasing')" />
            </div>

            {{-- IMAGE HELPER TEMPERATURE --}}
            <div class="mb-3">
                <x-checking-form.image.motor-temperature>
                </x-checking-form.image.motor-temperature>
            </div>

            {{-- TEMPERATURE DE --}}
            <div class="mb-3">
                <x-input-label for="temperature_de" :value="__('Temperature DE')" />
                <x-input-number-coma id="temperature_de" name="temperature_de" :value="old('temperature_de', $record->temperature_de ?? '')" :disabled='$motor_installed' oninput="return JS.preventmaxtemperature(this.id)" />
                <x-input-error :message="$errors->first('temperature_de')" />
            </div>

            {{-- TEMPERATURE BODY --}}
            <div class="mb-3">
                <x-input-label for="temperature_body" :value="__('Temperature Body')" />
                <x-input-number-coma id="temperature_body" name="temperature_body" :value="old('temperature_body', $record->temperature_body ?? '')" :disabled='$motor_installed' oninput="return JS.preventmaxtemperature(this.id)" />
                <x-input-error :message="$errors->first('temperature_body')" />
            </div>

            {{-- TEMPERATURE NDE --}}
            <div class="mb-3">
                <x-input-label for="temperature_nde" :value="__('Temperature NDE')" />
                <x-input-number-coma id="temperature_nde" name="temperature_nde" :value="old('temperature_nde', $record->temperature_nde ?? '')" :disabled='$motor_installed' oninput="return JS.preventmaxtemperature(this.id)" />
                <x-input-error :message="$errors->first('temperature_nde')" />
            </div>

            {{-- IMAGE HELPER VIBRATION --}}
            <div class="mb-3">
                <x-checking-form.image.motor-vibration>
                </x-checking-form.image.motor-vibration>
            </div>

            {{-- VIBRATION DE VERTICAL --}}
            <div class="mb-3">
                <x-input-label for="vibration_de_vertical_value" :value="__('Vibration DEV')" />
                <x-input-number-coma id="vibration_de_vertical_value" name="vibration_de_vertical_value" :value="old('vibration_de_vertical_value', $record->vibration_de_vertical_value ?? '')" :disabled='$motor_installed' power_rate="{{ $power_rate }}" oninput="JS.preventmaxvibration(this.id); JS.changeVibrationDescriptionColor(this.id)" />
                <x-input-vibration-level id='vibration_de_vertical_desc' name='vibration_de_vertical_desc' :value="old('vibration_de_vertical_desc', $record->vibration_de_vertical_desc ?? '')" :disabled='$motor_installed' :readonly='true' />
                <x-input-error :message="$errors->first('vibration_de_vertical_value')" />
                <x-input-error :message="$errors->first('vibration_de_vertical_desc')" />
            </div>

            {{-- VIBRATION DE HORIZONTAL --}}
            <div class="mb-3">
                <x-input-label for="vibration_de_horizontal_value" :value="__('Vibration DEH')" />
                <x-input-number-coma id="vibration_de_horizontal_value" name="vibration_de_horizontal_value" :value="old('vibration_de_horizontal_value', $record->vibration_de_horizontal_value ?? '')" :disabled='$motor_installed' power_rate="{{ $power_rate }}" oninput="JS.preventmaxvibration(this.id); JS.changeVibrationDescriptionColor(this.id)" />
                <x-input-vibration-level id='vibration_de_horizontal_desc' name='vibration_de_horizontal_desc' :value="old('vibration_de_horizontal_desc', $record->vibration_de_horizontal_desc ?? '')" :disabled='$motor_installed' :readonly='true' />
                <x-input-error :message="$errors->first('vibration_de_horizontal_value')" />
                <x-input-error :message="$errors->first('vibration_de_horizontal_desc')" />
            </div>

            {{-- VIBRATION DE AXIAL --}}
            <div class="mb-3">
                <x-input-label for="vibration_de_axial_value" :value="__('Vibration DEA')" />
                <x-input-number-coma id="vibration_de_axial_value" name="vibration_de_axial_value" :value="old('vibration_de_axial_value', $record->vibration_de_axial_value ?? '')" :disabled='$motor_installed' power_rate="{{ $power_rate }}" oninput="JS.preventmaxvibration(this.id); JS.changeVibrationDescriptionColor(this.id)" />
                <x-input-vibration-level id='vibration_de_axial_desc' name='vibration_de_axial_desc' :value="old('vibration_de_axial_desc', $record->vibration_de_axial_desc ?? '')" :disabled='$motor_installed' :readonly='true' />
                <x-input-error :message="$errors->first('vibration_de_axial_value')" />
                <x-input-error :message="$errors->first('vibration_de_axial_desc')" />
            </div>

            {{-- VIBRATION DE FRAME --}}
            <div class="mb-3">
                <x-input-label for="vibration_de_frame_value" :value="__('Vibration DE Frame')" />
                <x-input-number-coma id="vibration_de_frame_value" name="vibration_de_frame_value" :value="old('vibration_de_frame_value', $record->vibration_de_frame_value ?? '')" :disabled='$motor_installed' power_rate="{{ $power_rate }}" oninput="JS.preventmaxvibration(this.id); JS.changeVibrationDescriptionColor(this.id)" />
                <x-input-vibration-level id='vibration_de_frame_desc' name='vibration_de_frame_desc' :value="old('vibration_de_frame_desc', $record->vibration_de_frame_desc ?? '')" :disabled='$motor_installed' :readonly='true' />
                <x-input-error :message="$errors->first('vibration_de_frame_value')" />
                <x-input-error :message="$errors->first('vibration_de_frame_desc')" />
            </div>

            {{-- NOISE DE --}}
            <div class="mb-3">
                <x-input-label for="noise_de" :value="__('Noise DE *')" />
                <x-input-select id="noise_de" name="noise_de" :options='["Normal", "Abnormal"]' :value="old('noise_de', $record->noise_de ?? '')" :disabled='$motor_installed' />
                <x-input-error :message="$errors->first('noise_de')" />
            </div>

            <hr>

            {{-- VIBRATION NDE VERTICAL --}}
            <div class="mb-3">
                <x-input-label for="vibration_nde_vertical_value" :value="__('Vibration NDEV')" />
                <x-input-number-coma id="vibration_nde_vertical_value" name="vibration_nde_vertical_value" :value="old('vibration_nde_vertical_value', $record->vibration_nde_vertical_value ?? '')" :disabled='$motor_installed' power_rate="{{ $power_rate }}" oninput="JS.preventmaxvibration(this.id); JS.changeVibrationDescriptionColor(this.id)" />
                <x-input-vibration-level id='vibration_nde_vertical_desc' name='vibration_nde_vertical_desc' :value="old('vibration_nde_vertical_desc', $record->vibration_nde_vertical_desc ?? '')" :disabled='$motor_installed' :readonly='true' />
                <x-input-error :message="$errors->first('vibration_nde_vertical_value')" />
                <x-input-error :message="$errors->first('vibration_nde_vertical_desc')" />
            </div>

            {{-- VIBRATION NDE HORIZONTAL --}}
            <div class="mb-3">
                <x-input-label for="vibration_nde_horizontal_value" :value="__('Vibration NDEH')" />
                <x-input-number-coma id="vibration_nde_horizontal_value" name="vibration_nde_horizontal_value" :value="old('vibration_nde_horizontal_value', $record->vibration_nde_horizontal_value ?? '')" :disabled='$motor_installed' power_rate="{{ $power_rate }}" oninput="JS.preventmaxvibration(this.id); JS.changeVibrationDescriptionColor(this.id)" />
                <x-input-vibration-level id='vibration_nde_horizontal_desc' name='vibration_nde_horizontal_desc' :value="old('vibration_nde_horizontal_desc', $record->vibration_nde_horizontal_desc ?? '')" :disabled='$motor_installed' :readonly='true' />
                <x-input-error :message="$errors->first('vibration_nde_horizontal_value')" />
                <x-input-error :message="$errors->first('vibration_nde_horizontal_desc')" />
            </div>

            {{-- VIBRATION NDE FRAME --}}
            <div class="mb-3">
                <x-input-label for="vibration_nde_frame_value" :value="__('Vibration NDE Frame')" />
                <x-input-number-coma id="vibration_nde_frame_value" name="vibration_nde_frame_value" :value="old('vibration_nde_frame_value', $record->vibration_nde_frame_value ?? '')" :disabled='$motor_installed' power_rate="{{ $power_rate }}" oninput="JS.preventmaxvibration(this.id); JS.changeVibrationDescriptionColor(this.id)" />
                <x-input-vibration-level id='vibration_nde_frame_desc' name='vibration_nde_frame_desc' :value="old('vibration_nde_frame_desc', $record->vibration_nde_frame_desc ?? '')" :disabled='$motor_installed' :readonly='true' />
                <x-input-error :message="$errors->first('vibration_nde_frame_value')" />
                <x-input-error :message="$errors->first('vibration_nde_frame_desc')" />
            </div>

            {{-- NOISE NDE --}}
            <div class="mb-3">
                <x-input-label for="noise_nde" :value="__('Noise NDE *')" />
                <x-input-select id="noise_nde" name="noise_nde" :options='["Normal", "Abnormal"]' :value="old('noise_nde', $record->noise_nde ?? '')" :disabled='$motor_installed' />
                <x-input-error :message="$errors->first('noise_nde')" />
            </div>

            {{-- FINDING DESCRIPTION --}}
            <div class="mb-3">
                <x-input-label for="finding_description" :value="__('Finding description')" />
                <x-input-textarea id="finding_description" name="finding_description" placeholder="Description of findings if any (min 15 character)." :disabled='$motor_installed'>{{ old('finding_description', $finding->description ?? '') }}</x-input-textarea>
                <x-input-error :message="$errors->first('finding_description')" />
            </div>

            {{-- FINDING IMAGE --}}
            <div class="mb-3">
                <x-input-label for="finding_image" :value="__('Finding image')" />
                <div class="input-group">
                    <x-input-file id="finding_image" name="finding_image" :disabled='$motor_installed' accept="image/*"></x-input-file>
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
            @if ($motor->status === 'Installed')
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

    <script type="module">
        function doChangeColorDescriptionOnload(...ids) {
            for (let id of ids) {
                JS.changeVibrationDescriptionColor(id)
            }
        }

        window.onload = () => {
            doChangeColorDescriptionOnload(
                'vibration_de_vertical_value',
                'vibration_de_horizontal_value',
                'vibration_de_axial_value',
                'vibration_de_frame_value',
                'vibration_nde_vertical_value',
                'vibration_nde_horizontal_value',
                'vibration_nde_frame_value'
            );
        }
    </script>

</x-app-layout>