<?php

namespace Tests\Feature;

use Database\Seeders\DailyRecordSeeder;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\MotorSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\TrafoSeeder;
use Database\Seeders\UserRoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PdfControllerTest extends TestCase
{
    public function testGetDailyActivityReportPageGuest()
    {
        $this->get('/report')
            ->assertRedirectToRoute('login');
    }

    public function testGetDailyActivityReportPageEmployee()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DailyRecordSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia',
        ]);

        $this
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
