<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\UserService;
use Database\Seeders\UserSeeder;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    public function testUserServiceExist()
    {
        $userService = $this->app->make(UserService::class);
        self::assertNotNull($userService);
    }

    public function testUserServiceUserExists()
    {
        $this->seed(UserSeeder::class);
        $userService = $this->app->make(UserService::class);
        self::assertTrue($userService->userExists('55000154'));
    }

    public function testUserServiceRegisteredNiks()
    {
        $this->seed(UserSeeder::class);
        $userService = $this->app->make(UserService::class);

        $niks = [
            '55000153',
            '55000154'
        ];

        self::assertEquals($niks, $userService->registeredNiks());
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

    public function testUserServiceLoginSuccess()
    {
        $this->seed(UserSeeder::class);
        $userService = $this->app->make(UserService::class);

        $validated = [
            'nik' => '55000154',
            'password' => '@Fajarpaper123'
        ];

        self::assertTrue($userService->login($validated));
    }

    public function testUserServiceLoginFailed()
    {
        $this->seed(UserSeeder::class);
        $userService = $this->app->make(UserService::class);

        $validated = [
            'nik' => '55000154',
            'password' => 'salah'
        ];

        self::assertFalse($userService->login($validated));
    }

    public function testUserServiceGetColumn()
    {
        $userService = $this->app->make(UserService::class);

        $columns = [
            'nik',
            'password',
            'fullname',
            'department',
            'phone_number',
        ];

        self::assertEquals($columns, $userService->getTableColumns());
    }

    public function testUserServiceUser()
    {
        $this->seed(UserSeeder::class);

        $userService = $this->app->make(UserService::class);
        $currentUser = $userService->user('55000154');
        self::assertNotNull($currentUser);
        Log::info(json_encode($currentUser, JSON_PRETTY_PRINT));
    }

    public function testUserServiceUpdate()
    {
        $this->seed(UserSeeder::class);

        $userService = $this->app->make(UserService::class);
        $validated = [
            'nik' => '55000154',
            'password' => '@Fajarpaper321',
            'fullname' => 'Doni Darmawan',
            'department' => 'EI2',
            'phone_number' => '08983456945',
        ];

        $user = User::query()->find($validated['nik']);
        self::assertEquals('@Fajarpaper123', $user->password);

        self::assertTrue($userService->updateProfile($validated));
        $user = User::query()->find($validated['nik']);
        self::assertEquals('@Fajarpaper321', $user->password);
    }

    public function testQuery()
    {
        $this->seed(UserSeeder::class);
        $users = User::query()->get();
        $doni = $users->find('55000154');
        self::assertNotNull($doni);
        Log::info(json_encode($doni, JSON_PRETTY_PRINT));
    }
}
