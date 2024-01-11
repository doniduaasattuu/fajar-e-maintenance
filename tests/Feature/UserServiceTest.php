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
    public function testUserService()
    {
        $userService = $this->app->make(UserService::class);
        self::assertNotNull($userService);
    }

    public function testUserServiceLoginSuccess()
    {
        $this->seed(UserSeeder::class);
        $userService = $this->app->make(UserService::class);
        $login = $userService->login('55000154', 'rahasia');

        self::assertTrue($login);
    }

    public function testUserServiceNik()
    {
        $this->seed(UserSeeder::class);
        $userService = $this->app->make(UserService::class);
        self::assertCount(2, $userService->niks());
        Log::info(json_encode($userService->niks(), JSON_PRETTY_PRINT));
    }

    public function testUserServiceLoginFailed()
    {
        $this->seed(UserSeeder::class);
        $userService = $this->app->make(UserService::class);
        $login = $userService->login('55000154', 'salah');

        self::assertFalse($login);
    }

    public function testUserServiceRegistrationSuccess()
    {
        $userService = $this->app->make(UserService::class);

        $user = new User();
        $user->nik = '55000154';
        $user->password = 'rahasia';
        $user->fullname = 'Doni Darmawan';
        $user->department = 'EI2';
        $user->phone_number = '08983456945';

        $register = $userService->registration($user);
        self::assertTrue($register);

        $user = User::query()->find('55000154');
        self::assertNotNull($user);
        self::assertEquals('Doni Darmawan', $user->fullname);
        self::assertTrue($userService->login('55000154', 'rahasia'));
    }

    public function testUserServiceRegistrationFailedDuplicate()
    {
        $this->seed(UserService::class);
        $userService = $this->app->make(UserService::class);

        $user = new User();
        $user->nik = '55000154';
        $user->password = 'rahasia';
        $user->fullname = 'Doni Darmawan';
        $user->department = 'EI2';
        $user->phone_number = '08983456945';

        $register = $userService->registration($user);
        self::assertTrue($register);

        // $user = User::query()->find('55000154');
        // self::assertNotNull($user);
        // self::assertEquals('Doni Darmawan', $user->fullname);
        // self::assertTrue($userService->login('55000154', 'rahasia'));
    }
}
