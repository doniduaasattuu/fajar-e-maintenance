<?php

namespace Tests\Feature;

use App\Models\Role;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Tests\TestCase;

class RoleTest extends TestCase
{
    public function testRoleDbAdmin()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class]);

        $roles = Role::query()->where(['role' => 'db_admin'])->get();
        self::assertNotEmpty($roles);
        self::assertCount(3, $roles);

        $nik = '55000154';
        $user = $roles->firstWhere('nik', $nik);
        self::assertNotNull($user);
        self::assertEquals('55000154', $user->nik);
        self::assertEquals('db_admin', $user->role);
    }

    public function testRoleAdmin()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class]);

        $roles = Role::query()->where(['role' => 'admin'])->get();
        self::assertNotEmpty($roles);

        $nik = '55000154';
        $user = $roles->firstWhere('nik', $nik);
        self::assertNotNull($user);
    }

    public function testRoleAdminUser()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class]);

        $nik = '55000154';
        $hasRoles = Role::query()->where(['nik' => $nik, 'role' => 'admin'])->first();
        self::assertNotNull($hasRoles);
    }

    public function testDbAdminRoleRelationToUser()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class]);
        $roles = Role::query()->with(['User'])->where('role', '=', 'db_admin')->get();
        self::assertNotNull($roles);
        self::assertCount(3, $roles);
    }

    public function testAdminRoleRelationToUser()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class]);
        $roles = Role::query()->with(['User'])->where('role', '=', 'db_admin')->get();
        self::assertNotNull($roles);
        self::assertCount(3, $roles);
    }
}
