<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
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
