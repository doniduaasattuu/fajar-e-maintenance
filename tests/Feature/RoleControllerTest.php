<?php

namespace Tests\Feature;

use Database\Seeders\RoleSeeder;
use Database\Seeders\UserRoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RoleControllerTest extends TestCase
{

    public function testDeleteAdminGuest()
    {
        $this->get('/role-delete/admin/55000153')
            ->assertRedirectToRoute('login');
    }

    public function testDeleteAdminEmployee()
    {
        $this->seed(UserRoleSeeder::class);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->get('/role-delete/admin/31100019')
            ->assertSeeText('You are not allowed to perform this operation!');
    }

    public function testDeleteAdminAuthorized()
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

    public function testDeleteAdminAuthorizedTheCreator()
    {
        $this->markTestIncomplete('revisited');

        $this->seed([UserSeeder::class, RoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->get('/role-delete/admin/55000154')
            ->assertSeeText('You cannot unassign yourself, this action causes an error.');
    }

    // ASSIGN DB ADMIN
    public function testAssignAdminGuest()
    {
        $this->get('/role-assign/admin/55000153')
            ->assertRedirectToRoute('login');
    }

    public function testAssignAdminEmployee()
    {
        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])->followingRedirects()
            ->get('/role-assign/admin/55000153')
            ->assertSeeText('You are not allowed to perform this operation!.');
    }

    public function testAssignAdminAuthorized()
    {
        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->followingRedirects()
            ->get('/role-assign/admin/31903007')
            ->assertSeeText('User assigned as database administrator.');
    }
}
