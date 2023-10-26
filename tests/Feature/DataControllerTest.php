<?php

namespace Tests\Feature;

use App\Models\Emo;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class DataControllerTest extends TestCase
{
    public function testScanner()
    {
        $this->seed(DatabaseSeeder::class);

        $motorList = "Fajar-MotorList1804";
        $uri = "https://www.safesave.info/MIC.php?id=" . $motorList;

        $emo = Emo::query()->with("funcLoc", "emoDetails")->where("qr_code_link", "=", $uri)->first();
        self::assertNotNull($emo);
        self::assertEquals("EMO000426", $emo->id);
    }

    public function testGetScannerFailed()
    {
        $this->seed(DatabaseSeeder::class);

        $motorList = "Fajar-MotorList9999";
        $uri = "https://www.safesave.info/MIC.php?id=" . $motorList;

        $emo = Emo::query()->with("funcLoc", "emoDetails")->where("qr_code_link", "=", $uri)->first();
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
            ->assertDontSeeText("Page not found")
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
            ->assertSeeText("Page not found")
            ->assertSeeText("The link you followed may be broken,")
            ->assertSeeText("Back to Home")
            ->assertDontSee("Submit")
            ->assertDontSeeText("MOTOR DETAIL");
    }

    // SEARCH BY EMO
    public function testSearchDatabaseByEmo()
    {
        $this->seed(DatabaseSeeder::class);

        $emo = Emo::query()->with("funcLoc", "emoDetails")->find("EMO000426");
        Log::info(json_encode($emo, JSON_PRETTY_PRINT));
        $motorList = substr($emo->qr_code_link, -19);

        self::assertNotNull($emo);
        self::assertEquals("Fajar-MotorList1804", $motorList);
        self::assertEquals(9, strlen("EMO000426"));
    }

    public function testSearchDatabaseByEmoFailed()
    {
        $this->seed(DatabaseSeeder::class);

        $emo = Emo::query()->with("funcLoc", "emoDetails")->find("EMO000426");
        Log::info(json_encode($emo, JSON_PRETTY_PRINT));
        $motorList = substr($emo->qr_code_link, -19);

        self::assertNotNull($emo);
        self::assertEquals("Fajar-MotorList1804", $motorList);
        self::assertEquals(9, strlen("EMO000426"));
    }

    public function testSearchPostByEmoSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withHeaders([
            'X-XSRF-TOKEN' => csrf_token()
        ])->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan",
        ])->post("/search", [
            "search_data" => "EMO000426"
        ])
            ->assertStatus(302)
            ->assertRedirect("/checking-form/Fajar-MotorList1804");
    }

    public function testSearchPostByEmoFailed()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withHeaders([
            'X-XSRF-TOKEN' => csrf_token()
        ])->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan",
        ])->post("/search", [
            "search_data" => "EMO000999"
        ])
            ->assertStatus(200)
            ->assertSeeText("Page not found");
    }

    // SEARCH BY UNIQUE ID
    public function testSearchDatabaseByUniqueIdSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        $unique_id = Emo::query()->where("unique_id", "=", "1804")->first();
        Log::info(json_encode($unique_id, JSON_PRETTY_PRINT));
        self::assertNotNull($unique_id);
    }

    public function testSearchDatabaseByUniqueIdFailed()
    {
        $this->seed(DatabaseSeeder::class);

        $unique_id = Emo::query()->where("unique_id", "=", "9999")->first();
        self::assertNull($unique_id);
    }

    public function testSearchPostByUniqueIdSucces()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withHeaders([
            'X-XSRF-TOKEN' => csrf_token()
        ])->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan",
        ])->post("/search", [
            "search_data" => "1804"
        ])
            ->assertStatus(302)
            ->assertRedirect("/checking-form/Fajar-MotorList1804");
    }

    public function testSearchPostByUniqueIdFailed()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withHeaders([
            'X-XSRF-TOKEN' => csrf_token()
        ])->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan",
        ])->post("/search", [
            "search_data" => "9999"
        ])
            ->assertStatus(200)
            ->assertSeeText("Page not found");
    }

    // SEARCH BY MOTORLIST
    public function testSearchPostByMotorListSucces()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withHeaders([
            'X-XSRF-TOKEN' => csrf_token()
        ])->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan",
        ])->post("/search", [
            "search_data" => "Fajar-MotorList1804"
        ])
            ->assertStatus(302)
            ->assertRedirect("/checking-form/Fajar-MotorList1804");
    }

    public function testSearchPostByMotorListFailed()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withHeaders([
            'X-XSRF-TOKEN' => csrf_token()
        ])->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan",
        ])->post("/search", [
            "search_data" => "Fajar-MotorList6143"
        ])
            ->assertStatus(302)
            ->assertRedirect("/checking-form/Fajar-MotorList6143");
    }
}
