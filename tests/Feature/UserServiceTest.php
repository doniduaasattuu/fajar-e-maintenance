<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\UserService;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    public function testUserServiceExist()
    {
        $userService = $this->app->make(UserService::class);
        self::assertNotNull($userService);
    }

    public function testUserServiceUserExist()
    {
        $this->seed(UserSeeder::class);
        $userService = $this->app->make(UserService::class);
        self::assertTrue($userService->userExists('55000154'));
    }

    public function testUserServiceDepartments()
    {
        $userService = $this->app->make(UserService::class);
        $departments = [
            'EI1',
            'EI2',
            'EI3',
            'EI4',
            'EI5',
            'EI6',
            'EI7',
        ];

        self::assertEquals($userService->departments(), $departments);
    }
}
