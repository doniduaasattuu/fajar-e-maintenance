<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\UserRoleSeeder;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Illuminate\Support\Str;

class RoleTest extends TestCase
{
    public function testUserAsAdmin()
    {
        $this->seed(UserRoleSeeder::class);

        $role_admin = Role::query()->find('admin');
        $users = $role_admin->users;
        self::assertNotNull($users);
        self::assertNotEmpty($users);
        self::assertCount(2, $users);
    }

    public function testUserAsSuperAdmin()
    {
        $this->seed(UserRoleSeeder::class);

        $role_admin = Role::query()->find('superadmin');
        $users = $role_admin->users;
        self::assertNotNull($users);
        self::assertNotEmpty($users);
        self::assertCount(1, $users);
        self::assertEquals($users[0]->fullname, 'Doni Darmawan');
    }

    public function testRoleAdminRelationToUser()
    {
        $this->seed(UserRoleSeeder::class);

        $role = Role::query()->find('admin');
        $users = $role->users;
        self::assertNotNull($users);
        self::assertNotEmpty($users);
        Log::info(json_encode($users, JSON_PRETTY_PRINT));
    }

    public function testRoleSuperAdminRelationToUser()
    {
        $this->seed(UserRoleSeeder::class);

        $role = Role::query()->find('superadmin');
        $users = $role->users;
        self::assertNotNull($users);
        self::assertNotEmpty($users);
        Log::info(json_encode($users, JSON_PRETTY_PRINT));
    }

    public function testAdminRoleAttachment()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::query()->find('55000135');
        $admin = $user->isAdmin();
        self::assertFalse($admin);

        $user = $user->fresh();
        $user->roles()->attach('admin');
        $admin = $user->isAdmin();
        self::assertTrue($admin);
    }

    public function testSuperAdminRoleAttachment()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::query()->find('55000153');
        $superadmin = $user->isSuperAdmin();
        self::assertFalse($superadmin);

        $user = $user->fresh();
        $user->roles()->attach('superadmin');
        $superadmin = $user->isSuperAdmin();
        self::assertTrue($superadmin);
    }

    public function testAdminRoleDetachment()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::query()->find('55000153');
        $admin = $user->isAdmin();
        self::assertTrue($admin);

        $user = $user->fresh();
        $user->roles()->detach('admin');
        $admin = $user->isAdmin();
        self::assertFalse($admin);
    }

    public function testSuperAdminRoleDetachment()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::query()->find('55000154');
        $superadmin = $user->isSuperAdmin();
        self::assertTrue($superadmin);

        $user = $user->fresh();
        $user->roles()->detach('superadmin');
        $superadmin = $user->isSuperAdmin();
        self::assertFalse($superadmin);
    }

    public function testAdminAttachMany()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::query()->find('55000135');
        $admin = $user->isAdmin();
        self::assertFalse($admin);
        $superAdmin = $user->isSuperAdmin();
        self::assertFalse($superAdmin);

        $user->roles()->attach(['admin', 'superadmin']);
        $user = $user->fresh();

        $admin = $user->isAdmin();
        self::assertTrue($admin);
        $superAdmin = $user->isSuperAdmin();
        self::assertTrue($superAdmin);
    }

    public function testAdminDetachMany()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::query()->find('55000154');
        $admin = $user->isAdmin();
        self::assertTrue($admin);
        $superAdmin = $user->isSuperAdmin();
        self::assertTrue($superAdmin);

        $user->roles()->detach(['admin', 'superadmin']);
        $user = $user->fresh();

        $admin = $user->isAdmin();
        self::assertFalse($admin);
        $superAdmin = $user->isSuperAdmin();
        self::assertFalse($superAdmin);
    }

    public function testAttachFailed()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::query()->find('55000135');
        try {
            $user->roles()->attach('failed');
        } catch (Exception $error) {
            $error = $error->getMessage();
            self::assertTrue(Str::contains($error, 'Integrity constraint violation:'));
        }
    }
}
