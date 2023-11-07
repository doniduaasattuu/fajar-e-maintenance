<?php

namespace Tests\Feature;

use App\Models\Emo;
use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\FuncCall;
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
            ->assertSeeText("TECO")
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

    // TRENDS
    public function testTrendsSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        $this->session([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])
            ->get("trends/EMO000426")
            ->assertSeeText("Temperature of EMO000426")
            ->assertSeeText("Left side")
            ->assertSeeText("IEC 60085")
            ->assertSeeText("Vibration of EMO000426");
    }

    public function testTrendsFailed()
    {
        $this->seed(DatabaseSeeder::class);

        $this->session([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])
            ->get("trends/EMO000000")
            ->assertStatus(302);
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

    public function testSearchEmoDatabase()
    {
        $this->seed(DatabaseSeeder::class);

        $emo = Emo::query()->with("emoDetails")
            ->where("id", "=", "EMO000426")
            ->first();
        self::assertNotNull($emo);

        Log::info(json_encode($emo, JSON_PRETTY_PRINT));
    }

    // SEARCH EQUIPMENT
    public function testSearchEquipmentSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "user" => "Doni Darmawan",
            "nik" => "55000154"
        ])
            ->get("/edit-equipment/EMO000426", [])
            ->assertStatus(200)
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

    public function testSearchEquipmentFailed()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "user" => "Doni Darmawan",
            "nik" => "55000154"
        ])
            ->get("/edit-equipment/EMO009999", [])
            ->assertSeeText("Oops")
            ->assertSeeText("The link you followed may be broken")
            ->assertSeeText("Back to Home")
            ->assertStatus(200);
    }

    public function testSearchEquipmentNotAdministrator()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "user" => "Jamal Mirdad",
            "nik" => "55000153"
        ])
            ->get("/edit-equipment/EMO009999", [])
            ->assertStatus(302)
            ->assertRedirect("/");
    }

    // UPDATE EQUIPMENT
    public function testUpdateEquipmentFailed()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withHeaders([
            'X-XSRF-TOKEN' => csrf_token()
        ])->withSession([
            "user" => "Doni Darmawan",
            "nik" => "55000154"
        ])->post("/update-equipment", [
            "id" => "EMO000426",
            "material_number" => "1001066800"
        ])
            ->assertStatus(302)
            ->assertRedirect(session()->previousUrl());

        $emo = Emo::query()->find("EMO000426");
        self::assertNotNull($emo);
        self::assertEquals($emo->material_number, "10010668");
    }

    public function testUpdateEquipmentSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withHeaders([
            'X-XSRF-TOKEN' => csrf_token()
        ])->withSession([
            "user" => "Doni Darmawan",
            "nik" => "55000154"
        ])->post("/update-equipment", [
            "id" => "EMO000426",
            "funcloc" => "FP-01-SP3-RJS-T092-P092",
            "material_number" => "12345678",
            "status" => "Installed",
            "sort_field" => "SP3.P.70/M",
            "updated_at" => Carbon::now()->toDateTimeString(),
            "manufacture" => "TECO",
            "serial_number" => "P9543291",
            "type" => "AEEBPA040100YW05T",
            "power_rate" => "75",
            "power_unit" => "kW",
            "voltage" => "380",
            "current_nominal" => "140",
            "frequency" => "50",
            "pole" => "4",
            "rpm" => "1475",
            "bearing_de" => "NU216",
            "bearing_nde" => "6213",
            "frame_type" => "250M",
            "shaft_diameter" => "75",
            "phase_supply" => "3",
            "cos_phi" => "0.84",
            "efficiency" => "0.80",
            "ip_rating" => "55",
            "insulation_class" => "F",
            "duty" => "S1",
            "connection_type" => "Delta",
            "nipple_grease" => "Available",
            "greasing_type" => null,
            "greasing_qty_de" => null,
            "greasing_qty_nde" => null,
            "length" => null,
            "width" => null,
            "height" => "250",
            "weight" => null,
            "cooling_fan" => "Internal",
            "mounting" => "Horizontal",
        ])
            ->assertStatus(302)
            ->assertRedirect(session()->previousUrl());

        $emo = Emo::query()->find("EMO000426");
        self::assertNotNull($emo);
        self::assertEquals($emo->material_number, "12345678");
    }
}
