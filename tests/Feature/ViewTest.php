<?php

namespace Tests\Feature;

use App\Services\UserService;
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
            ->assertSeeText('Full Name')
            ->assertSeeText('Department')
            ->assertSeeText('EI1')
            ->assertSeeText('EI2')
            ->assertSeeText('EI3')
            ->assertSeeText('EI4')
            ->assertSeeText('EI5')
            ->assertSeeText('EI6')
            ->assertSeeText('EI7')
            ->assertSeeText('Phone Number')
            ->assertSeeText('Registration Code')
            ->assertSeeText('Sign Up')
            ->assertSeeText('Already have an account ?');
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
            ->assertSeeText("Don't have an account ?");
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
}
