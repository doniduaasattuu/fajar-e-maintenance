<?php

namespace Tests\Feature;

use App\Models\Funcloc;
use App\Models\MotorRecord;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\DailyRecordSeeder;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\MotorSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\TrafoSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PdfControllerTest extends TestCase
{
    public function testGetDailyActivityReportPageGuest()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DailyRecordSeeder::class]);

        $this->get('/report')
            ->assertRedirectToRoute('login');
    }

    public function testGetDailyActivityReportPageEmployee()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DailyRecordSeeder::class]);

        $this->withSession([
            'nik' => '55000153',
            'user' => 'Jamal Mirdad'
        ])
            ->get('/report')
            ->assertSeeText('Daily activity report')
            ->assertSeeText('Equipment')
            ->assertSee('Motor')
            ->assertSee('Trafo')
            ->assertSee('Date')
            ->assertSee('Generate');
    }

    public function testPostDailyReportPdfGuest()
    {
        $this
            ->post('/report')
            ->assertRedirectToRoute('login');
    }
}
