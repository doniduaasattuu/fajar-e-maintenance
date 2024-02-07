<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\FindingSeeder;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\MotorRecordSeeder;
use Database\Seeders\MotorSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TrendControllerTest extends TestCase
{
    public function testGetTrendsGuest()
    {
        $this->get('/trends')
            ->assertRedirectToRoute('login');
    }

    public function testGetTrendsEmployee()
    {
        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])
            ->get('/trends')
            ->assertSeeText('Trends')
            ->assertSeeText('Equipment')
            ->assertSeeText('Start date')
            ->assertSeeText('The default date is one year from today.')
            ->assertSeeText('End date')
            ->assertSeeText('The default date is tomorrow.')
            ->assertSeeText('Submit');
    }

    public function testGetTrendsAuthorized()
    {
        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->get('/trends')
            ->assertSeeText('Trends')
            ->assertSeeText('Equipment')
            ->assertSeeText('Start date')
            ->assertSeeText('The default date is one year from today.')
            ->assertSeeText('End date')
            ->assertSeeText('The default date is tomorrow.')
            ->assertSeeText('Submit');
    }

    // POST
    public function testGetTrendsSuccess()
    {
        $this->seed(FindingSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->followingRedirects()
            ->post('/trends', [
                'equipment' => 'MGM000481',
                'start_date' => Carbon::now()->addYears(-1)->addDays(-1),
                'end_date' => Carbon::now()->addDays(1),
            ])
            ->assertSeeText('Temperature of MGM000481')
            ->assertSeeText('Vibration DE of MGM000481')
            ->assertSeeText('Greasing record of MGM000481')
            ->assertSeeText('Findings of MGM000481')
            ->assertSeeText('The top one is the newest.');
    }

    public function testGetTrendsFailedEquipmentNull()
    {
        $this->seed(FindingSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->followingRedirects()
            ->post('/trends', [
                'equipment' => null,
                'start_date' => Carbon::now()->addYears(-1)->addDays(-1),
                'end_date' => Carbon::now()->addDays(1),
            ])
            ->assertSeeText('The equipment field is required.');
    }

    public function testGetTrendsSuccessStartDateNull()
    {
        $this->seed(FindingSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->followingRedirects()
            ->post('/trends', [
                'equipment' => 'MGM000481',
                'start_date' => null,
                'end_date' => Carbon::now()->addDays(1),
            ])
            ->assertSeeText('Temperature of MGM000481')
            ->assertSeeText('Vibration DE of MGM000481')
            ->assertSeeText('Greasing record of MGM000481')
            ->assertSeeText('Findings of MGM000481')
            ->assertSeeText('The top one is the newest.');
    }

    public function testGetTrendsSuccessStartDateInvalidDate()
    {
        $this->seed(FindingSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->followingRedirects()
            ->post('/trends', [
                'equipment' => 'MGM000481',
                'start_date' => Carbon::now()->addDays(1),
                'end_date' => Carbon::now()->addDays(1),
            ])
            ->assertSeeText('The start date field must be a date before now.');
    }

    public function testGetTrendsSuccessEndDateNull()
    {
        $this->seed(FindingSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->followingRedirects()
            ->post('/trends', [
                'equipment' => 'MGM000481',
                'start_date' => Carbon::now()->addYears(-1)->addDays(-1),
                'end_date' => null,
            ])
            ->assertSeeText('Temperature of MGM000481')
            ->assertSeeText('Vibration DE of MGM000481')
            ->assertSeeText('Greasing record of MGM000481')
            ->assertSeeText('Findings of MGM000481')
            ->assertSeeText('The top one is the newest.');
    }

    public function testGetTrendsSuccessEndDateInvalidDate()
    {
        $this->seed(FindingSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->followingRedirects()
            ->post('/trends', [
                'equipment' => 'MGM000481',
                'start_date' => Carbon::now()->addDays(-5),
                'end_date' => Carbon::now()->addDays(-7),
            ])
            ->assertSeeText('The end date field must be a date after start date.');
    }

    public function testGetTrendsSuccessStartDateNullEndDateNull()
    {
        $this->seed(FindingSeeder::class);

        $this->withSession([
            'nik' => '55000154',
            'user' => 'Doni Darmawan'
        ])
            ->followingRedirects()
            ->post('/trends', [
                'equipment' => 'MGM000481',
                'start_date' => null,
                'end_date' => null,
            ])
            ->assertSeeText('Temperature of MGM000481')
            ->assertSeeText('Vibration DE of MGM000481')
            ->assertSeeText('Greasing record of MGM000481')
            ->assertSeeText('Findings of MGM000481')
            ->assertSeeText('The top one is the newest.');
    }
}
