<x-app-layout>

    @inject('utility', 'App\Services\Utility')

    @php
    $user_email = Auth::user()->email_address ?? null;
    @endphp

    <section class="mb-4">
        <x-h3>{{ __($title) }}</x-h3>
        <table class="rounded table mb-0 border border-1 shadow-sm">
            <tbody>

                @foreach ($utility::getColumns('users', ['password', 'remember_token']) as $column)
                <tr class="table">

                    {{-- COLUMN --}}
                    <x-td class="fw-semibold">{{ $column == 'nik' ? strtoupper($column) : ucfirst(str_replace('_' , ' ', $column)) }}</x-td>


                    @switch($column)
                    @case('nik')
                    <x-td>
                        @if (Auth::user()->isAdmin())
                        {{ Auth::user()->$column }}
                        <svg class="ms-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#0d6efd" class="bi bi-patch-check-fill" viewBox="0 0 16 16" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="You're admin.">
                            <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708" />
                        </svg>
                        @else
                        {{ Auth::user()->$column }}
                        <svg class="ms-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#0d6efd" class="bi bi-patch-check" viewBox="0 0 16 16" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="You're regular user.">
                            <path fill-rule="evenodd" d="M10.354 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                            <path d="m10.273 2.513-.921-.944.715-.698.622.637.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01.622-.636a2.89 2.89 0 0 1 4.134 0l-.715.698a1.89 1.89 0 0 0-2.704 0l-.92.944-1.32-.016a1.89 1.89 0 0 0-1.911 1.912l.016 1.318-.944.921a1.89 1.89 0 0 0 0 2.704l.944.92-.016 1.32a1.89 1.89 0 0 0 1.912 1.911l1.318-.016.921.944a1.89 1.89 0 0 0 2.704 0l.92-.944 1.32.016a1.89 1.89 0 0 0 1.911-1.912l-.016-1.318.944-.921a1.89 1.89 0 0 0 0-2.704l-.944-.92.016-1.32a1.89 1.89 0 0 0-1.912-1.911z" />
                        </svg>
                        @endif
                    </x-td>
                    @break

                    @default
                    <x-td>{{ Auth::user()->$column }}</x-td>
                    @endswitch


                </tr>
                @endforeach

                @isset($user_email)
                <tr>
                    <x-td class="fw-semibold">Email reports</x-td>
                    <x-td>
                        @if (!is_null(App\Models\EmailRecipient::query()->find($user_email)) ?? false)
                        <form action="{{ route('unsubscribe') }}" method="POST">
                            @csrf
                            <input type="hidden" name="email" id="email" value="{{ $user_email }}">
                            <input type="hidden" name="name" id="name" value="{{ Auth::user()->fullname }}">
                            <x-button-danger class="py-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Unsubscribe from receiving daily report emails.">
                                <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell-slash-fill" viewBox="0 0 16 16">
                                    <path d="M5.164 14H15c-1.5-1-2-5.902-2-7q0-.396-.06-.776zm6.288-10.617A5 5 0 0 0 8.995 2.1a1 1 0 1 0-1.99 0A5 5 0 0 0 3 7c0 .898-.335 4.342-1.278 6.113zM10 15a2 2 0 1 1-4 0zm-9.375.625a.53.53 0 0 0 .75.75l14.75-14.75a.53.53 0 0 0-.75-.75z" />
                                </svg>
                                Unsubscribe
                            </x-button-danger>
                        </form>
                        @else
                        <form action="{{ route('subscribe') }}" method="POST">
                            @csrf
                            <input type="hidden" name="email" id="email" value="{{ $user_email }}">
                            <input type="hidden" name="name" id="name" value="{{ Auth::user()->fullname }}">
                            <x-button-primary class="py-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Subscribe to receive daily email reports.">
                                <svg class="me-1 mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
                                    <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901" />
                                </svg>
                                Subscribe
                            </x-button-primary>
                        </form>
                        @endif
                    </x-td>
                </tr>
                @endisset
            </tbody>
        </table>
        <x-input-error :message='$errors->first("email")' />
    </section>

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
                <x-input-select id="department" name="department" :options="$utility->getEnumValue('user', 'department')" :value="old('department', Auth::user()->department)" />
                <x-input-error :message="$errors->first('department')" />
            </div>

            {{-- EMAIL --}}
            <div class="mb-3">
                <x-input-label for="email_address" :value="__('Email')" />
                <x-input-email id="email_address" name="email_address" :value="old('email_address', Auth::user()->email_address)" />
                <x-input-error :message="$errors->first('email_address')" />
            </div>

            {{-- PHONE NUMBER --}}
            <div class="mb-3">
                <x-input-label for="phone_number" :value="__('Phone number')" />
                <x-input-number-text id="phone_number" name="phone_number" :value="old('phone_number', Auth::user()->phone_number)" maxlength="13" />
                <x-input-error :message="$errors->first('phone_number')" />
            </div>

            {{-- WORK CENTER --}}
            <div class="mb-3">
                <x-input-label for="work_center" :value="__('Work center')" />
                <x-input-text id="work_center" type="text" name="work_center" :value="old('work_center', Auth::user()->work_center)" autofocus onkeypress="return JS.toupper(event)" />
                <x-input-error :message="$errors->first('work_center')" />
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