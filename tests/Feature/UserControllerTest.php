<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\EmailRecipientSeeder;
use Database\Seeders\UserRoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testGetRegistrationGuest()
    {
        $this->get('/registration')
            ->assertStatus(200)
            ->assertSeeText('Registration')
            ->assertSeeText('NIK')
            ->assertSeeText('Password')
            ->assertSeeText('Fullname')
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
            ->assertSeeText('Already have an account ?,')
            ->assertSeeText('Sign in here');
    }

    public function testGetRegistrationUser()
    {
        $this->seed(UserSeeder::class);

        $user = Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        self::assertTrue($user);

        $this
            ->get('/registration')
            ->assertStatus(302)
            ->assertRedirectToRoute('home');
    }

    public function testRegistrationSuccess()
    {
        $data = [
            'nik' => '55000154',
            'password' => '@Rahasia123',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'work_center' => 'PME21001',
            'email_address' => 'doni.duaasattuu@gmail.com',
            'work_center' => 'PME21001',
            'registration_code' => env('REGISTRATION_CODE'),
        ];

        $this->get('/registration');

        $this
            ->followingRedirects()
            ->post('/registration', $data)
            ->assertStatus(200)
            ->assertSeeText('Your account successfully registered.')
            ->assertDontSeeText('User account successfully registered.');

        $user = User::find($data['nik']);
        self::assertNotNull($user);
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
                'registration_code' => 'The registration code field is required.',
            ]);
    }

    // NIK
    public function testRegistrationNikDuplicate()
    {
        $this->seed(UserSeeder::class);

        $data = [
            'nik' => '55000154',
            'password' => '@Rahasia123',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'work_center' => 'PME21001',
            'email_address' => 'doni.duaasattuu@gmail.com',
            'work_center' => 'PME21001',
            'registration_code' => env('REGISTRATION_CODE'),
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
            'password' => '@Rahasia123',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'work_center' => 'PME21001',
            'email_address' => 'doni.duaasattuu@gmail.com',
            'work_center' => 'PME21001',
            'registration_code' => env('REGISTRATION_CODE'),
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
            'password' => '@Rahasia123',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'work_center' => 'PME21001',
            'email_address' => 'doni.duaasattuu@gmail.com',
            'work_center' => 'PME21001',
            'registration_code' => env('REGISTRATION_CODE'),
        ];

        $this->post('/registration', $data)
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'nik' => 'The nik field must be 8 digits.',
                'nik' => 'The nik field must be a number.',
            ]);
    }

    // PASSWORD
    public function testRegistrationPasswordInvalidLengthMin()
    {
        $data = [
            'nik' => '55000154',
            'password' => '@Rhs123',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'work_center' => 'PME21001',
            'email_address' => 'doni.duaasattuu@gmail.com',
            'work_center' => 'PME21001',
            'registration_code' => env('REGISTRATION_CODE'),
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
            'password' => '@VeryLongAndSecretPasswordHaveEverMade123',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'work_center' => 'PME21001',
            'email_address' => 'doni.duaasattuu@gmail.com',
            'work_center' => 'PME21001',
            'email_address' => 'doni.duaasattuu@gmail.com',
            'work_center' => 'PME21001',
            'registration_code' => env('REGISTRATION_CODE'),
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
            'work_center' => 'PME21001',
            'email_address' => 'doni.duaasattuu@gmail.com',
            'work_center' => 'PME21001',
            'registration_code' => env('REGISTRATION_CODE'),
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
            'work_center' => 'PME21001',
            'email_address' => 'doni.duaasattuu@gmail.com',
            'work_center' => 'PME21001',
            'registration_code' => env('REGISTRATION_CODE'),
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
            'work_center' => 'PME21001',
            'email_address' => 'doni.duaasattuu@gmail.com',
            'work_center' => 'PME21001',
            'registration_code' => env('REGISTRATION_CODE'),
        ];

        $this->post('/registration', $data)
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'password' => 'The password field must contain at least one symbol.',
            ]);
    }

    // WORK CENTER 
    public function testRegistrationWorkCenterNull()
    {
        $data = [
            'nik' => '55000154',
            'password' => '@Rahasia123',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'work_center' => 'PME21001',
            'email_address' => 'doni.duaasattuu@gmail.com',
            'work_center' => null,
            'registration_code' => env('REGISTRATION_CODE'),
        ];

        $this
            ->followingRedirects()
            ->post('/registration', $data)
            ->assertSeeText('Your account successfully registered.');
    }

    public function testRegistrationWorkCenterInvalidLength()
    {
        $this->get('/registration');

        $data = [
            'nik' => '55000154',
            'password' => '@Rahasia123',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'work_center' => 'PME21001',
            'email_address' => 'doni.duaasattuu@gmail.com',
            'work_center' => 'PM3',
            'registration_code' => env('REGISTRATION_CODE'),
        ];

        $this
            ->followingRedirects()
            ->post('/registration', $data)
            ->assertSeeText('The work center field must be 8 characters.');
    }

    // FULLNAME
    public function testRegistrationFullnameInvalidMinLength()
    {
        $data = [
            'nik' => '55000154',
            'password' => 'Rahasia@1234',
            'fullname' => 'Doni',
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'work_center' => 'PME21001',
            'email_address' => 'doni.duaasattuu@gmail.com',
            'work_center' => 'PME21001',
            'registration_code' => env('REGISTRATION_CODE'),
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
            'fullname' => 'Doni Darmawan Wibisono Pratama Pangestu Bumi Putra Tan Malaka',
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'work_center' => 'PME21001',
            'email_address' => 'doni.duaasattuu@gmail.com',
            'work_center' => 'PME21001',
            'registration_code' => env('REGISTRATION_CODE'),
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
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'work_center' => 'PME21001',
            'email_address' => 'doni.duaasattuu@gmail.com',
            'work_center' => 'PME21001',
            'registration_code' => env('REGISTRATION_CODE'),
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
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'work_center' => 'PME21001',
            'email_address' => 'doni.duaasattuu@gmail.com',
            'work_center' => 'PME21001',
            'registration_code' => env('REGISTRATION_CODE'),
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
            'work_center' => 'PME21001',
            'registration_code' => env('REGISTRATION_CODE'),
        ];

        $this->post('/registration', $data)
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'fullname' => 'The fullname field format is invalid.',
            ]);
    }

    // DEPARTMENT
    public function testRegistrationDepartmentInvalid()
    {
        $data = [
            'nik' => '55000154',
            'password' => 'Rahasia@1234',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI11',
            'phone_number' => '08983456945',
            'email_address' => 'doni.duaasattuu@gmail.com',
            'registration_code' => env('REGISTRATION_CODE'),
        ];

        $this->post('/registration', $data)
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'department' => 'The selected department is invalid.',
            ]);
    }

    public function testRegistrationDepartmentNull()
    {
        $data = [
            'nik' => '55000154',
            'password' => 'Rahasia@1234',
            'fullname' => 'Doni Darmawan',
            'department' => null,
            'phone_number' => '08983456945',
            'email_address' => 'doni.duaasattuu@gmail.com',
            'registration_code' => env('REGISTRATION_CODE'),
        ];

        $this->post('/registration', $data)
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'department' => 'The department field is required.',
            ]);
    }

    // EMAIL ADDRESS
    public function testRegistrationEmailAddressNull()
    {
        $data = [
            'nik' => '55000154',
            'password' => 'Rahasia@1234',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'work_center' => 'PME21001',
            'email_address' => null,
            'registration_code' => env('REGISTRATION_CODE'),
        ];

        $this
            ->followingRedirects()
            ->post('/registration', $data)
            ->assertSessionHasNoErrors([
                'department' => 'The department field is required.',
            ])
            ->assertSeeText('Your account successfully registered.');
    }

    public function testRegistrationEmailAddressInvalidSuffix()
    {
        $this->get('/registration');

        $data = [
            'nik' => '55000154',
            'password' => 'Rahasia@1234',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'work_center' => 'PME21001',
            'email_address' => 'doni.duaasattuu@yahoo.co.id',
            'registration_code' => env('REGISTRATION_CODE'),
        ];

        $this
            ->followingRedirects()
            ->post('/registration', $data)
            ->assertSeeText('The email address field must end with one of the following: @fajarpaper.com, @gmail.com.');
    }

    public function testRegistrationEmailAddressDuplicate()
    {
        $this->seed(UserSeeder::class);

        $this->get('/registration');

        $data = [
            'nik' => '55000155',
            'password' => 'Rahasia@1234',
            'fullname' => 'Rizky Setiawan',
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'work_center' => 'PME21001',
            'email_address' => 'doni.duaasattuu@gmail.com',
            'registration_code' => env('REGISTRATION_CODE'),
        ];

        $this
            ->followingRedirects()
            ->post('/registration', $data)
            ->assertSeeText('The email address has already been taken.');
    }

    // PHONE NUMBER
    public function testRegistrationPhoneNumberInvalidNumeric()
    {
        $data = [
            'nik' => '55000154',
            'password' => 'Rahasia@1234',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI2',
            'phone_number' => 'abcdefgh',
            'work_center' => 'PME21001',
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
            'password' => 'Rahasia@1234',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI2',
            'phone_number' => '123456789',
            'work_center' => 'PME21001',
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
            ->assertSeeText("Don't have an account ?", false);
    }

    public function testGetLoginRedirect()
    {
        $this->seed(UserSeeder::class);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/login')
            ->assertStatus(302)
            ->assertRedirect('/');
    }

    public function testLoginSuccess()
    {
        $this->testRegistrationSuccess();

        $this->get('/login');

        $this->post('/login', [
            'nik' => '55000154',
            'password' => '@Rahasia123',
        ])
            ->assertStatus(302)
            ->assertRedirectToRoute('home');
    }

    public function testLoginFailed()
    {
        $this->seed(UserSeeder::class);

        $this->get('/login');

        $this->post('/login', [
            'nik' => '55000154',
            'password' => 'wrond_password',
        ])
            ->assertStatus(302)
            ->assertRedirectToRoute('login');
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

    public function testLoginEmptyNik()
    {
        $this->seed(UserSeeder::class);

        $this->post('/login', [
            'nik' => '',
            'password' => 'rahasia'
        ])
            ->assertSessionHasErrors([
                'nik' => 'The nik field is required.',
            ]);
    }

    public function testLoginEmptyPassword()
    {
        $this->seed(UserSeeder::class);

        $this->post('/login', [
            'nik' => '55000154',
            'password' => ''
        ])
            ->assertSessionHasErrors([
                'password' => 'The password field is required.'
            ]);
    }

    public function testLoginUnregisteredNik()
    {
        $this->seed(UserSeeder::class);

        $this->post('/login', [
            'nik' => '55000123',
            'password' => 'rahasia'
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
            'password' => 'rahasia'
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
            'password' => 'Rahasia@123'
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

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/profile')
            ->assertSeeText('My profile')
            ->assertSeeText('Phone number')
            ->assertSeeText('08983456945')
            ->assertDontSeeText('Password')
            ->assertSeeText('Doni Darmawan')
            ->assertSeeText('Update profile')
            ->assertSeeText('New password')
            ->assertSeeText('New password confirmation')
            ->assertSeeText('Update');
    }

    // UPDATE PROFILE
    public function testUpdateProfileSuccess()
    {
        $this->testGetProfile();

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '55000154',
                'fullname' => 'Doni Darmawan',
                'department' => 'EI2',
                'phone_number' => '08983456945',
                'work_center' => 'PME21001',
                'email_address' => 'doni_duaasattuu@gmail.com',
                'work_center' => 'PME21001',
                'new_password' => 'Rahasia@123',
                'new_password_confirmation' => 'Rahasia@123',
            ])
            ->assertSeeText('Your profile successfully updated.');
    }

    // NIK UNMATCH
    public function testUpdateProfileNikOverride()
    {
        $this->testGetProfile();

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '55000153',
                'fullname' => 'Doni Darmawan',
                'department' => 'EI2',
                'phone_number' => '08983456945',
                'work_center' => 'PME21001',
                'email_address' => 'doni_duaasattuu@gmail.com',
                'work_center' => 'PME21001',
                'new_password' => 'OverridePassword123',
                'new_password_confirmation' => 'OverridePassword123',
            ])
            ->assertSeeText('The nik field must match current nik.');
    }

    // DEPARTMENT
    public function testUpdateProfileDepartmentNull()
    {
        $this->testGetProfile();

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '55000154',
                'fullname' => 'Doni Darmawan',
                'department' => null,
                'phone_number' => '08983456945',
                'email_address' => 'doni_duaasattuu@gmail.com',
                'work_center' => 'PME21001',
                'new_password' => 'Rahasia@123',
                'new_password_confirmation' => 'Rahasia@123',
            ])
            ->assertSeeText('The department field is required.');
    }

    public function testUpdateProfileDepartmentInvalid()
    {
        $this->testGetProfile();

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '55000154',
                'fullname' => 'Doni Darmawan',
                'department' => 'EI9',
                'phone_number' => '08983456945',
                'email_address' => 'doni_duaasattuu@gmail.com',
                'work_center' => 'PME21001',
                'new_password' => 'Rahasia@123',
                'new_password_confirmation' => 'Rahasia@123',
            ])
            ->assertSeeText('The selected department is invalid.');
    }

    // EMAIL
    public function testUpdateProfileEmailNullFailed()
    {
        $this->testGetProfile();

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '55000154',
                'fullname' => 'Doni Darmawan',
                'department' => 'EI2',
                'phone_number' => '08983456945',
                'email_address' => null,
                'work_center' => 'PME21001',
                'new_password' => 'Rahasia@123',
                'new_password_confirmation' => 'Rahasia@123',
            ])
            ->assertDontSeeText('The selected email address is required.')
            ->assertSeeText('Your profile successfully updated.');
    }

    public function testUpdateProfileEmailInvalidSuffix()
    {
        $this->testGetProfile();

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '55000154',
                'fullname' => 'Doni Darmawan',
                'department' => 'EI2',
                'phone_number' => '08983456945',
                'email_address' => 'doni@yahoo.co.id',
                'work_center' => 'PME21001',
                'new_password' => 'Rahasia@123',
                'new_password_confirmation' => 'Rahasia@123',
            ])
            ->assertSeeText('The email address field must end with one of the following: @fajarpaper.com, @gmail.com.')
            ->assertDontSeeText('Your profile successfully updated.');
    }

    public function testUpdateProfileEmailDuplicate()
    {
        $this->testGetProfile();
        $this->seed(EmailRecipientSeeder::class);

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '55000154',
                'fullname' => 'Doni Darmawan',
                'department' => 'EI2',
                'phone_number' => '08983456945',
                'email_address' => 'jiyantoro@gmail.com',
                'work_center' => 'PME21001',
                'new_password' => 'Rahasia@123',
                'new_password_confirmation' => 'Rahasia@123',
            ])
            ->assertSeeText('The email address has already been taken.')
            ->assertDontSeeText('Your profile successfully updated.');
    }

    public function testUpdateProfileEmailNoChanges()
    {
        $this->testGetProfile();
        $this->seed(EmailRecipientSeeder::class);

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '55000154',
                'fullname' => 'Doni Darmawan',
                'department' => 'EI2',
                'phone_number' => '08983456945',
                'email_address' => 'doni.duaasattuu@gmail.com',
                'work_center' => 'PME21001',
                'new_password' => 'Rahasia@123',
                'new_password_confirmation' => 'Rahasia@123',
            ])
            ->assertDontSeeText('The email address has already been taken.')
            ->assertSeeText('Your profile successfully updated.');
    }

    // PHONE NUMBER
    public function testUpdateProfilePhoneNumberInvalidMin()
    {
        $this->testGetProfile();

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '55000154',
                'fullname' => 'Doni Darmawan',
                'department' => 'EI2',
                'phone_number' => '0898',
                'email_address' => 'doni.duaasattuu@gmail.com',
                'work_center' => 'PME21001',
                'new_password' => 'Rahasia@123',
                'new_password_confirmation' => 'Rahasia@123',
            ])
            ->assertSeeText('The phone number field must be between 10 and 13 digits.');
    }

    public function testUpdateProfilePhoneNumberInvalidMax()
    {
        $this->testGetProfile();

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '55000154',
                'fullname' => 'Doni Darmawan',
                'department' => 'EI2',
                'phone_number' => '08983456945081',
                'email_address' => 'doni.duaasattuu@gmail.com',
                'work_center' => 'PME21001',
                'new_password' => 'Rahasia@123',
                'new_password_confirmation' => 'Rahasia@123',
            ])
            ->assertSeeText('The phone number field must be between 10 and 13 digits.');
    }

    public function testUpdateProfilePhoneNumberInvalidType()
    {
        $this->testGetProfile();

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '55000154',
                'fullname' => 'Doni Darmawan',
                'department' => 'EI2',
                'phone_number' => 'string',
                'email_address' => 'doni.duaasattuu@gmail.com',
                'work_center' => 'PME21001',
                'new_password' => 'Rahasia@123',
                'new_password_confirmation' => 'Rahasia@123',
            ])
            ->assertSeeText('The phone number field must be a number.');
    }

    // WORK CENTER
    public function testUpdateProfileWorkCenterNull()
    {
        $this->testGetProfile();

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '55000154',
                'fullname' => 'Doni Darmawan',
                'department' => 'EI2',
                'phone_number' => '08983456945',
                'email_address' => 'doni.duaasattuu@gmail.com',
                'work_center' => null,
                'new_password' => 'Rahasia@123',
                'new_password_confirmation' => 'Rahasia@123',
            ])
            ->assertDontSeeText('The work center field is required.')
            ->assertSeeText('Your profile successfully updated.');
    }

    public function testUpdateProfileWorkCenterInvalidLength()
    {
        $this->testGetProfile();

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '55000154',
                'fullname' => 'Doni Darmawan',
                'department' => 'EI2',
                'phone_number' => '08983456945',
                'email_address' => 'doni.duaasattuu@gmail.com',
                'work_center' => 'PME210001',
                'new_password' => 'Rahasia@123',
                'new_password_confirmation' => 'Rahasia@123',
            ])
            ->assertSeeText('The work center field must be 8 characters.')
            ->assertDontSeeText('Your profile successfully updated.');
    }

    // PASSWORD
    public function testUpdateProfilePasswordMissing()
    {
        $this->testGetProfile();

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '55000154',
                'fullname' => 'Doni Darmawan',
                'department' => 'EI2',
                'phone_number' => '08983456945',
                'work_center' => 'PME21001',
                'email_address' => 'doni_duaasattuu@gmail.com',
                'work_center' => 'PME21001',
                'new_password' => '',
                'new_password_confirmation' => '',
            ])
            ->assertSeeText('The new password field is required.')
            ->assertSeeText('The new password confirmation field is required.');
    }

    public function testUpdateProfilePasswordMissMatching()
    {
        $this->testGetProfile();

        $this
            ->followingRedirects()->post('/update-profile', [
                'nik' => '55000154',
                'fullname' => 'Doni Darmawan',
                'department' => 'EI2',
                'phone_number' => '08983456945',
                'work_center' => 'PME21001',
                'email_address' => 'doni_duaasattuu@gmail.com',
                'work_center' => 'PME21001',
                'new_password' => 'Rahasia@1234',
                'new_password_confirmation' => 'Rahasia@12345',
            ])
            ->assertSeeText('The new password confirmation field must match new password.');
    }

    // USERS MANAGEMENT PAGE FOR SUPERADMIN
    public function testGetUserManagementGuest()
    {
        $this->seed(UserSeeder::class);

        $this->get('/users')
            ->assertRedirectToRoute('login');
    }

    public function testGetUserManagementEmployee()
    {
        $this->seed(UserRoleSeeder::class);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia'
        ]);

        self::assertFalse(Auth::user()->isSuperAdmin());

        $this
            ->followingRedirects()
            ->get('/users')
            ->assertSeeText('You are not allowed to perform this operation!');
    }

    public function testGetUserManagementAdmin()
    {
        $this->seed(UserRoleSeeder::class);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/users')
            ->assertSeeText('User management')
            ->assertSeeText('Search')
            ->assertSeeText('Dept')
            ->assertSee('EI1')
            ->assertSee('EI2')
            ->assertSee('EI3')
            ->assertSee('EI4')
            ->assertSee('EI5')
            ->assertSee('EI6')
            ->assertSee('EI7')
            ->assertSeeText('Displays')
            ->assertSeeText('entries')
            ->assertSeeText('NIK')
            ->assertSeeText('Fullname')
            ->assertSeeText('Department')
            ->assertSeeText('Phone number')
            ->assertDontSeeText('Admin')
            ->assertDontSeeText('Reset')
            ->assertDontSeeText('Delete');
    }

    public function testGetUserManagementFilterSearchName()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/users?search=to')
            ->assertSeeText('User management')
            ->assertSeeText('Search')
            ->assertSeeText('Dept')
            ->assertSee('EI1')
            ->assertSee('EI2')
            ->assertSee('EI3')
            ->assertSee('EI4')
            ->assertSee('EI5')
            ->assertSee('EI6')
            ->assertSee('EI7')
            ->assertSeeText('Displays')
            ->assertSeeText('entries')
            ->assertSeeText('NIK')
            ->assertSeeText('Fullname')
            ->assertSeeText('Department')
            ->assertSeeText('Phone number')
            ->assertSeeTextInOrder(['Jiyantoro', 'Suryanto', 'Darminto'])
            ->assertDontSeeText('Doni Darmawan')
            ->assertDontSeeText('Admin')
            ->assertDontSeeText('Reset')
            ->assertDontSeeText('Delete');
    }

    public function testGetUserManagementFilterSearchNik()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/users?search=5500015')
            ->assertSeeText('User management')
            ->assertSeeText('Search')
            ->assertSeeText('Dept')
            ->assertSee('EI1')
            ->assertSee('EI2')
            ->assertSee('EI3')
            ->assertSee('EI4')
            ->assertSee('EI5')
            ->assertSee('EI6')
            ->assertSee('EI7')
            ->assertSeeText('Displays')
            ->assertSeeText('entries')
            ->assertSeeText('NIK')
            ->assertSeeText('Fullname')
            ->assertSeeText('Department')
            ->assertSeeText('Phone number')
            ->assertSeeTextInOrder(['Jamal Mirdad', 'Doni Darmawan'])
            ->assertDontSeeText('Suryanto')
            ->assertDontSeeText('Admin')
            ->assertDontSeeText('Reset')
            ->assertDontSeeText('Delete');
    }

    public function testGetUserManagementFilterDept()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/users?dept=EI6')
            ->assertSeeText('User management')
            ->assertSeeText('Search')
            ->assertSeeText('Dept')
            ->assertSee('EI1')
            ->assertSee('EI2')
            ->assertSee('EI3')
            ->assertSee('EI4')
            ->assertSee('EI5')
            ->assertSee('EI6')
            ->assertSee('EI7')
            ->assertSeeText('Displays')
            ->assertSeeText('entries')
            ->assertSeeText('NIK')
            ->assertSeeText('Fullname')
            ->assertSeeText('Department')
            ->assertSeeText('Phone number')
            ->assertSeeText('Jamal Mirdad')
            ->assertDontSeeText('Suryanto')
            ->assertDontSeeText('Doni')
            ->assertDontSeeText('Admin')
            ->assertDontSeeText('Reset')
            ->assertDontSeeText('Delete');
    }

    public function testGetUserManagementFilterSearchAndDept()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/users?search=5500&dept=EI2')
            ->assertSeeText('User management')
            ->assertSeeText('Search')
            ->assertSeeText('Dept')
            ->assertSee('EI1')
            ->assertSee('EI2')
            ->assertSee('EI3')
            ->assertSee('EI4')
            ->assertSee('EI5')
            ->assertSee('EI6')
            ->assertSee('EI7')
            ->assertSeeText('Displays')
            ->assertSeeText('entries')
            ->assertSeeText('NIK')
            ->assertSeeText('Fullname')
            ->assertSeeText('Department')
            ->assertSeeText('Phone number')
            ->assertDontSeeText('Jamal Mirdad')
            ->assertSeeTextInOrder(['Saiful Bahri', 'Edi Supriadi', 'Doni Darmawan'])
            ->assertDontSeeText('Admin')
            ->assertDontSeeText('Reset')
            ->assertDontSeeText('Delete');
    }

    // DELETE USER
    public function testDeleteUserGuest()
    {
        $this->seed(UserSeeder::class);

        $this
            ->get('/user-delete/55000153')
            ->assertRedirectToRoute('login');
    }

    public function testDeleteUserEmployee()
    {
        $this->seed(UserSeeder::class);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->get('/user-delete/31903007')
            ->assertSeeText('You are not allowed to perform this operation!');
    }

    public function testDeleteUserSuperAdmin()
    {
        $this->seed(UserRoleSeeder::class);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->get('/user-delete/31100171')
            ->assertSeeText('User successfully deleted.');
    }

    public function testDeleteUserSelf()
    {
        $this->seed(UserRoleSeeder::class);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $user = Auth::user();

        $this
            ->actingAs($user)
            ->followingRedirects()
            ->get('/user-delete/55000154')
            ->assertSeeText('You cannot delete your self, this action causes an error.');
    }

    public function testUserSuperAdminDeleteTheCreator()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::query()->find('55000153');
        $user->roles()->attach('superadmin');
        self::assertTrue($user->isSuperAdmin());

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->get('/user-delete/55000154')
            ->assertSeeText('You cannot delete the creator.');
    }

    // RESET PASSWORD
    public function testResetPasswordGuest()
    {
        $this->seed(UserSeeder::class);

        $this->get('/user-reset/55000154')
            ->assertRedirectToRoute('login');
    }

    public function testResetPasswordEmployee()
    {

        $this->seed(UserRoleSeeder::class);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia'
        ]);

        $user = Auth::user();

        $this
            ->actingAs($user)
            ->followingRedirects()
            ->get('/user-reset/55000154')
            ->assertSeeText('You are not allowed to perform this operation!');
    }

    public function testResetPasswordSuperAdminSuccess()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::query()->find('55000153');

        self::assertTrue(Hash::check('rahasia', $user->password));

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->get('/user-reset/55000153')
            ->assertSeeText('User password reset successfully.');

        $user = $user->fresh();
        self::assertTrue(Hash::check('@Fajarpaper123', $user->password));
    }

    // EDIT USER BY SUPER ADMIN
    public function testGetEditUserGuest()
    {
        $this->seed(UserRoleSeeder::class);

        $this
            ->get('/user-edit/55000093')
            ->assertRedirectToRoute('login');
    }

    public function testGetEditUserEmployee()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->get('/user-edit/55000093')
            ->assertSeeText('[403] Forbidden')
            ->assertSeeText('You are not allowed to perform this operation!');
    }

    public function testGetEditUserAdmin()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->get('/user-edit/55000093')
            ->assertSeeText('[403] Forbidden')
            ->assertSeeText('You are not allowed to perform this operation!');
    }

    public function testGetEditUserSuperAdmin()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/user-edit/31100019')
            ->assertSeeText('Update user')
            ->assertSeeText('Users')
            ->assertSeeText('Jiyantoro')
            ->assertSeeText('NIK')
            ->assertSee('31100019')
            ->assertSeeText('Fullname')
            ->assertSee('Jiyantoro')
            ->assertSeeText('Department')
            ->assertSee('EI7')
            ->assertSeeText('Email address')
            ->assertSee('jiyantoro@gmail.com')
            ->assertSeeText('Phone number')
            ->assertSee('08991544689')
            ->assertSeeText('Work center')
            ->assertSeeText('Update')
            ->assertDontSeeText('Password');
    }

    public function testGetEditUserSuperAdminSameNik()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/user-edit/55000154')
            ->assertRedirectToRoute('profile');
    }

    // SAVE USER PROFILE
    public function testPostEditUserSuccess()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/user-edit/31100019');

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '31100019',
                'fullname' => 'Jiyantoro',
                'department' => 'EI7',
                'email_address' => 'jiyantoro@gmail.com',
                'phone_number' => '08991544689',
                'work_center' => 'PME21001',
            ])
            ->assertSeeText('User profile successfully updated.');
    }

    // NIK
    public function testPostEditUserNikNull()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/user-edit/31100019');

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => null,
                'fullname' => 'Jiyantoro',
                'department' => 'EI7',
                'email_address' => 'jiyantoro@gmail.com',
                'phone_number' => '08991544689',
                'work_center' => 'PME21001',
            ])
            ->assertSeeText('The nik field is required.')
            ->assertDontSeeText('User profile successfully updated.');
    }

    public function testPostEditUserNikInvalidMinLength()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/user-edit/31100019');

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '5500012',
                'fullname' => 'Jiyantoro',
                'department' => 'EI7',
                'email_address' => 'jiyantoro@gmail.com',
                'phone_number' => '08991544689',
                'work_center' => 'PME21001',
            ])
            ->assertSeeText('The nik field must be 8 digits.')
            ->assertDontSeeText('User profile successfully updated.');
    }

    public function testPostEditUserNikNotFound()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/user-edit/31100019');

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '55000123',
                'fullname' => 'Jiyantoro',
                'department' => 'EI7',
                'email_address' => 'jiyantoro@gmail.com',
                'phone_number' => '08991544689',
                'work_center' => 'PME21001',
            ])
            ->assertSeeText('The selected nik is invalid.')
            ->assertDontSeeText('User profile successfully updated.');
    }

    public function testPostEditUserNikWrong()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/user-edit/31100019');

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '55000092',
                'fullname' => 'Jiyantoro',
                'department' => 'EI7',
                'email_address' => 'jiyantoro@gmail.com',
                'phone_number' => '08991544689',
                'work_center' => 'PME21001',
            ])
            ->assertSeeText('The email address has already been taken.')
            ->assertDontSeeText('User profile successfully updated.');
    }

    // FULLNAME
    public function testPostEditUserFullnameNull()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/user-edit/31100019');

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '31100019',
                'fullname' => null,
                'department' => 'EI7',
                'email_address' => 'jiyantoro@gmail.com',
                'phone_number' => '08991544689',
                'work_center' => 'PME21001',
            ])
            ->assertSeeText('The fullname field is required.')
            ->assertDontSeeText('User profile successfully updated.');
    }

    public function testPostEditUserFullnameDuplicateSuccess()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/user-edit/31100019');

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '31100019',
                'fullname' => 'Saiful Bahri',
                'department' => 'EI7',
                'email_address' => 'jiyantoro@gmail.com',
                'phone_number' => '08991544689',
                'work_center' => 'PME21001',
            ])
            ->assertSeeText('User profile successfully updated.');
    }

    public function testPostEditUserFullnameMinLength()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/user-edit/31100019');

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '31100019',
                'fullname' => 'Sai',
                'department' => 'EI7',
                'email_address' => 'jiyantoro@gmail.com',
                'phone_number' => '08991544689',
                'work_center' => 'PME21001',
            ])
            ->assertSeeText('The fullname field must be at least 6 characters.')
            ->assertDontSeeText('User profile successfully updated.');
    }

    // DEPARTMENT
    public function testPostEditUserDepartmentNull()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/user-edit/31100019');

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '31100019',
                'fullname' => 'Jiyantoro',
                'department' => null,
                'email_address' => 'jiyantoro@gmail.com',
                'phone_number' => '08991544689',
                'work_center' => 'PME21001',
            ])
            ->assertSeeText('The department field is required.')
            ->assertDontSeeText('User profile successfully updated.');
    }

    public function testPostEditUserDepartmentInvalid()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/user-edit/31100019');

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '31100019',
                'fullname' => 'Jiyantoro',
                'department' => 'EI9',
                'email_address' => 'jiyantoro@gmail.com',
                'phone_number' => '08991544689',
                'work_center' => 'PME21001',
            ])
            ->assertSeeText('The selected department is invalid.')
            ->assertDontSeeText('User profile successfully updated.');
    }

    // EMAIL ADDRESS
    public function testPostEditUserEmailAddressNull()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/user-edit/31100019');

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '31100019',
                'fullname' => 'Jiyantoro',
                'department' => 'EI7',
                'email_address' => null,
                'phone_number' => '08991544689',
                'work_center' => 'PME21001',
            ])
            ->assertDontSeeText('The email address is required.')
            ->assertSeeText('User profile successfully updated.');
    }

    public function testPostEditUserEmailAddressDuplicate()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/user-edit/31100019');

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '31100019',
                'fullname' => 'Jiyantoro',
                'department' => 'EI7',
                'email_address' => 'saiful@gmail.com',
                'phone_number' => '08991544689',
                'work_center' => 'PME21001',
            ])
            ->assertSeeText('The email address has already been taken.')
            ->assertDontSeeText('User profile successfully updated.');
    }

    public function testPostEditUserEmailAddressInvalidSuffix()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/user-edit/31100019');

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '31100019',
                'fullname' => 'Jiyantoro',
                'department' => 'EI7',
                'email_address' => 'jiyantoro@yahoo.co.id',
                'phone_number' => '08991544689',
                'work_center' => 'PME21001',
            ])
            ->assertSeeText('The email address field must end with one of the following: @fajarpaper.com, @gmail.com.')
            ->assertDontSeeText('User profile successfully updated.');
    }

    // PHONE NUMBER
    public function testPostEditUserPhoneNumberNull()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/user-edit/31100019');

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '31100019',
                'fullname' => 'Jiyantoro',
                'department' => 'EI7',
                'email_address' => 'jiyantoro@gmail.com',
                'phone_number' => null,
                'work_center' => 'PME21001',
            ])
            ->assertDontSeeText('The phone number field is required.')
            ->assertSeeText('User profile successfully updated.');
    }

    public function testPostEditUserPhoneNumberInvalidType()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/user-edit/31100019');

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '31100019',
                'fullname' => 'Jiyantoro',
                'department' => 'EI7',
                'email_address' => 'jiyantoro@gmail.com',
                'phone_number' => '_62',
                'work_center' => 'PME21001',
            ])
            ->assertSeeText('The phone number field must be a number.')
            ->assertDontSeeText('User profile successfully updated.');
    }

    public function testPostEditUserPhoneNumberInvalidLengthMin()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/user-edit/31100019');

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '31100019',
                'fullname' => 'Jiyantoro',
                'department' => 'EI7',
                'email_address' => 'jiyantoro@gmail.com',
                'phone_number' => '085',
                'work_center' => 'PME21001',
            ])
            ->assertSeeText('The phone number field must be between 10 and 13 digits.')
            ->assertDontSeeText('User profile successfully updated.');
    }

    public function testPostEditUserPhoneNumberInvalidLengthMax()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/user-edit/31100019');

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '31100019',
                'fullname' => 'Jiyantoro',
                'department' => 'EI7',
                'email_address' => 'jiyantoro@gmail.com',
                'phone_number' => '08567891201201',
                'work_center' => 'PME21001',
            ])
            ->assertSeeText('The phone number field must be between 10 and 13 digits.')
            ->assertDontSeeText('User profile successfully updated.');
    }

    // WORK CENTER
    public function testPostEditUserWorkCenterNull()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/user-edit/31100019');

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '31100019',
                'fullname' => 'Jiyantoro',
                'department' => 'EI7',
                'email_address' => 'jiyantoro@gmail.com',
                'phone_number' => '08991544689',
                'work_center' => null,
            ])
            ->assertDontSeeText('The work center field is required.')
            ->assertSeeText('User profile successfully updated.');
    }

    public function testPostEditUserWorkCenterInvalid()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->get('/user-edit/31100019');

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '31100019',
                'fullname' => 'Jiyantoro',
                'department' => 'EI7',
                'email_address' => 'jiyantoro@gmail.com',
                'phone_number' => '08991544689',
                'work_center' => 'PME',
            ])
            ->assertSeeText('The work center field must be 8 characters.')
            ->assertDontSeeText('User profile successfully updated.');
    }

    // PASSWORD OVERRIDE
    public function testPostEditUserPasswordOverride()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $user = Auth::user();
        self::assertTrue(Hash::check('rahasia', $user->password));

        $this
            ->get('/user-edit/31100019');

        $this
            ->followingRedirects()
            ->post('/update-profile', [
                'nik' => '31100019',
                'fullname' => 'Jiyantoro',
                'department' => 'EI7',
                'email_address' => 'jiyantoro@gmail.com',
                'phone_number' => '08991544689',
                'work_center' => 'PME21001',
                'password' => bcrypt('changed'),
            ])
            ->assertSeeText('User profile successfully updated.');

        self::assertFalse(Hash::check('changed', $user->password));
        self::assertTrue(Hash::check('rahasia', $user->password));
    }
}
