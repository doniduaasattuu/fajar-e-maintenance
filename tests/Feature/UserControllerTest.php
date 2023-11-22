<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    // ======= LOGIN =======
    public function testGetLogin(): void
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

    public function testGetHomeNotYetLogin()
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
            ->assertSeeText("All field is required!");
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
            "registration_code" => "RG9uaSBEYXJtYXdhbg==",
        ])
            ->assertSeeText("NIK is used!");
    }

    public function testRegistrationSuccess()
    {
        DB::table('users')->delete();

        $this->post('/registration', [
            "nik" => "55000155",
            "password" => "1234",
            "fullname" => "Doni Darmawan",
            "department" => "EI2",
            "phone_number" => "08983456945",
            "registration_code" => "RG9uaSBEYXJtYXdhbg==",
        ])
            ->assertSeeText("Login")
            ->assertSeeText("Registration Success!");
    }

    public function testRegistrationCodeIsWrong()
    {
        DB::table('users')->delete();

        $this->post('/registration', [
            "nik" => "55000155",
            "password" => "1234",
            "fullname" => "Doni Darmawan",
            "department" => "EI2",
            "phone_number" => "08983456945",
            "registration_code" => "salah",
        ])
            ->assertSeeText("Registration Code is wrong!");
    }

    public function testRegisterNikDuplicateAndRegistrationCodeIsWrong()
    {
        $this->seed(UserSeeder::class);

        $this->post('/registration', [
            "nik" => "55000154",
            "password" => "1234",
            "fullname" => "Doni Darmawan",
            "department" => "EI2",
            "phone_number" => "08983456945",
            "registration_code" => "salah",
        ])
            ->assertSeeText("Registration Code is wrong!");
    }

    // ======= LOGOUT =======
    public function testLogout()
    {
        $this->get("/logout")
            ->assertRedirect("/login")
            ->assertStatus(302);
    }

    // CHANGE NAME
    public function testGetChangeName()
    {
        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])->get("/change-name")
            ->assertSeeText("Change name");
    }

    public function testDoChangeNameEmpty()
    {
        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])->post("/change-name", [])
            ->assertSeeText("All field is required!");
    }

    public function testDoChangeNameWrongNik()
    {
        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])->post("/change-name", [
            "nik" => "55000152",
            "password" => "1234",
            "name" => "Doni Baru"
        ])
            ->assertSeeText("NIK or password is wrong!");
    }

    public function testDoChangeNameWrongPassword()
    {
        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])->post("/change-name", [
            "nik" => "55000154",
            "password" => "salah",
            "name" => "Doni Baru"
        ])
            ->assertSeeText("NIK or password is wrong!");
    }

    public function testDoChangeNameSuccess()
    {

        $this->seed(UserSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])->post("/change-name", [
            "nik" => "55000154",
            "password" => "1234",
            "name" => "Doni Darmawan"
        ])
            ->assertStatus(302)
            ->assertRedirect("/");
    }

    // CHANGE PASSWORD
    public function testGetChangePassword()
    {
        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])->get("/change-password")
            ->assertSeeText("Change password");
    }

    public function testDoChangePasswordEmpty()
    {
        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])->post("/change-password", [])
            ->assertSeeText("All field is required!");
    }

    public function testDoChangePasswordWrongNik()
    {
        $this->seed(UserSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])->post("/change-password", [
            "nik" => "55000152",
            "current_password" => "1234",
            "new_password" => "Password baru",
            "confirm_new_password" => "Password baru"
        ])
            ->assertSeeText("NIK or password is wrong!");
    }

    public function testDoChangePasswordWrongPassword()
    {
        $this->seed(UserSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])->post("/change-password", [
            "nik" => "55000154",
            "current_password" => "salah",
            "new_password" => "Password baru",
            "confirm_new_password" => "Password baru"
        ])
            ->assertSeeText("NIK or password is wrong!");
    }

    public function testDoChangePasswordPasswordNotMatch()
    {
        $this->seed(UserSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])->post("/change-password", [
            "nik" => "55000154",
            "current_password" => "1234",
            "new_password" => "Password baru",
            "confirm_new_password" => "Password lama"
        ])
            ->assertSeeText("Password is not match!");
    }

    public function testGetNIK()
    {
        $this->seed(UserSeeder::class);

        $nik = User::query()->select("nik")->get();
        $randomNIK = $nik[rand(0, sizeof($nik) - 1)];

        self::assertNotNull($nik);
        self::assertNotNull($randomNIK->nik);
        Log::info(json_encode($randomNIK->nik, JSON_PRETTY_PRINT));
    }
}
