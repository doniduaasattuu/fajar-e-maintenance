<?php

namespace Tests\Feature;

use App\Models\Emo;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class DataControllerTest extends TestCase
{
    public function testScanner()
    {
        $this->seed(DatabaseSeeder::class);

        $motorList = "Fajar-MotorList1804";
        $uri = "https://www.safesave.info/MIC.php?id=" . $motorList;

        $emo = Emo::query()->with("funcLoc", "emoDetail")->where("qr_code_link", "=", $uri)->first();
        self::assertNotNull($emo);
        self::assertEquals("EMO000426", $emo->id);
    }

    public function testGetScannerFailed()
    {
        $this->seed(DatabaseSeeder::class);

        $motorList = "Fajar-MotorList9999";
        $uri = "https://www.safesave.info/MIC.php?id=" . $motorList;

        $emo = Emo::query()->with("funcLoc", "emoDetail")->where("qr_code_link", "=", $uri)->first();
        self::assertNull($emo);
    }

    public function testGetViewScanner()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])->get("/scanner")
            ->assertSeeText("Scanner");
    }

    public function testCheckingFormSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])->get("/checking-form/Fajar-MotorList1804")
            ->assertSee("Submit")
            ->assertSeeText("MOTOR DETAIL")
            ->assertDontSeeText("Sorry, this page")
            ->assertDontSeeText("The link you followed may be broken,")
            ->assertDontSeeText("Back to Home");
    }
    public function testCheckingFormFailed()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])->get("/checking-form/Fajar-MotorList9999")
            ->assertSeeText("Sorry, this page")
            ->assertSeeText("The link you followed may be broken,")
            ->assertSeeText("Back to Home")
            ->assertDontSee("Submit")
            ->assertDontSeeText("MOTOR DETAIL");
    }
}
