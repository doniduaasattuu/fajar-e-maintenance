<x-app-layout>

    <div class="my-4 py-5 position-absolute top-50 start-50 translate-middle" style="min-width: 300px;">

        <x-h2>{{ __($title) }}</x-h2>

        <form action="/trends" method="POST">
            @csrf

            {{-- EQUIPMENT --}}
            <div class="mb-3">
                <x-input-label for="equipment" :value="__('Equipment')" />
                <x-input-text id="equipment" type="text" name="equipment" :value="old('equipment')" autofocus autocomplete="equipment" maxlength="9" oninput="return JS.toupper(this)" />
                <x-input-error :message="$errors->first('equipment')" />
            </div>

            {{-- START DATE --}}
            <div class="mb-3">
                <x-input-label for="start_date" :value="__('Start date')" />
                <x-input-date id="start_date" name="start_date" :value="old('start_date')" />
                @if ($errors->get('start_date'))
                <x-input-error :message="$errors->first('start_date')" />
                @else
                <x-input-help>
                    {{ __('The default date is one year from today.') }}
                </x-input-help>
                @endif
            </div>

            {{-- END DATE --}}
            <div class="mb-3">
                <x-input-label for="end_date" :value="__('End date')" />
                <x-input-date id="end_date" name="end_date" :value="old('end_date')" />
                @if ($errors->get('end_date'))
                <x-input-error :message="$errors->first('end_date')" />
                @else
                <x-input-help>
                    {{ __('The default date is tomorrow.') }}
                </x-input-help>
                @endif
            </div>

            {{-- SHOW AS PDF CHECK --}}
            <div class="form-check mb-3">
                <input name="generate_pdf" class="form-check-input" type="checkbox" value=true id="flexCheckChecked">
                <label class="form-check-label w-100" for="flexCheckChecked">
                    Show as PDF File
                </label>
            </div>

            {{-- BUTTON SUBMIT --}}
            <div class="mb-3">
                <x-button-primary>
                    {{ __('Submit') }}
                </x-button-primary>
            </div>

        </form>
    </div>

</x-app-layout>