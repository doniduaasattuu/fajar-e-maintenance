<?php

namespace Tests\Feature;

use App\Models\Administrators;
use App\Models\Emo;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\AdministratorsSeeder;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Eloquent\Collection;
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
            ->assertSeeText("Temperature DE")
            ->assertSeeText("Temperature Body")
            ->assertSeeText("Temperature NDE")
            ->assertSee("vibration_de_vertical_value")
            ->assertSee("vibration_de_horizontal_value")
            ->assertSee("vibration_de_axial_value")
            ->assertSee("vibration_de_frame_value")
            ->assertSee("vibration_nde_vertical_value")
            ->assertSee("vibration_nde_horizontal_value")
            ->assertSee("vibration_nde_frame_value")
            ->assertSeeText("Remarks")
            ->assertSeeText("Submit");
    }

    public function testGetCheckingFormFailed()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan",
        ])
            ->get("/checking-form/Fajar-MotorList0000", [
                'title' => 'Checking Form'
            ])
            ->assertStatus(404)
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
            ->assertStatus(404)
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
            ->assertStatus(404)
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
            ])->post("/equipment-trends", [
                "sort_field" => "SP3.P.70/M",
                "funcloc" => "FP-01-SP3-RJS-T092-P092",
                "equipment_id" => "Fajar-MotorList1804",
            ]);

        $trends_sortfield
            ->assertStatus(200)
            ->assertSeeText("Temperature of SP3.P.70/M")
            ->assertSeeText("Vibration DE of SP3.P.70/M")
            ->assertSeeText("Vibration NDE of SP3.P.70/M")
            ->assertSeeText("Number of Greasing SP3.P.70/M")
            ->assertSeeText("Plastik terminal perlu di ganti")
            ->assertSee("EMO000426")
            ->assertSee("let length_of_data = 12");
    }

    public function testSortFieldTrendsNotFound()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withHeaders([
            'X-XSRF-TOKEN' => csrf_token()
        ])->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan",
        ])->post("/equipment-trends", [
            "sort_field" => "SP9.P.70/M",
            "funcloc" => "FP-01-SP3-RJS-T092-P999",
            "equipment_id" => "Fajar-MotorList78910",
        ])
            ->assertStatus(302);;
    }

    public function testSortFieldTrendsFailed()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withHeaders([
            'X-XSRF-TOKEN' => csrf_token()
        ])->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan",
        ])->post("/equipment-trends", [
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
            "table" => "emos",
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
        ]);

        $response
            ->assertStatus(200)
            ->assertSeeText("Your changes have been successfully saved!")
            ->assertDontSeeText("10010668");

        $emo = Emo::query()->with("emoDetails")->find("EMO000426");
        self::assertEquals("12345678", $emo->material_number);
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

    public function testGetSummaryPage()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan",
        ])->get("/summary", [
            "title" => "Summary"
        ])
            ->assertSeeText("Summary of all checking data from each Paper Machine")
            ->assertSeeText("PM1")
            ->assertSeeText("PM2")
            ->assertSeeText("PM3")
            ->assertSeeText("EMO000426")
            ->assertSeeText("MGM000481")
            ->assertSeeText("PM5")
            ->assertSeeText("PM7")
            ->assertSeeText("PM8")
            ->assertSeeText("ENC")
            ->assertSeeText("WWT");
    }

    public function testGetTypeOfEquipmentMotor()
    {
        $this->seed(DatabaseSeeder::class);

        // $emos = Emo::query()->select(['id'])->distinct('id')->get();
        // $type_of_motor = [];
        // foreach ($emos as $emo) {
        //     array_push($type_of_motor, preg_replace('/[0-9]/i', '', $emo->id));
        // }
        // $type_of_motor = array_unique($type_of_motor);

        // self::assertFalse(in_array("MDO", $type_of_motor));
        // self::assertTrue(in_array("MGM", $type_of_motor));
        // self::assertTrue(in_array("EMO", $type_of_motor));

        // self::assertNotNull($type_of_motor);
        // Log::info($type_of_motor);

        $emos = Emo::query()->select(['id'])->distinct('id')->get();

        function getTypeOfEquipment(Collection $equipments): array
        {
            $type_of_equipment = [];
            foreach ($equipments as $equipment) {
                array_push($type_of_equipment, preg_replace('/[0-9]/i', '', $equipment->id));
            }
            return $type_of_equipment;
        }

        $type_of_motor = array_unique(getTypeOfEquipment($emos));

        self::assertFalse(in_array("MDO", $type_of_motor));
        self::assertTrue(in_array("MGM", $type_of_motor));
        self::assertTrue(in_array("EMO", $type_of_motor));

        self::assertNotNull($type_of_motor);
        Log::info($type_of_motor);
    }

    public function testGetColumnOfTable()
    {
        $this->seed(DatabaseSeeder::class);

        $col = DB::getSchemaBuilder()->getColumnListing("emos");
        self::assertNotNull($col);
        Log::info(json_encode($col, JSON_PRETTY_PRINT));
    }

    public function testGetTypeOfColumn()
    {
        $col = DB::getSchemaBuilder()->getColumnListing('emos', 'status');
        self::assertNotNull($col);
        Log::info(json_encode($col, JSON_PRETTY_PRINT));
    }
}
