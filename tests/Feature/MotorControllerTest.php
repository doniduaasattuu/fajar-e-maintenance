<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MotorControllerTest extends TestCase
{
    public function testGetMotorsGuest()
    {
        $this->get('/motors')
            ->assertRedirect('/login');
    }

    public function testGetMotorsEmployee()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])
            ->get('/motors')
            ->assertSeeText('Table motor')
            ->assertSeeText('New motor')
            ->assertSeeText('Filter')
            ->assertSeeText('The total registered motor is 22 records.')
            ->assertSeeText('Trend')
            ->assertSeeText('Edit')
            ->assertSeeText('MGM000481');
    }

    public function testGetMotorsAuthorized()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/motors')
            ->assertSeeText('Table motor')
            ->assertSeeText('New motor')
            ->assertSeeText('Filter')
            ->assertSeeText('The total registered motor is 22 records.')
            ->assertSeeText('Trend')
            ->assertSeeText('Edit')
            ->assertSeeText('MGM000481');
    }

    public function testGetMotorsAuthorizedEmptyDb()
    {
        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/motors')
            ->assertSeeText('Table motor')
            ->assertSeeText('New motor')
            ->assertSeeText('Filter')
            ->assertSeeText('The total registered motor is 0 records.')
            ->assertSeeText('Trend')
            ->assertSeeText('Edit')
            ->assertDontSeeText('MGM000481');
    }
}
