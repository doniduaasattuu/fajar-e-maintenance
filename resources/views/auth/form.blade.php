<x-app-layout>

    @inject('utility', 'App\Services\Utility')

    <div class="mb-4">
        <x-breadcumb-table :title='"Update user"' :table='"Users"' :action='$user->fullname'></x-breadcumb-table>

        @if(session("alert"))
        <x-alert :alert='session("alert")'></x-alert>
        @endisset

        <form action="{{ route('update-profile') }}" method="POST">
            @csrf

            {{-- NIK --}}
            <div class="mb-3">
                <x-input-label for="nik" :value="__('NIK')" />
                <x-input-text id="nik" name="nik" :value="old('nik', $user->nik)" :readonly='true' onkeypress="return JS.onlynumber(event)" maxlength="8" />
                <x-input-error :message="$errors->first('nik')" />
            </div>

            {{-- FULLNAME --}}
            <div class="mb-3">
                <x-input-label for="fullname" :value="__('Fullname')" />
                <x-input-text id="fullname" name="fullname" :value="old('fullname', $user->fullname)" />
                <x-input-error :message="$errors->first('fullname')" />
            </div>

            {{-- DEPARTMENT --}}
            <div class="mb-3">
                <x-input-label for="department" :value="__('Department')" />
                <x-input-select id="department" name="department" :options="$utility->getEnumValue('user', 'department')" :value="old('department', $user->department)" />
                <x-input-error :message="$errors->first('department')" />
            </div>

            {{-- EMAIL --}}
            <div class="mb-3">
                <x-input-label for="email_address" :value="__('Email address')" />
                <x-input-email id="email_address" name="email_address" :value="old('email_address', $user->email_address)" />
                <x-input-error :message="$errors->first('email_address')" />
            </div>

            {{-- PHONE NUMBER --}}
            <div class="mb-3">
                <x-input-label for="phone_number" :value="__('Phone number')" />
                <x-input-number-text id="phone_number" name="phone_number" :value="old('phone_number', $user->phone_number)" maxlength="13" />
                <x-input-error :message="$errors->first('phone_number')" />
            </div>

            {{-- WORK CENTER --}}
            <div class="mb-3">
                <x-input-label for="work_center" :value="__('Work center')" />
                <x-input-text id="work_center" type="text" name="work_center" :value="old('work_center', $user->work_center)" oninput="return JS.toupper(this)" />
                <x-input-error :message="$errors->first('work_center')" />
            </div>

            <!-- {{-- PASSWORD --}}
            <div class="mb-3">
                <x-input-label for="new_password" :value="__('New password')" />
                <x-input-text id="new_password" type="password" name="new_password" />
                <x-input-error :message="$errors->first('new_password')" />
            </div>

            {{-- PASSWORD --}}
            <div class="mb-3">
                <x-input-label for="new_password_confirmation" :value="__('New password confirmation')" />
                <x-input-text id="new_password_confirmation" type="password" name="new_password_confirmation" />
                <x-input-error :message="$errors->first('new_password_confirmation')" />
            </div> -->

            {{-- BUTTON --}}
            <div class="mb-3">
                <x-button-primary>
                    {{ __('Update') }}
                </x-button-primary>
            </div>

        </form>

    </div>

</x-app-layout>