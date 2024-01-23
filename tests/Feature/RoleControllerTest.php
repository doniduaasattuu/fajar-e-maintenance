<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleControllerTest extends TestCase
{
    // DELETE DB ADMIN
    public function testDeleteDbAdminGuest()
    {
        $this->get('/role-delete/db_admin/55000153')
            ->assertRedirectToRoute('login');
    }

    public function testDeleteDbAdminEmployee()
    {
        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])->followingRedirects()
            ->get('/role-delete/db_admin/55000153')
            ->assertSeeText('You are not allowed to perform this operation!.');
    }

    public function testDeleteDbAdminAuthorized()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->followingRedirects()
            ->get('/role-delete/db_admin/31811016')
            ->assertSeeText('User deleted from database administrator.');
    }

    public function testDeleteDbAdminAuthorizedTheCreator()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->followingRedirects()
            ->get('/role-delete/db_admin/55000154')
            ->assertSeeText('You cannot delete the creator!.');
    }

    // ASSIGN DB ADMIN
    public function testAssignDbAdminGuest()
    {
        $this->get('/role-assign/db_admin/55000153')
            ->assertRedirectToRoute('login');
    }

    public function testAssignDbAdminEmployee()
    {
        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])->followingRedirects()
            ->get('/role-assign/db_admin/55000153')
            ->assertSeeText('You are not allowed to perform this operation!.');
    }

    public function testAssignDbAdminAuthorized()
    {
        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->followingRedirects()
            ->get('/role-assign/db_admin/31903007')
            ->assertSeeText('User assigned as database administrator.');
    }

    // DELETE ADMIN
    public function testDeleteAdminGuest()
    {
        $this->get('/role-delete/admin/55000153')
            ->assertRedirectToRoute('login');
    }

    public function testDeleteAdminEmployee()
    {
        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])->followingRedirects()
            ->get('/role-delete/admin/55000153')
            ->assertSeeText('You are not allowed to perform this operation!.');
    }

    public function testDeleteAdminAuthorized()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->followingRedirects()
            ->get('/role-delete/admin/31811016')
            ->assertSeeText('User deleted from administrator.');
    }

    public function testDeleteAdminAuthorizedTheCreator()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->followingRedirects()
            ->get('/role-delete/admin/55000154')
            ->assertSeeText('You cannot delete the creator!.');
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
