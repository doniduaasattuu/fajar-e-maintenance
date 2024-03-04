<x-guest-layout>

    @section('title', $title)

    <x-h1>{{ $title }}</x-h1>

    <form action="{{ route('login') }}" method="POST">
        @csrf

        @if(session("alert"))
        <x-alert :alert='session("alert")'>
        </x-alert>
        @endisset

        {{-- NIK --}}
        <div class="mb-3">
            <x-input-label for="nik" :value="__('NIK')" />
            <x-input-text id="nik" type="text" name="nik" :value="old('nik')" autofocus autocomplete="nik" onkeypress="return JS.onlynumber(event, 48, 57)" maxlength="8" />
            <x-input-error :message="$errors->first('nik')" />
        </div>

        {{-- PASSWORD --}}
        <div class="mb-3">
            <x-input-label for="password" :value="__('Password')" />
            <x-input-text id="password" type="password" name="password" autofocus autocomplete="password" />
        </div>

        {{-- BUTTON --}}
        <div class="mb-3">
            <x-button-primary>
                {{ __('Sign In') }}
            </x-button-primary>
            <x-input-help>
                Don't have an account ?, <x-anchor :href="'/registration'">{{ __('Register here') }}</x-anchor>
            </x-input-help>
        </div>

    </form>

</x-guest-layout>