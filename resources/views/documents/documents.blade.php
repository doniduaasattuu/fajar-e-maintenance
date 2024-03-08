<x-app-layout>

    @inject('utility', 'App\Services\Utility')

    <x-modal-confirm></x-modal-confirm>

    <section class="mb-4">
        <x-h3>{{ $title }}</x-h3>

        {{-- BUTTON NEW --}}
        <x-button-new :href='"/document-registration"'>
            {{ __('New document') }}
        </x-button-new>

        {{-- FILTERING --}}
        <div class="row mb-3">

            {{-- FILTER SEARCH --}}
            <div class="col pe-1">
                <x-input-label for="search" :value="__('Search')" />
                <x-input-text id="search" type="text" name="search" placeholder="Title" />
            </div>

            {{-- BY DEPT --}}
            <div class="col ps-1">
                <x-input-label for="dept" :value="__('Dept')" />
                <x-input-select id="dept" name="dept" :options="$utility::getEnumValue('user', 'department')" :choose="''" />
                </select>
            </div>

            <x-footer-header-table :paginator='$paginator' />
        </div>
    </section>

</x-app-layout>