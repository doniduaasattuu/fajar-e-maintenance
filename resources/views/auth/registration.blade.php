<x-guest-layout>

    @section('title', $title)

    <x-h1>{{ $title }}</x-h1>

    <form action="{{ route('registration') }}" method="POST">
        @csrf

        @if(session("alert"))
        <x-alert :alert='session("alert")'></x-alert>
        @endisset

        {{-- NIK --}}
        <div class="mb-3">
            <x-input-label for="nik" :value="__('NIK *')" />
            <x-input-text id="nik" type="text" name="nik" :value="old('nik')" autofocus autocomplete="nik" onkeypress="return JS.onlynumber(event, 48, 57)" maxlength="8" />
            <x-input-error :message="$errors->first('nik')" />
        </div>

        {{-- PASSWORD --}}
        <div class="mb-3">
            <x-input-label for="password" :value="__('Password *')" />
            <x-input-text id="password" type="password" name="password" autofocus autocomplete="password" />
            <x-input-error :message="$errors->first('password')" />
        </div>

        {{-- FULLNAME --}}
        <div class="mb-3">
            <x-input-label for="fullname" :value="__('Fullname *')" />
            <x-input-text id="fullname" type="text" name="fullname" :value="old('fullname')" autofocus autocomplete="fullname" />
            <x-input-error :message="$errors->first('fullname')" />
        </div>

        {{-- DEPARTMENT --}}
        <div class="mb-3">
            <x-input-label for="department" :value="__('Department *')" />
            <x-input-select id="department" name="department" :options="App\Models\User::$departments" :value="old('department')" :choose="'-- Choose --'" />
            <x-input-error :message="$errors->first('department')" />
        </div>

        {{-- PHONE NUMBER --}}
        <div class="mb-3">
            <x-input-label for="phone_number" :value="__('Phone number *')" />
            <x-input-text id="phone_number" type="text" name="phone_number" :value="old('phone_number')" autofocus autocomplete="phone_number" />
            <x-input-error :message="$errors->first('phone_number')" />
        </div>

        {{-- REGISTRATION CODE --}}
        <div class="mb-3">
            <x-input-label for="registration_code" :value="__('Registration code *')" />
            <x-input-text id="registration_code" type="text" name="registration_code" :value="old('registration_code')" autofocus autocomplete="registration_code" />
            <x-input-error :message="$errors->first('registration_code')" />
        </div>

        {{-- BUTTON --}}
        <div class="mb-3">
            <x-button-primary>
                {{ __('Sign Up') }}
            </x-button-primary>
            <x-input-help>
                Already have an account ?, <x-anchor :href="'/login'">{{ 'Sign in here' }}</x-anchor>
            </x-input-help>
        </div>

    </form>

</x-guest-layout>