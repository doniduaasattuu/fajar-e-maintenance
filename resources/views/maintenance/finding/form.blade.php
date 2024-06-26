<x-app-layout>

    @inject('utility', 'App\Services\Utility')

    {{-- BREADCUMB --}}
    <section>
        @isset($finding)
        <x-breadcumb-table :title='$title' :table="'Findings'" :table_item='$finding' />
        @else
        <x-breadcumb-table :title='$title' :table="'Findings'" />
        @endisset
    </section>

    @if(session("alert"))
    <x-alert :alert='session("alert")'>
    </x-alert>
    @endisset

    {{-- ALERT HIDDEN INPUT --}}
    <x-alert-hidden :hidden='["id", "reporter", "department"]' />

    {{-- FORM --}}
    <section>
        <form action="/{{ $action }}" id="forms" method="POST" enctype="multipart/form-data">
            @csrf

            @isset($finding)
            <input type="hidden" id="id" name="id" value="{{ $finding->id ?? '' }}">
            <input type="hidden" id="reporter" name="reporter" value="{{ $finding->reporter ?? '' }}">
            @endisset

            {{-- AREA --}}
            <div class="mb-3">
                <x-input-label for="area" :value="__('Area')" />
                <x-input-list list="area_option" id="area" name="area" :value='old("area", $finding->area ?? "")' oninput="return JS.toupper(this)" maxlength="15" />
                <x-datalist :id='"area_option"' :options='$utility::areas()' />
                <x-input-error :message="$errors->first('area')" />
            </div>

            {{-- DEPARTMENT --}}
            @if (Auth::user()->isSuperAdmin())
            <div class="mb-3">
                <x-input-label for="department" :value="__('Department *')" />
                <x-input-select id="department" name="department" :options="$utility->getEnumValue('user', 'department')" :value='old("department", $finding->department ?? Auth::user()->department ?? "")' />
                <x-input-error :message="$errors->first('department')" />
            </div>
            @else
            <input type="hidden" id="department" name="department" value="{{ $finding->department ?? Auth::user()->department ?? '' }}">
            @endif

            {{-- STATUS --}}
            <div class="mb-3">
                <x-input-label for="status" :value="__('Status *')" />
                <x-input-select id="status" name="status" :options="['Open', 'Closed']" :value='old("status", $finding->status ?? "")' />
                <x-input-error :message="$errors->first('status')" />
            </div>

            {{-- SORT FIELD --}}
            <div class="mb-3">
                <x-input-label for="sort_field" :value="__('Sort field')" />
                <x-input-text id="sort_field" name="sort_field" :value='old("sort_field", $finding->sort_field ?? "")' oninput="return JS.toupper(this)" />
                <x-input-error :message="$errors->first('sort_field')" />
            </div>

            {{-- EQUIPMENT --}}
            <div class="mb-3">
                <x-input-label for="equipment" :value="__('Equipment')" />
                <x-input-text id="equipment" name="equipment" :value='old("equipment", $finding->equipment ?? "")' oninput="return JS.toupper(this)" />
                <x-input-error :message="$errors->first('equipment')" />
            </div>

            {{-- FUNCLOC --}}
            <div class="mb-3">
                <x-input-label for="funcloc" :value="__('Funcloc')" />
                <x-input-text id="funcloc" name="funcloc" :value='old("funcloc", $finding->funcloc ?? "")' oninput="return JS.toupper(this)" />
                <x-input-error :message="$errors->first('funcloc')" />
            </div>

            {{-- NOTIFICATION --}}
            <div class="mb-3">
                <x-input-label for="notification" :value="__('Notification')" />
                <x-input-number-text id="notification" name="notification" maxlength="8" :value='old("notification", $finding->notification ?? "")' />
                <x-input-error :message="$errors->first('notification')" />
            </div>

            {{-- DESCRIPTION --}}
            <div class="mb-3">
                <x-input-label for="description" :value="__('Description *')" />
                <x-input-textarea id="description" name="description" placeholder="Minimal 15 characters">{{ old('description', $finding->description ?? '') }}</x-input-textarea>
                <x-input-error :message="$errors->first('description')" />
            </div>

            {{-- IMAGE --}}
            <div class="mb-3">
                <x-input-label for="image" :value="__('Image')" />
                <div class="input-group">
                    <x-input-file id="image" name="image" accept="image/*" />
                    @if( isset($finding) && $finding->image !== null)
                    <button class="btn btn-outline-secondary" type="button" id="image"><a target="_blank" class="text-reset text-decoration-none" href="/storage/findings/{{ $finding->image }}">Existing</a></button>
                    @endif
                </div>

                @if ($errors->first('image'))
                <x-input-error :message="$errors->first('image')" />
                @else
                <x-input-help>
                    {{ __('Maximum upload file size: 5 MB.') }}
                </x-input-help>
                @endif
            </div>

            {{-- BUTTON SUBMIT --}}
            <div class="mb-3">
                <x-button-primary>
                    @isset($finding)
                    {{ __('Save changes') }}
                    @else
                    {{ __('Submit') }}
                    @endisset
                </x-button-primary>
            </div>

        </form>
    </section>

</x-app-layout>