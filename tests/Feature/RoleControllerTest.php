<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserRoleSeeder;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RoleControllerTest extends TestCase
{
    // ADMIN
    public function testDeleteAdminAsGuest()
    {
        $this->get('/role-delete/admin/55000153')
            ->assertRedirectToRoute('login');
    }

    public function testDeleteAdminEmployee()
    {
        $this->seed(UserRoleSeeder::class);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->get('/role-delete/admin/31100019')
            ->assertSeeText('You are not allowed to perform this operation!');
    }

    public function testDeleteAdminAsAdmin()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::findOrFail('31100019');
        $user->roles()->attach('admin');
        self::assertTrue($user->isAdmin());

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->get('/role-delete/admin/31100019')
            ->assertSeeText('You are not allowed to perform this operation!');
    }

    public function testDeleteAdminAsSuperAdmin()
    {
        $this->seed(UserRoleSeeder::class);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->get('/role-delete/admin/55000153')
            ->assertSeeText('User removed from admin.');
    }

    public function testDeleteSelfAdminAsSuperAdmin()
    {
        $this->seed(UserRoleSeeder::class);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->get('/role-delete/admin/55000154')
            ->assertSeeText('You cannot unassign yourself, this action causes an error.');
    }

    // SUPER ADMIN
    public function testDeleteSuperAdminAsGuest()
    {
        $this->get('/role-delete/superadmin/55000154')
            ->assertRedirectToRoute('login');
    }

    public function testDeleteSuperAdminEmployee()
    {
        $this->seed(UserRoleSeeder::class);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->get('/role-delete/superadmin/55000154')
            ->assertSeeText('You are not allowed to perform this operation!');
    }

    public function testDeleteSuperAdminAsAdmin()
    {
        $this->seed(UserRoleSeeder::class);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->get('/role-delete/superadmin/55000154')
            ->assertSeeText('You are not allowed to perform this operation!');
    }

    public function testDeleteSuperAdminTheCreatorAsSuperAdmin()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::findOrFail('55000153');
        $user->roles()->attach('superadmin');
        self::assertTrue($user->isSuperAdmin());

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->get('/role-delete/superadmin/55000154')
            ->assertSeeText('You cannot delete the creator.');
    }

    public function testDeleteSuperAdminAsSuperAdminSuccess()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::findOrFail('55000153');
        $user->roles()->attach('superadmin');
        self::assertTrue($user->isSuperAdmin());

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->get('/role-delete/superadmin/55000153')
            ->assertSeeText('User removed from super admin.');
    }

    public function testDeleteSelfSuperAdminAsSuperAdminSuccess()
    {
        $this->seed(UserRoleSeeder::class);

        $user = User::findOrFail('55000153');
        $user->roles()->attach('superadmin');
        self::assertTrue($user->isSuperAdmin());

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->get('/role-delete/superadmin/55000153')
            ->assertSeeText('You cannot unassign yourself, this action causes an error.');
    }
}
