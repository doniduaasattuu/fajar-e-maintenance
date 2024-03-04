<x-app-layout>

    <div class="mb-4">
        <x-h3>{{ __($title) }}</x-h3>
        <table class="rounded table mb-0 border border-1 shadow-sm">
            <tbody>

                @foreach ($userService->getColumns('users', ['password', 'remember_token']) as $column)
                <tr class="table">

                    {{-- COLUMN --}}
                    <x-td class="fw-semibold">{{ $column == 'nik' ? strtoupper($column) : ucfirst(str_replace('_' , ' ', $column)) }}</x-td>

                    {{-- VALUE --}}
                    @if (Auth::user()->isAdmin() && $column == 'nik')
                    <x-td>
                        {{ Auth::user()->$column }}
                        <svg class="ms-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#0d6efd" class="bi bi-patch-check-fill" viewBox="0 0 16 16" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="You're admin.">
                            <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708" />
                        </svg>
                    </x-td>
                    @else
                    <x-td>{{ Auth::user()->$column }}</x-td>
                    @endif

                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    <div class="mb-4">
        <x-h3>{{ __('Update profile') }}</x-h3>

        @if(session("alert"))
        <x-alert :alert='session("alert")'></x-alert>
        @endisset

        <form action="{{ route('update-profile') }}" method="POST">
            @csrf

            {{-- NIK --}}
            <div class="mb-3">
                <x-input-label for="nik" :value="__('NIK')" />
                <x-input-text id="nik" name="nik" :value="old('nik', Auth::user()->nik)" :readonly='true' onkeypress="return JS.onlynumber(event)" maxlength="8" />
                <x-input-error :message="$errors->first('nik')" />
            </div>

            {{-- FULLNAME --}}
            <div class="mb-3">
                <x-input-label for="fullname" :value="__('Fullname')" />
                <x-input-text id="fullname" name="fullname" :value="old('fullname', Auth::user()->fullname)" />
                <x-input-error :message="$errors->first('fullname')" />
            </div>

            {{-- DEPARTMENT --}}
            <div class="mb-3">
                <x-input-label for="department" :value="__('Department')" />
                <x-input-select id="department" name="department" :options="App\Models\User::$departments" :value="old('department', Auth::user()->department)" />
                <x-input-error :message="$errors->first('department')" />
            </div>

            {{-- PHONE NUMBER --}}
            <div class="mb-3">
                <x-input-label for="phone_number" :value="__('Phone number')" />
                <x-input-text id="phone_number" name="phone_number" :value="old('phone_number', Auth::user()->phone_number)" onkeypress="return JS.onlynumber(event)" />
                <x-input-error :message="$errors->first('phone_number')" />
            </div>

            {{-- PASSWORD --}}
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
            </div>

            {{-- BUTTON --}}
            <div class="mb-3">
                <x-button-primary>
                    {{ __('Update') }}
                </x-button-primary>
            </div>

        </form>

    </div>

</x-app-layout>