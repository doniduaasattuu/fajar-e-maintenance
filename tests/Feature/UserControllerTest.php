<?php

namespace Tests\Feature;

use App\Services\UserService;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testGetRegistration()
    {
        $this->get('/registration')
            ->assertStatus(200)
            ->assertSeeText('Registration')
            ->assertSeeText('NIK')
            ->assertSeeText('Password')
            ->assertSeeText('Full name')
            ->assertSeeText('Department')
            ->assertSeeText('EI1')
            ->assertSeeText('EI2')
            ->assertSeeText('EI3')
            ->assertSeeText('EI4')
            ->assertSeeText('EI5')
            ->assertSeeText('EI6')
            ->assertSeeText('EI7')
            ->assertSeeText('Phone number')
            ->assertSeeText('Registration code')
            ->assertSeeText('Sign Up')
            ->assertSeeText('Already have an account ?, Sign in here');
    }

    public function testGetRegistrationRedirect()
    {
        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/registration')
            ->assertStatus(302)
            ->assertRedirect('/');
    }

    public function testRegistrationSuccess()
    {
        $data = [
            'nik' => '55000154',
            'password' => 'Rahasia@1234',
            'fullname' => 'dOnI dArMawAN',
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'registration_code' => env('REGISTRATION_CODE'),
        ];

        $this->post('/registration', $data)
            ->assertStatus(302)
            ->assertRedirect('/login');

        $userService = $this->app->make(UserService::class);
        $user = $userService->user($data['nik']);

        self::assertEquals('Doni Darmawan', $user->fullname);
    }

    public function testRegistrationEmpty()
    {
        $data = [
            'nik' => '',
            'password' => '',
            'fullname' => '',
            'department' => '',
            'phone_number' => '',
            'registration_code' => '',
        ];

        $this->post('/registration', $data)
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'nik' => 'The nik field is required.',
                'password' => 'The password field is required.',
                'fullname' => 'The fullname field is required.',
                'department' => 'The department field is required.',
                'phone_number' => 'The phone number field is required.',
                'registration_code' => 'The registration code field is required.',
            ]);
    }

    public function testRegistrationNikDuplicate()
    {
        $this->seed(UserSeeder::class);

        $data = [
            'nik' => '55000154',
            'password' => '44',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'registration_code' => 'Ada',
        ];

        $this->post('/registration', $data)
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'nik' => 'The user 55000154 is already registered.',
            ]);
    }

    public function testRegistrationNikInvalidDigit()
    {
        $data = [
            'nik' => '5500154',
            'password' => '44',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'registration_code' => 'Ada',
        ];

        $this->post('/registration', $data)
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'nik' => 'The nik field must be 8 digits.',
            ]);
    }

    public function testRegistrationNikInvalidNumeric()
    {
        $data = [
            'nik' => 'abcdefgh',
            'password' => '44',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'registration_code' => 'Ada',
        ];

        $this->post('/registration', $data)
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'nik' => 'The nik field must be 8 digits.',
                'nik' => 'The nik field must be a number.',
            ]);
    }

    public function testRegistrationPasswordInvalidLengthMin()
    {
        $data = [
            'nik' => '55000154',
            'password' => '@Rhs123',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'registration_code' => 'Ada',
        ];

        $this->post('/registration', $data)
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'password' => 'The password field must be at least 8 characters.',
            ]);
    }

    public function testRegistrationPasswordInvalidLengthMax()
    {
        $data = [
            'nik' => '55000154',
            'password' => '@SangatRahasiaSekaliBahkanSampaiLupa12345',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'registration_code' => 'Ada',
        ];

        $this->post('/registration', $data)
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'password' => 'The password field must not be greater than 25 characters.',
            ]);
    }

    public function testRegistrationPasswordInvalidLetters()
    {
        $data = [
            'nik' => '55000154',
            'password' => '@12345678',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'registration_code' => 'Ada',
        ];

        $this->post('/registration', $data)
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'password' => 'The password field must contain at least one letter.',
            ]);
    }

    public function testRegistrationPasswordInvalidMixedCase()
    {
        $data = [
            'nik' => '55000154',
            'password' => '@RHS12345',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'registration_code' => 'Ada',
        ];

        $this->post('/registration', $data)
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'password' => 'The password field must contain at least one uppercase and one lowercase letter.',
            ]);
    }

    public function testRegistrationPasswordInvalidSymbols()
    {
        $data = [
            'nik' => '55000154',
            'password' => 'Rhs1234yyy',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'registration_code' => 'Ada',
        ];

        $this->post('/registration', $data)
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'password' => 'The password field must contain at least one symbol.',
            ]);
    }

    public function testRegistrationFullnameInvalidMinLength()
    {
        $data = [
            'nik' => '55000154',
            'password' => 'Rahasia@1234',
            'fullname' => 'Doni',
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'registration_code' => 'Ada',
        ];

        $this->post('/registration', $data)
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'fullname' => 'The fullname field must be at least 6 characters.',
            ]);
    }

    public function testRegistrationFullnameInvalidMaxLength()
    {
        $data = [
            'nik' => '55000154',
            'password' => 'Rahasia@1234',
            'fullname' => 'Doni Darmawan Wibisono Pratama Pangestu Bumi Damara Putra Tan Malaka',
            'department' => 'EI4',
            'phone_number' => '08983456945',
            'registration_code' => 'Ada',
        ];

        $this->post('/registration', $data)
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'fullname' => 'The fullname field must not be greater than 50 characters.',
            ]);
    }

    public function testRegistrationFullnameInvalid()
    {
        $data = [
            'nik' => '55000154',
            'password' => 'Rahasia@1234',
            'fullname' => 'Doni_Darmawan',
            'department' => 'EI4',
            'phone_number' => '08983456945',
            'registration_code' => 'RG9uaSBEYXJtYXdhbg==',
        ];

        $this->post('/registration', $data)
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'fullname' => 'The fullname field format is invalid.',
            ]);
    }

    public function testRegistrationFullnameValid()
    {
        $data = [
            'nik' => '55000154',
            'password' => 'Rahasia@1234',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI4',
            'phone_number' => '08983456945',
            'registration_code' => 'RG9uaSBEYXJtYXdhbg==',
        ];

        $this->post('/registration', $data)
            ->assertStatus(302)
            ->assertSessionHasNoErrors([
                'fullname' => 'The fullname field format is invalid.',
            ]);
    }

    public function testRegistrationFullnameInvalidFormat()
    {
        $data = [
            'nik' => '55000154',
            'password' => 'Rahasia@1234',
            'fullname' => 'Doni-Darmawan',
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'registration_code' => 'Ada',
        ];

        $this->post('/registration', $data)
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'fullname' => 'The fullname field format is invalid.',
            ]);
    }

    public function testRegistrationDepartmentInvalid()
    {
        $data = [
            'nik' => '55000154',
            'password' => '44',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI11',
            'phone_number' => '08983456945',
            'registration_code' => env('REGISTRATION_CODE'),
        ];

        $this->post('/registration', $data)
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'department' => 'The selected department is invalid.',
            ]);
    }

    public function testRegistrationPhoneNumberInvalidNumeric()
    {
        $data = [
            'nik' => '55000154',
            'password' => '44',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI11',
            'phone_number' => 'abcdefgh',
            'registration_code' => env('REGISTRATION_CODE'),
        ];

        $this->post('/registration', $data)
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'phone_number' => 'The phone number field must be a number.',
            ]);
    }

    public function testRegistrationPhoneNumberInvalidLength()
    {
        $data = [
            'nik' => '55000154',
            'password' => '44',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI11',
            'phone_number' => '123456789',
            'registration_code' => env('REGISTRATION_CODE'),
        ];

        $this->post('/registration', $data)
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'phone_number' => 'The phone number field must be between 10 and 13 digits.',
            ]);
    }

    public function testGetLogin()
    {
        $this->get('/login')
            ->assertSeeText('Login')
            ->assertSeeText('NIK')
            ->assertSeeText('Password')
            ->assertSeeText('Sign In')
            ->assertSeeText("Don't have an account ?");
    }

    public function testGetLoginRedirect()
    {
        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/login')
            ->assertStatus(302)
            ->assertRedirect('/');
    }

    public function testLoginSuccess()
    {
        $this->seed(UserSeeder::class);

        $this->post('/login', [
            'nik' => '55000154',
            'password' => '@Fajarpaper123'
        ])
            ->assertStatus(302)
            ->assertRedirect('/');
    }

    public function testLoginEmpty()
    {
        $this->seed(UserSeeder::class);

        $this->post('/login', [
            'nik' => '',
            'password' => ''
        ])
            ->assertSessionHasErrors([
                'nik' => 'The nik field is required.',
                'password' => 'The password field is required.'
            ]);
    }

    public function testLoginUnregisteredNik()
    {
        $this->seed(UserSeeder::class);

        $this->post('/login', [
            'nik' => '55000123',
            'password' => 'Rahasia@1234'
        ])
            ->assertSessionHasErrors([
                'nik' => 'The nik or password is wrong.',
            ]);
    }

    public function testLoginWrongNik()
    {
        $this->seed(UserSeeder::class);

        $this->post('/login', [
            'nik' => '55000123',
            'password' => '@Fajarpaper123'
        ])
            ->assertSessionHasErrors([
                'nik' => 'The nik or password is wrong.',
            ]);
    }

    public function testLoginWrongPassword()
    {
        $this->seed(UserSeeder::class);

        $this->post('/login', [
            'nik' => '55000154',
            'password' => 'Rahasia@1234'
        ])
            ->assertSessionHasErrors([
                'nik' => 'The nik or password is wrong.',
            ]);
    }

    public function testLoginInvalidNik()
    {
        $this->seed(UserSeeder::class);

        $this->post('/login', [
            'nik' => 'abcdefgh',
            'password' => 'Rahasia@1234'
        ])
            ->assertSessionHasErrors([
                'nik' => 'The nik field must be a number.',
            ]);
    }

    public function testGetProfile()
    {
        $this->seed(UserSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan',
        ])
            ->get('/profile')
            ->assertSeeText('My profile')
            ->assertSeeText('Phone number')
            ->assertSeeText('08983456945')
            ->assertDontSeeText('Password')
            ->assertSeeText('Doni Darmawan')
            ->assertSeeText('Update profile')
            ->assertSeeText('New password')
            ->assertSeeText('New password confirmation')
            ->assertSeeText('Submit');
    }

    public function testUpdateProfileSuccess()
    {
        $this->testGetProfile();

        $this
            ->followingRedirects()->post('/update-profile', [
                'nik' => '55000154',
                'fullname' => 'Doni Darmawan',
                'department' => 'EI2',
                'phone_number' => '08983456945',
                'phone_number' => '08983456945',
                'new_password' => 'Rahasia@1234',
                'new_password_confirmation' => 'Rahasia@1234',
            ])
            ->assertSeeText('Your profile successfully updated.');
    }

    public function testUpdateProfileNikChanged()
    {
        $this->testGetProfile();

        $this
            ->followingRedirects()->post('/update-profile', [
                'nik' => '55000153',
                'fullname' => 'Jamal Mirdad',
                'department' => 'EI6',
                'phone_number' => '08983456945',
                'new_password' => 'Rahasia@1234',
                'new_password_confirmation' => 'Rahasia@1234',
            ])
            ->assertSeeText('The selected nik is invalid.');
    }

    public function testUpdateProfileDepartmentInvalid()
    {
        $this->testGetProfile();

        $this
            ->followingRedirects()->post('/update-profile', [
                'nik' => '55000154',
                'fullname' => 'Doni Darmawan',
                'department' => 'EI9',
                'phone_number' => '08983456945',
                'new_password' => 'Rahasia@1234',
                'new_password_confirmation' => 'Rahasia@1234',
            ])
            ->assertSeeText('The selected department is invalid.');
    }

    public function testUpdateProfilePhoneNumberInvalidMin()
    {
        $this->testGetProfile();

        $this
            ->followingRedirects()->post('/update-profile', [
                'nik' => '55000154',
                'fullname' => 'Doni Darmawan',
                'department' => 'EI9',
                'phone_number' => '0898',
                'new_password' => 'Rahasia@1234',
                'new_password_confirmation' => 'Rahasia@1234',
            ])
            ->assertSeeText('The phone number field must be between 10 and 13 digits.');
    }

    public function testUpdateProfilePhoneNumberInvalidMax()
    {
        $this->testGetProfile();

        $this
            ->followingRedirects()->post('/update-profile', [
                'nik' => '55000154',
                'fullname' => 'Doni Darmawan',
                'department' => 'EI9',
                'phone_number' => '08983456945081',
                'new_password' => 'Rahasia@1234',
                'new_password_confirmation' => 'Rahasia@1234',
            ])
            ->assertSeeText('The phone number field must be between 10 and 13 digits.');
    }

    public function testUpdateProfilePhoneNumberInvalidType()
    {
        $this->testGetProfile();

        $this
            ->followingRedirects()->post('/update-profile', [
                'nik' => '55000154',
                'fullname' => 'Doni Darmawan',
                'department' => 'EI9',
                'phone_number' => '+628983456945',
                'new_password' => 'Rahasia@1234',
                'new_password_confirmation' => 'Rahasia@1234',
            ])
            ->assertSeeText('The phone number field must be between 10 and 13 digits.');
    }

    public function testUpdateProfilePasswordMissing()
    {
        $this->testGetProfile();

        $this
            ->followingRedirects()->post('/update-profile', [
                'nik' => '55000154',
                'fullname' => 'Doni Darmawan',
                'department' => 'EI2',
                'phone_number' => '08983456945',
                'new_password' => '',
                'new_password_confirmation' => '',
            ])
            ->assertSeeText('The new password field is required.')
            ->assertSeeText('The new password confirmation field is required.');
    }

    public function testUpdateProfilePasswordMissmatching()
    {
        $this->testGetProfile();

        $this
            ->followingRedirects()->post('/update-profile', [
                'nik' => '55000154',
                'fullname' => 'Doni Darmawan',
                'department' => 'EI2',
                'phone_number' => '08983456945',
                'new_password' => 'Rahasia@1234',
                'new_password_confirmation' => 'Rahasia@12345',
            ])
            ->assertSeeText('The new password confirmation field must match new password.');
    }
}
