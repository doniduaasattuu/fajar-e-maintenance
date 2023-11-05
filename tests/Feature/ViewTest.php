<?php

namespace Tests\Feature;

use App\Models\Emo;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    public function testViewScanner()
    {
        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])
            ->view("maintenance.scanner", [
                "title" => "Scanner"
            ])
            ->assertSee("reader")
            ->assertSee("https://unpkg.com/html5-qrcode")
            ->assertSee("html5QrcodeScanner");
    }

    public function testViewTrendsPicker()
    {
        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])
            ->view("maintenance.trends-picker", [
                "title" => "Trends picker",
                "header" => "Equipment trend"
            ])
            ->assertSeeText("Start Date");
    }

    public function testViewSummary()
    {
        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])
            ->view("maintenance.summary", [
                "title" => "Trends picker",
                "header" => "Equipment trend",
                "PM1_TEMP_DE" => [],
                "PM1_TEMP_NDE" => [],
                "PM1_VIBRATION_DE" => [],
                "PM1_VIBRATION_NDE" => [],
                "PM2_TEMP_DE" => [],
                "PM2_TEMP_NDE" => [],
                "PM2_VIBRATION_DE" => [],
                "PM2_VIBRATION_NDE" => [],
                "PM3_TEMP_DE" => [],
                "PM3_TEMP_NDE" => [],
                "PM3_VIBRATION_DE" => [],
                "PM3_VIBRATION_NDE" => [],
                "PM5_TEMP_DE" => [],
                "PM5_TEMP_NDE" => [],
                "PM5_VIBRATION_DE" => [],
                "PM5_VIBRATION_NDE" => [],
                "PM7_TEMP_DE" => [],
                "PM7_TEMP_NDE" => [],
                "PM7_VIBRATION_DE" => [],
                "PM7_VIBRATION_NDE" => [],
                "PM8_TEMP_DE" => [],
                "PM8_TEMP_NDE" => [],
                "PM8_VIBRATION_DE" => [],
                "PM8_VIBRATION_NDE" => [],
                "WWT_TEMP_DE" => [],
                "WWT_TEMP_NDE" => [],
                "WWT_VIBRATION_DE" => [],
                "WWT_VIBRATION_NDE" => [],
                "ENC_TEMP_DE" => [],
                "ENC_TEMP_NDE" => [],
                "ENC_VIBRATION_DE" => [],
                "ENC_VIBRATION_NDE" => [],
            ])
            ->assertSeeText("Summary of all checking data from each Paper Machine");
    }

    public function testViewChangeName()
    {
        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])
            ->view("user.change-name", [
                "title" => "Change name"
            ])
            ->assertSeeText("Change name")
            ->assertSeeText("Your NIK")
            ->assertSeeText("Password")
            ->assertSeeText("New Fullname")
            ->assertSeeText("Want to change your password ?");
    }

    public function testViewChangePassword()
    {
        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])
            ->view("user.change-password", [
                "title" => "Change password"
            ])
            ->assertSeeText("Change password")
            ->assertSeeText("Your NIK")
            ->assertSeeText("Current Password")
            ->assertSeeText("New Password")
            ->assertSeeText("Confirm New Password")
            ->assertSeeText("Want to change your name ?");
    }

    public function testViewLogin()
    {
        $this->view("user.login", [
            "title" => "Login"
        ])
            ->assertSeeText("Login")
            ->assertSeeText("NIK")
            ->assertSeeText("Password")
            ->assertSeeText("Sign In")
            ->assertSeeText("Register here");
    }

    public function testViewRegistration()
    {
        $this->view("user.registration", [
            "title" => "Registration"
        ])
            ->assertSeeText("Registration")
            ->assertSeeText("NIK")
            ->assertSeeText("Password")
            ->assertSeeText("Full Name")
            ->assertSeeText("Department")
            ->assertSeeText("Phone Number")
            ->assertSeeText("Sign Up")
            ->assertSeeText("Sign in here");
    }

    public function testViewSearchEquipment()
    {
        $this->view("maintenance.search-equipment", [
            "title" => "Search Equipment"
        ])
            ->assertSeeText("Equipment")
            ->assertSeeText("Look for the equipment you want to update.")
            ->assertSeeText("Search");
    }

    public function testViewEditEquipment()
    {
        $this->seed(DatabaseSeeder::class);

        $emo = Emo::query()->with("emoDetails")->find("EMO000426");

        $this->view("maintenance.edit-equipment", [
            "title" => "Edit Equipment",
            "emo" => $emo->toArray(),
        ])
            ->assertSeeText("EMO000426")
            ->assertSeeText("Funcloc")
            ->assertSeeText("Equipment description")
            ->assertSeeText("Manufacture")
            ->assertSeeText("Power rate")
            ->assertSeeText("Bearing de")
            ->assertSeeText("Efficiency")
            ->assertSeeText("Greasing type")
            ->assertSeeText("Mounting")
            ->assertSeeText("Save");
    }
}
