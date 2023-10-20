<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    // ======= LOGIN =======
    public function testViewLogin(): void
    {
        $this->seed(UserSeeder::class);

        $registration = "Don't have an account ?, Register here";

        $this->view("user.login", [
            "title" => "Login"
        ])->assertSeeText("Login")
            ->assertSeeText("NIK")
            ->assertSeeText($registration);
    }

    public function testLogin(): void
    {
        $this->seed(UserSeeder::class);

        $this->get("/login", [
            "title" => "Login"
        ])->assertSeeText("Login")
            ->assertSeeText("NIK")
            ->assertSeeText("Don't have an account ?, Register here");
    }

    public function testDoLoginEmpty()
    {
        $this->seed(UserSeeder::class);

        $this->post("/login", [])
            ->assertSeeText("NIK and password is required!");
    }

    public function testDoLoginWrongPassword()
    {
        $this->seed(UserSeeder::class);

        $this->post("/login", [
            "NIK" => "55000154",
            "password" => "salah"
        ])
            ->assertSeeText("NIK or password is wrong!");
    }

    public function testDoLoginSuccess()
    {
        $this->seed(UserSeeder::class);

        $this->post("/login", [
            "NIK" => "55000154",
            "password" => "1234"
        ])
            ->assertRedirect("/")
            ->assertStatus(302);
    }

    public function testGetHomeAlreadyLogin()
    {
        $this->withSession([
            "user" => "Doni Darmawan",
            "nik" => "55000154"
        ])->get("/")
            ->assertSeeText("Scan QR Code")
            ->assertSeeText("Fajar E-Maintenance");
    }

    public function testGetHomeLoginNotYet()
    {
        $this->get("/", [])
            ->assertRedirect("/login");
    }

    // ======= REGISTRATION =======
    public function testViewRegistration()
    {
        $this->view("user.registration", [
            "title" => "Registration"
        ])
            ->assertSeeText("Registration");
    }

    public function testRegisterEmpty()
    {
        $this->post('/registration', [])
            ->assertSeeText("All data is required!");
    }

    public function testRegisterNikDuplicate()
    {
        $this->seed(UserSeeder::class);

        $this->post('/registration', [
            "nik" => "55000154",
            "password" => "1234",
            "fullname" => "Doni Darmawan",
            "department" => "EI2",
            "phone_number" => "08983456945",
        ])
            ->assertSeeText("NIK is used!");
    }

    public function testRegistrationSuccess()
    {

        $this->post('/registration', [
            "nik" => "55000155",
            "password" => "1234",
            "fullname" => "Doni Darmawan",
            "department" => "EI2",
            "phone_number" => "08983456945",
        ])
            ->assertSeeText("Login")
            ->assertSeeText("Registration Success!");
    }

    // ======= LOGOUT =======
    public function testLogout()
    {
        $this->get("/logout")
            ->assertRedirect("/login")
            ->assertStatus(302);
    }
}
