<?php

namespace Tests\Feature;

use App\Models\Administrators;
use App\Models\Emo;
use Carbon\Carbon;
use Database\Seeders\AdministratorsSeeder;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\FuncCall;
use Tests\TestCase;

class DataControllerTest extends TestCase
{
    // CHECKING FORM TEST START
    public function testGetCheckingFormSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan",
        ])
            ->get("/checking-form/Fajar-MotorList1804", [
                'title' => 'Checking Form'
            ])
            ->assertStatus(200)
            ->assertSeeText("MOTOR DETAILS")
            ->assertSeeText("Manufacture")
            ->assertSeeText("Mounting")
            ->assertSeeText("Horizontal")
            ->assertSeeText("FP-01-SP3-RJS-T092-P092")
            ->assertSeeText("Motor Status")
            ->assertSeeText("Cleanliness")
            ->assertSeeText("Nipple Grease")
            ->assertSeeText("Number of Greasing")
            ->assertSeeText("Temperature A")
            ->assertSeeText("Temperature B")
            ->assertSeeText("Temperature C")
            ->assertSeeText("Temperature D")
            ->assertSeeText("Vibration DE")
            ->assertSeeText("Vibration NDE")
            ->assertSeeText("Comment")
            ->assertSeeText("Submit");
    }

    public function testGetCheckingFormFailed()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan",
        ])
            ->get("/checking-form/Fajar-MotorList9999", [
                'title' => 'Checking Form'
            ])
            ->assertStatus(200)
            ->assertSeeText("Page not found.");
    }
    // CHECKING FORM TEST END
    // ===========================================================================================================
    // SEARCH TEST START
    public function testSearchByEmoSuccess()
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

    public function testSearchByEmoFailed()
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

    public function testSearchByListSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->followingRedirects()
            ->withHeaders([
                'X-XSRF-TOKEN' => csrf_token()
            ])->withSession([
                "nik" => "55000154",
                "user" => "Doni Darmawan",
            ])->post("/search", [
                "search_data" => "Fajar-MotorList1804"
            ]);

        $response
            ->assertStatus(200)
            ->assertSeeText("FP-01-SP3-RJS-T092-P092")
            ->assertSeeText("Submit");
    }

    public function testSearchByListFailed()
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->followingRedirects()
            ->withHeaders([
                'X-XSRF-TOKEN' => csrf_token()
            ])->withSession([
                "nik" => "55000154",
                "user" => "Doni Darmawan",
            ])->post("/search", [
                "search_data" => "Fajar-MotorListXXXX"
            ]);

        $response
            ->assertStatus(200)
            ->assertSeeText("Page not found.");
    }
    // SEARCH TEST END
    // ===========================================================================================================
    // SORT FIELD TRENDS TEST START
    public function testSortFieldTrendsSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        $trends_sortfield = $this->followingRedirects()
            ->withHeaders([
                'X-XSRF-TOKEN' => csrf_token()
            ])->withSession([
                "nik" => "55000154",
                "user" => "Doni Darmawan",
            ])->post("/sortfield-trends", [
                "sort_field" => "SP3.P.70/M"
            ]);

        $trends_sortfield
            ->assertStatus(200)
            ->assertSeeText("Temperature of SP3.P.70/M")
            ->assertSeeText("Vibration of SP3.P.70/M")
            ->assertSeeText("Number of Greasing SP3.P.70/M")
            ->assertSee("Edi Supriadi")
            ->assertSee("let length_of_data = 12");
    }

    public function testSortFieldTrendsNotFound()
    {
        $this->seed(DatabaseSeeder::class);

        $trends_sortfield_not_found = $this->followingRedirects()
            ->withHeaders([
                'X-XSRF-TOKEN' => csrf_token()
            ])->withSession([
                "nik" => "55000154",
                "user" => "Doni Darmawan",
            ])->post("/sortfield-trends", [
                "sort_field" => "SP9.P.70/M"
            ]);

        $trends_sortfield_not_found
            ->assertStatus(200)
            ->assertSeeText("Temperature of SP9.P.70/M")
            ->assertSeeText("Vibration of SP9.P.70/M")
            ->assertSeeText("Number of Greasing SP9.P.70/M")
            ->assertDontSee("Edi Supriadi")
            ->assertSee("let length_of_data = 0");
    }

    public function testSortFieldTrendsFailed()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withHeaders([
            'X-XSRF-TOKEN' => csrf_token()
        ])->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan",
        ])->post("/sortfield-trends", [
            "sort_field" => ""
        ])
            ->assertStatus(302)
            ->assertRedirect(session()->previousUrl());
    }
    // SORT FIELD TRENDS TEST END
    // ===========================================================================================================
    // UPDATE EQUIPMENT
    public function testUpdateEquipmentSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->followingRedirects()->withHeaders([
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
            ->assertStatus(200)
            ->assertSeeText("Your changes have been successfully saved!")
            ->assertDontSeeText("10010668");
    }

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
            "material_number" => "10010668"
        ])
            ->assertStatus(302)
            ->assertRedirect(session()->previousUrl());

        $emo = Emo::query()->find("EMO000426");
        self::assertNotNull($emo);
        self::assertEquals($emo->material_number, "10010668");
    }

    // EDIT EQUIPMENT (ADMINISTRATOR ONLY)
    public function testGetSearchEquipmentSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan",
        ])->get("/search-equipment")
            ->assertStatus(200)
            ->assertSeeText("Look for the equipment you want to update.");
    }

    public function testGetSearchEquipmentFailed()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "nik" => "55000093",
            "user" => "Saiful Bahri",
        ])->get("/search-equipment")
            ->assertStatus(302)
            ->assertRedirect("/");
    }
}
