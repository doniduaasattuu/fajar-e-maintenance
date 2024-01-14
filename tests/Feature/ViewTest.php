<?php

namespace Tests\Feature;

use App\Models\Funcloc;
use App\Services\FunclocService;
use App\Services\UserService;
use Database\Seeders\FunclocSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    public function testViewRegistration()
    {
        $this->view('user.registration', [
            'title' => 'Registration',
            'userService' => $this->app->make(UserService::class)
        ])
            ->assertSeeText('Registration')
            ->assertSeeText('NIK')
            ->assertSeeText('Password')
            ->assertSeeText('Full name')
            ->assertSeeText('Department')
            ->assertSeeText('EI1')
            ->assertSeeText('EI2')
            ->assertSeeText('EI3')
            ->assertSeeText('EI4')
            ->assertSeeText('EI5')
            ->assertSeeText('EI6')
            ->assertSeeText('EI7')
            ->assertSeeText('Phone number')
            ->assertSeeText('Registration code')
            ->assertSeeText('Sign Up')
            ->assertSeeText('Already have an account ?, Sign in here');
    }

    public function testViewLogin()
    {
        $this->view('user.login', [
            'title' => 'Login'
        ])
            ->assertSeeText('Login')
            ->assertSeeText('NIK')
            ->assertSeeText('Password')
            ->assertSeeText('Sign In')
            ->assertSeeText("Don't have an account ?, Register here");
    }

    public function testViewHome()
    {
        $this->view('maintenance.home', [
            'title' => 'Fajar E-Maintenance'
        ])
            ->assertSeeText('Fajar E-Maintenance')
            ->assertSeeText('We make daily inspection checks easier')
            ->assertSeeText('Scan QR Code')
            ->assertSeeText('Search');
    }

    public function testViewFuncloc()
    {
        $this->seed(FunclocSeeder::class);

        $this->view('maintenance.funcloc.funcloc', [
            'title' => 'Table funcloc',
            'funclocService' => $this->app->make(FunclocService::class),
        ])
            ->assertSeeText('Table funcloc')
            ->assertSeeText('Filter')
            ->assertSeeText('The total registered funcloc is 11 records.')
            ->assertSeeText('Description')
            ->assertSeeText('Updated at')
            ->assertSeeText('Edit')
            ->assertSeeText('SP5.M-21/M');
    }
}
