<?php

namespace Tests\Feature;

use App\Http\Controllers\UserController;
use App\Services\UserService;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
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
            ->assertSeeText('Full Name')
            ->assertSeeText('Department')
            ->assertSeeText('EI1')
            ->assertSeeText('EI2')
            ->assertSeeText('EI3')
            ->assertSeeText('EI4')
            ->assertSeeText('EI5')
            ->assertSeeText('EI6')
            ->assertSeeText('EI7')
            ->assertSeeText('Phone Number')
            ->assertSeeText('Registration Code')
            ->assertSeeText('Sign Up')
            ->assertSeeText('Already have an account ?');
    }

    public function testRegistrationSuccess()
    {
        $data = [
            'nik' => '55000154',
            'password' => 'Rahasia@1234',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'registration_code' => env('REGISTRATION_CODE'),
        ];

        $this->post('/registration', $data)
            ->assertStatus(302)
            ->assertRedirect('/login');
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
            'password' => 'Rahasia@1234',
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
            'password' => 'Rahasia@1234',
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
            'password' => 'Rahasia@1234',
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

    public function testRegistrationPasswordInvalidLength()
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

    public function testRegistrationDepartmentInvalid()
    {
        $data = [
            'nik' => '55000154',
            'password' => 'Rahasia@1234',
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
            'password' => 'Rahasia@1234',
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
            'password' => 'Rahasia@1234',
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
}
