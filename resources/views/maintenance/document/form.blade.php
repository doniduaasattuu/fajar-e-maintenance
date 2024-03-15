<x-app-layout>

    @inject('utility', 'App\Services\Utility')

    @php
    $skipped = ['id', 'uploaded_by', 'department', 'created_at', 'updated_at'];
    @endphp

    {{-- BREADCUMB --}}
    <section>
        @isset($document)
        <x-breadcumb-table :title='$title' :table="'Documents'" :table_item='$document' />
        @else
        <x-breadcumb-table :title='$title' :table="'Documents'" />
        @endisset
    </section>

    @if(session("alert"))
    <x-alert :alert='session("alert")'>
    </x-alert>
    @endisset

    {{-- ALERT HIDDEN INPUT --}}
    <x-alert-hidden :hidden='$skipped' />

    <section>
        <form action="/{{ $action }}" method="POST" enctype="multipart/form-data">
            @csrf

            @isset($document)
            <x-input-number-text type="hidden" id="id" name="id" :value='$document->id ?? ""' :disabled='!Auth::user()->isAdmin()' />
            <x-input-number-text type="hidden" id="uploaded_by" name="uploaded_by" :value='$document->uploaded_by ?? ""' :disabled='!Auth::user()->isAdmin()' />
            <x-input-number-text type="hidden" id="department" name="department" :value='$document->department ?? ""' :disabled='!Auth::user()->isAdmin()' />
            @endisset

            @foreach ($utility::getColumns('documents', $skipped) as $column)

            @switch($column)
            @case('area')
            <div class="mb-3">
                <x-input-label for="area" :value="__('Area')" />
                <x-input-list list="area_option" id="area" name="area" :value='old("area", $finding->area ?? "")' oninput="return JS.toupper(this)" maxlength="15" />
                <x-datalist :id='"area_option"' :options='$utility::areas()' />
                <x-input-error :message="$errors->first('area')" />
            </div>
            @break

            @case('attachment')
            <div class="mb-3">
                <x-input-label for="{{ $column }}" :value="__(ucfirst(str_replace('_', ' ', $column)) . ' *')" />

                <div class="input-group">
                    <x-input-file id="{{ $column }}" name="{{ $column }}" :disabled='!Auth::user()->isAdmin()' />
                    @if( isset($document) && $document->attachment !== null)
                    <button class="btn btn-outline-secondary" type="button"><a target="_blank" class="text-reset text-decoration-none" href="/storage/documents/{{ $document->attachment }}">Existing</a></button>
                    @endif
                </div>

                @if ($errors->first($column))
                <x-input-error :message="$errors->first($column)" />
                @else
                <x-input-help>
                    {{ __('Maximum upload file size: 25 MB.') }}
                </x-input-help>
                @endif

            </div>
            @break

            @default
            <div class="mb-3">
                @switch($column)
                @case('title')
                <x-input-label for="{{ $column }}" :value="__(ucfirst(str_replace('_', ' ', $column)) . ' *')" />
                @break
                @default
                <x-input-label for="{{ $column }}" :value="__(ucfirst(str_replace('_', ' ', $column)))" />
                @endswitch
                <x-input-text id="{{ $column }}" name="{{ $column }}" :value='$document->$column ?? ""' :disabled='!Auth::user()->isAdmin()' />
                <x-input-error :message="$errors->first($column)" />
            </div>
            @endswitch

            @endforeach

            @if (Auth::user()->isAdmin())
            {{-- BUTTON SUBMIT --}}
            <div class="mb-3">
                <x-button-primary>
                    @isset($document)
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