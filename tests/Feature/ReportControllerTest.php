<?php

namespace Tests\Feature;

use App\Models\Funcloc;
use App\Models\MotorRecord;
use Carbon\Carbon;
use Database\Seeders\DailyRecordSeeder;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\MotorRecordSeeder;
use Database\Seeders\MotorSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\TrafoRecordSeeder;
use Database\Seeders\TrafoSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReportControllerTest extends TestCase
{
    public function testDailyReportFailedGuest()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->get('/report');
        $this->post('/report', [
            'table' => 'motors',
            'date' => Carbon::now()->toDateString(),
        ])
            ->assertRedirectToRoute('login');
    }

    public function testDailyReportFailedEmptyRecordsEmployee()
    {
        // $this->seed([UserSeeder::class, RoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class]);

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])->get('/report');

        $this
            ->followingRedirects()
            ->post('/report', [
                'table' => 'motors',
                'date' => Carbon::now()->toDateString(),
            ])
            ->assertSeeText('[404] Not found.')
            ->assertSeeText('No records found.');
    }

    public function testDailyReportFailedSuccessEmployee()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DailyRecordSeeder::class]);

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])->get('/report');

        $this
            ->post('/report', [
                'table' => 'motors',
                'date' => Carbon::now()->toDateString(),
            ])
            ->assertRedirectContains('/pdf');
    }
}
