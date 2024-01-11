<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testRegistration()
    {
        $data = [
            'nik' => '55000154',
            'password' => '@Donida2104',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI2',
            'phone_number' => '08983456945',
            'registration_code' => 'ada',
        ];

        $rules = [
            'nik' => ['required', 'size:8'],
            'password' => ['required', 'min:6'],
            'fullname' => ['required'],
            'department' => ['required'],
            'phone_number' => ['required', 'min:10', 'numeric'],
            'registration_code' => ['required'],
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            Log::info(json_encode($validator->errors()), JSON_PRETTY_PRINT);
        } else {
            Log::info(json_encode($validator->validated()));
        }
    }
    public function testUserControllerLoginSuccess()
    {
        $this->seed(UserSeeder::class);

        $this->post('/login', [
            'nik' => '55000154',
            'password' => 'rahasia'
        ])
            ->assertSeeText('Hello world');
    }

    public function testUserControllerLoginFailed()
    {
        $this->seed(UserSeeder::class);

        $this->post('/login', [
            'nik' => '',
            'password' => 'rahasia'
        ])
            ->assertSeeText('The nik field is required.');
    }
}
