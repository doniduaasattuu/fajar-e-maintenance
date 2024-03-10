<x-app-layout>

    @inject('utility', 'App\Services\Utility')

    @php
    $skipped = ['id', 'uploaded_by', 'created_at', 'updated_at'];
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
            @endisset

            @foreach ($utility::getColumns('documents', $skipped) as $column)

            @switch($column)
            @case('area')
            <div class="mb-3">
                <x-input-label for="{{ $column }}" :value="__(ucfirst(str_replace('_', ' ', $column)) . ' *')" />
                <x-input-select id="{{ $column }}" name="{{ $column }}" :options="$utility::areas()" :value="old($column, $document->$column ?? '')" :disabled='!Auth::user()->isAdmin()' />
                <x-input-error :message="$errors->first($column)" />
            </div>
            @break

            @case('department')
            <div class="mb-3">
                <x-input-label for="{{ $column }}" :value="__(ucfirst(str_replace('_', ' ', $column)) . ' *')" />
                <x-input-select id="{{ $column }}" name="{{ $column }}" :options="$utility->getEnumValue('user', 'department')" :value="old($column, $document->$column ?? '')" :disabled='!Auth::user()->isAdmin()' />
                <x-input-error :message="$errors->first($column)" />
            </div>
            @break

            @case('attachment')
            <div class="mb-3">
                <x-input-label for="{{ $column }}" :value="__(ucfirst(str_replace('_', ' ', $column)) . ' *')" />
                <x-input-file id="{{ $column }}" name="{{ $column }}" :disabled='!Auth::user()->isAdmin()' />
                <x-input-error :message="$errors->first($column)" />
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
                <x-input-number-text id="{{ $column }}" name="{{ $column }}" :value='$document->$column ?? ""' :disabled='!Auth::user()->isAdmin()' />
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