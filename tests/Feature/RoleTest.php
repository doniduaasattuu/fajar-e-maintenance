<?php

namespace Tests\Feature;

use App\Models\Role;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class RoleTest extends TestCase
{
    public function testRoleEmployee()
    {
        $this->seed(DatabaseSeeder::class);

        $roles = Role::query()->where(['role' => 'employee'])->get();
        self::assertNotEmpty($roles);
        self::assertCount(2, $roles);

        $nik = '55000154';
        $user = $roles->firstWhere('nik', $nik);
        self::assertNotNull($user);
        self::assertEquals('55000154', $user->nik);
        self::assertEquals('employee', $user->role);
    }

    public function testRoleDbAdmin()
    {
        $this->seed(DatabaseSeeder::class);

        $roles = Role::query()->where(['role' => 'db_admin'])->get();
        self::assertNotEmpty($roles);
        self::assertCount(1, $roles);

        $nik = '55000154';
        $user = $roles->firstWhere('nik', $nik);
        self::assertNotNull($user);
        self::assertEquals('55000154', $user->nik);
        self::assertEquals('db_admin', $user->role);
    }

    public function testRoleAdmin()
    {
        $this->seed(DatabaseSeeder::class);

        $roles = Role::query()->where(['role' => 'admin'])->get();
        self::assertEmpty($roles);

        $nik = '55000154';
        $user = $roles->firstWhere('nik', $nik);
        self::assertNull($user);
    }

    public function testRoleEmployeeUser()
    {
        $this->seed(DatabaseSeeder::class);

        $nik = '55000154';
        $hasRoles = Role::query()->where(['nik' => $nik, 'role' => 'employee'])->first();
        self::assertNotNull($hasRoles);
        Log::info($hasRoles);
    }

    public function testRoleAdminUser()
    {
        $this->seed(DatabaseSeeder::class);

        $nik = '55000154';
        $hasRoles = Role::query()->where(['nik' => $nik, 'role' => 'admin'])->first();
        self::assertNull($hasRoles);
    }
}
