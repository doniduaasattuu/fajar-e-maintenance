<?php

namespace Tests\Feature;

use Database\Seeders\FunclocSeeder;
use Database\Seeders\MotorSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\TrafoSeeder;
use Database\Seeders\UserSeeder;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    // HOME
    public function testGetHomeGuest()
    {
        $this->get('/')
            ->assertRedirectToRoute('login');
    }

    public function testGetHomeEmployee()
    {
        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad',
        ])
            ->get('/')
            ->assertSeeText('We make daily inspection checks easier.');
    }

    public function testGetHomeAuthorized()
    {
        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan',
        ])
            ->get('/')
            ->assertSeeText('We make daily inspection checks easier.');
    }

    // SCANNER
    public function testGetScannerGuest()
    {
        $this->get('/scanner')
            ->assertRedirectToRoute('login');
    }

    public function testGetScannerEmployee()
    {
        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad',
        ])
            ->get('/scanner')
            ->assertSeeText('Request Camera Permissions');
    }

    public function testGetScannerAuthorized()
    {
        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan',
        ])
            ->get('/scanner')
            ->assertSeeText('Request Camera Permissions');
    }

    public function testSearchGuestMotor()
    {
        $this->seed(UserSeeder::class);

        $this->post('/search', [
            'search_equipment' => 'EMO000426'
        ])
            ->assertRedirectToRoute('login');
    }

    public function testSearchMemberMotor()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->post('/search', [
                'search_equipment' => 'EMO000426'
            ])
            ->assertRedirect('/checking-form/Fajar-MotorList1804');
    }

    public function testSearchMemberMotorNull()
    {
        $this->seed(UserSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->followingRedirects()
            ->post('/search', [
                'search_equipment' => null,
            ])
            ->assertSeeText('The submitted value is invalid');
    }

    public function testSearchMemberMotorInvalid()
    {
        $this->seed(UserSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->followingRedirects()
            ->post('/search', [
                'search_equipment' => 'EMO00426'
            ])
            ->assertSeeText('The submitted value is invalid');
    }

    // SEARCH BY UNIQUE ID
    public function testSearchMotorUniqueIdNotFoundAuthorized()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->followingRedirects()
            ->post('/search', [
                'search_equipment' => 'MOTOR876'
            ])
            ->assertSeeText('The submitted unique id 876 was not found.');
    }

    public function testSearchMotorUniqueIdNotFoundEmployee()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])->followingRedirects()
            ->post('/search', [
                'search_equipment' => 'MOTOR876'
            ])
            ->assertSeeText('The submitted unique id 876 was not found.');
    }

    public function testSearchTrafoUniqueIdNotFoundAuthorized()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->followingRedirects()
            ->post('/search', [
                'search_equipment' => 'TRAFO876'
            ])
            ->assertSeeText('The submitted unique id 876 was not found.');
    }

    public function testSearchTrafoUniqueIdNotFoundEmployee()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])->followingRedirects()
            ->post('/search', [
                'search_equipment' => 'TRAFO876'
            ])
            ->assertSeeText('The submitted unique id 876 was not found.');
    }

    public function testSearchMotorUniqueIdSuccessAuthorized()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->post('/search', [
                'search_equipment' => 'MOTOR580'
            ])
            ->assertRedirect('/motor-edit/EMO000042')
            ->assertDontSeeText('The submitted unique id 580 was not found.');
    }

    public function testSearchMotorUniqueIdSuccessEmployee()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])
            ->post('/search', [
                'search_equipment' => 'MOTOR580'
            ])
            ->assertRedirect('/motor-details/EMO000042')
            ->assertDontSeeText('The submitted unique id 580 was not found.');
    }

    public function testSearchTrafoUniqueIdSuccessAuthorized()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->post('/search', [
                'search_equipment' => 'TRAfo10'
            ])
            ->assertRedirect('/trafo-edit/ETF000091')
            ->assertDontSeeText('The submitted unique id 10 was not found.');
    }

    public function testSearchTrafoUniqueIdSuccessEmployee()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])
            ->post('/search', [
                'search_equipment' => 'TRAfo10'
            ])
            ->assertRedirect('/trafo-details/ETF000091')
            ->assertDontSeeText('The submitted unique id 10 was not found.');
    }
}
