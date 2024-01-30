<?php

namespace Tests\Feature;

use App\Models\TrafoDetails;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\TrafoDetailsSeeder;
use Database\Seeders\TrafoSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TrafoControllerTest extends TestCase
{
    public function testGetTrafosGuest()
    {
        $this->get('/trafos')
            ->assertRedirectToRoute('login');
    }

    public function testGetTrafosEmployee()
    {
        $this->seed([FunclocSeeder::class]);

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])
            ->get('/trafos')
            ->assertSeeText('Table trafo')
            ->assertSeeText('New trafo')
            ->assertSeeText('Filter')
            ->assertSeeText('The total registered trafo is 11 records.')
            ->assertSeeText('Trend')
            ->assertSeeText('Edit')
            ->assertSeeText('ETF001234');
    }

    public function testGetTrafosAuthorized()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafos')
            ->assertSeeText('Table trafo')
            ->assertSeeText('New trafo')
            ->assertSeeText('Filter')
            ->assertSeeText('The total registered trafo is 11 records.')
            ->assertSeeText('Trend')
            ->assertSeeText('Edit')
            ->assertSeeText('ETF001234');
    }

    public function testGetTrafosAuthorizedEmptyDb()
    {
        $this->seed([FunclocSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trafos')
            ->assertSeeText('Table trafo')
            ->assertSeeText('New trafo')
            ->assertSeeText('Filter')
            ->assertSeeText('The total registered trafo is 0 records.')
            ->assertSeeText('Trend')
            ->assertSeeText('Edit')
            ->assertDontSeeText('ETF001234');
    }
}
