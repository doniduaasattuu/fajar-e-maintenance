<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Database\Seeders\DailyRecordSeeder;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\MotorSeeder;
use Database\Seeders\TrafoSeeder;
use Database\Seeders\UserRoleSeeder;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ReportControllerTest extends TestCase
{
    public function testDailyReportFailedGuest()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->get('/report');
        $this->post('/report', [
            'table' => 'motors',
            'date' => Carbon::now()->toDateString(),
        ])
            ->assertRedirectToRoute('login');
    }

    public function testDailyReportFailedEmptyRecordsEmployee()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia',
        ]);

        $this->get('/report');

        $this
            ->followingRedirects()
            ->post('/report', [
                'table' => 'motors',
                'date' => Carbon::now()->toDateString(),
            ])
            ->assertSeeText('[404] Not found')
            ->assertSeeText('No records found.');
    }

    public function testDailyReportFailedSuccessEmployee()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DailyRecordSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia',
        ]);

        $this->get('/report');

        $this
            ->post('/report', [
                'table' => 'motors',
                'date' => Carbon::now()->toDateString(),
            ])
            ->assertRedirectContains('/pdf');
    }
}
