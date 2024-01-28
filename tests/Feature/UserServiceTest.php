<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\UserService;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
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
            '31100019',
            '31100156',
            '31100171',
            '31811016',
            '31903007',
            '32007012',
            '55000092',
            '55000093',
            '55000135',
            '55000153',
            '55000154',
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
            'created_at',
            'updated_at',
        ];

        self::assertEquals($columns, $userService->getTableColumns());
    }

    public function testUserServiceUser()
    {
        $this->seed(UserSeeder::class);

        $userService = $this->app->make(UserService::class);
        $currentUser = $userService->user('55000154');
        self::assertNotNull($currentUser);
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

    public function testIsAdminTrue()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class]);
        $userService = $this->app->make(UserService::class);
        $admin = $userService->isAdmin('55000154');
        self::assertTrue($admin);
    }

    public function testIsAdminFalse()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class]);
        $userService = $this->app->make(UserService::class);
        $admin = $userService->isAdmin('55000153');
        self::assertFalse($admin);
    }
}
