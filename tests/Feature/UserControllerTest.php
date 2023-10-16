<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{

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
}
