<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testUserRelationToRole()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class]);

        $user = User::query()->with(['roles'])->find('55000154');
        self::assertNotNull($user->roles);

        $roles = $user->roles;
        $roles = $roles->map(function ($value, $key) {
            return $value->role;
        });

        self::assertTrue($roles->contains('admin'));
        self::assertFalse($roles->contains('employee'));
        self::assertTrue($roles->contains('db_admin'));
    }

    public function testIsUserAdminTrue()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class]);

        $user = User::query()->find('55000154');
        self::assertNotNull($user);
        $isAdmin = $user->isAdmin();
        self::assertTrue($isAdmin);
    }

    public function testIsUserAdminFalse()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class]);

        $user = User::query()->find('55000153');
        self::assertNotNull($user);
        $isAdmin = $user->isAdmin();
        self::assertFalse($isAdmin);
    }

    public function testIsUserDbAdminTrue()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class]);

        $user = User::query()->find('55000154');
        self::assertNotNull($user);
        $isDbAdmin = $user->isDbAdmin();
        self::assertTrue($isDbAdmin);
    }

    public function testIsUserDbAdminFalsePrima()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class]);

        $user = User::query()->find('31811016');
        self::assertNotNull($user);
        $isAdmin = $user->isAdmin();
        self::assertFalse($isAdmin);
    }

    public function testIsUserDbAdminFalse()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class]);

        $user = User::query()->find('55000153');
        self::assertNotNull($user);
        $isDbAdmin = $user->isDbAdmin();
        self::assertFalse($isDbAdmin);
    }

    public function testtestAbbreviatedNameNormal()
    {
        $this->seed(UserSeeder::class);

        $user = User::query()->find('55000154');
        self::assertNotNull($user->abbreviated_name);
        self::assertEquals('Doni Darmawan', $user->abbreviated_name);
        self::assertEquals($user->fullname, $user->abbreviated_name);
    }

    public function testAbbreviatedNameExcees()
    {
        $this->seed(UserSeeder::class);

        $user = User::query()->find('31811016');
        self::assertNotNull($user->abbreviated_name);
        self::assertNotEquals($user->fullname, $user->abbreviated_name);
        self::assertEquals('Prima Hendra K', $user->abbreviated_name);
    }

    public function testAbbreviatedNameExceesFour()
    {
        $this->seed(UserSeeder::class);

        $user = User::query()->find('31903007');
        self::assertNotNull($user->abbreviated_name);
        self::assertNotEquals($user->fullname, $user->abbreviated_name);
        self::assertEquals('Yuan Lucky Prasetyo Winarno', $user->fullname);
        self::assertEquals('Yuan Lucky P', $user->abbreviated_name);
    }
}
