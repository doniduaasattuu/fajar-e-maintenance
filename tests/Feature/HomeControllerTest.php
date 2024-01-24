<?php

namespace Tests\Feature;

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
}
