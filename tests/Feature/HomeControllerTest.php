<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        $this->seed(DatabaseSeeder::class);

        $this->post('/search', [
            'equipment' => 'EMO000426'
        ])
            ->assertRedirectToRoute('login');
    }

    public function testSearchMemberMotor()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->post('/search', [
                'equipment' => 'EMO000426'
            ])
            ->assertRedirect('/checking-form/Fajar-MotorList1804');
    }

    public function testSearchMemberMotorNull()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->followingRedirects()
            ->post('/search', [
                'equipment' => null,
            ])
            ->assertSeeText('The submitted equipment is invalid.');
    }

    public function testSearchMemberMotorInvalid()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])->followingRedirects()
            ->post('/search', [
                'equipment' => 'EMO00426'
            ])
            ->assertSeeText('The submitted equipment is invalid.');
    }

    public function testSearchMemberTrafo()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->post('/search', [
                'equipment' => 'ETF000085'
            ])
            ->assertJson([
                'id' => 'id',
                'equipment' => 'ETF000085',
            ]);
    }
}
