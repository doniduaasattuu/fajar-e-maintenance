<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserRoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testUserRelationToRole()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::query()->find('55000154');
        $roles = $user->roles;
        self::assertNotNull($roles);
        self::assertNotEmpty($roles);
        self::assertCount(2, $roles);
    }

    public function testUserIsAdminTrue()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::query()->find('55000153');
        self::assertTrue($user->isAdmin());
    }

    public function testUserIsAdminFalse()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::query()->find('55000135');
        self::assertFalse($user->isAdmin());
    }

    public function testUserIsSuperAdminTrue()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::query()->find('55000154');

        $superAdmin = $user->isSuperAdmin();
        self::assertTrue($superAdmin);
    }

    public function testUserIsSuperAdminFalse()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::query()->find('55000153');
        $superAdmin = $user->isSuperAdmin();
        self::assertFalse($superAdmin);
    }

    public function testAuthUserIsAdminTrue()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::query()->find('55000153');
        Auth::login($user);
        $user = $user->fresh();
        self::assertTrue($user->isAdmin());
    }

    public function testAuthUserIsAdminFalse()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::query()->find('55000135');
        Auth::login($user);
        $user = $user->fresh();
        self::assertFalse($user->isAdmin());
    }

    public function testAuthUserIsSuperAdminTrue()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::query()->find('55000154');
        Auth::login($user);
        $user = $user->fresh();
        self::assertTrue($user->isSuperAdmin());
    }

    public function testAuthUserIsSuperAdminFalse()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::query()->find('55000153');
        Auth::login($user);
        $user = $user->fresh();
        self::assertFalse($user->isSuperAdmin());
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

    public function testprintedNameDouble()
    {
        $this->seed(UserSeeder::class);

        $user = User::query()->find('55000154');
        self::assertNotNull($user->printed_name);
        self::assertEquals('Doni', $user->printed_name);
    }

    public function testprintedNameSingle()
    {
        $this->seed(UserSeeder::class);

        $user = User::query()->find('55000092');
        self::assertNotNull($user->printed_name);
        self::assertEquals('R. Much', $user->printed_name);
    }

    public function testAuthUser()
    {
        User::create([
            'nik' => "55000154",
            'password' => bcrypt("rahasia"),
            'fullname' => "Doni Darmawan",
            'department' => "EI2",
            'phone_number' => "08983456945",
        ]);

        $user = Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ], true);

        self::assertTrue($user);
        self::assertTrue(Auth::check());
        self::assertEquals(Auth::user()->department, 'EI2');
    }

    public function testUserRoles()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::query()->find('55000154');
        $roles = $user->roles;

        $user = User::query()->find('55000135');
        $roles = $user->roles;
        self::assertEmpty($roles);
    }

    public function testUserIsAdmin()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::query()->find('55000154');
        self::assertNotNull($user);
        self::assertTrue($user->isAdmin());

        $user = User::query()->find('55000135');
        self::assertNotNull($user);
        self::assertFalse($user->isAdmin());
    }

    public function testUserAssignAsAdmin()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class]);

        $user = User::query()->find('55000154');
        self::assertFalse($user->isAdmin());

        $user = $user->fresh();
        $user->roles()->attach('admin');
        self::assertTrue($user->isAdmin());
    }

    public function testUserAssignAsSuperAdmin()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class]);

        $user = User::query()->find('55000154');
        self::assertFalse($user->isSuperAdmin());

        $user = $user->fresh();
        $user->roles()->attach('superadmin');
        self::assertTrue($user->isSuperAdmin());
    }

    public function testUserRemoveFromAdmin()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::query()->find('55000153');
        self::assertTrue($user->isAdmin());

        $user->roles()->detach('admin');
        $user = $user->fresh();
        self::assertFalse($user->isAdmin());
    }

    public function testUserRemoveFromSuperAdmin()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::query()->find('55000154');
        self::assertTrue($user->isSuperAdmin());

        $user->roles()->detach('superadmin');
        $user = $user->fresh();
        self::assertFalse($user->isSuperAdmin());
    }
}
