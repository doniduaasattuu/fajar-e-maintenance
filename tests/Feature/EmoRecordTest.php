<?php

namespace Tests\Feature;

use App\Models\EmoRecord;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\EmoRecordSeeder;
use Database\Seeders\EmoDetailSeeder;
use Database\Seeders\EmoSeeder;
use Database\Seeders\FunctionLocationSeeder;
use Database\Seeders\UserSeeder;
use DateTime;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class EmoRecordTest extends TestCase
{
    public function testCreateEmoRecord()
    {
        $this->seed(DatabaseSeeder::class);

        $emo_record = new EmoRecord();
        $emo_record->funcloc = "FP-01-SP3-RJS-T092-P092";
        $emo_record->emo = "EMO000426";
        $emo_record->sort_field = "SP3.P.70/M";
        $emo_record->motor_status = "Running";
        $emo_record->clean_status = "Clean";
        $emo_record->nipple_grease = "Available";
        $emo_record->number_of_greasing = 80;
        $emo_record->number_of_greasing = rand(2, 4) * 10;
        $emo_record->temperature_de = rand(35, 101);
        $emo_record->temperature_body = rand(35, 101);
        $emo_record->temperature_nde = rand(35, 101);
        $emo_record->vibration_de_vertical_value = rand(45, 112) / 100;
        $emo_record->vibration_de_vertical_desc = "Good";
        $emo_record->vibration_de_horizontal_value = rand(45, 112) / 100;
        $emo_record->vibration_de_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
        $emo_record->vibration_de_axial_value = rand(45, 112) / 100;
        $emo_record->vibration_de_axial_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
        $emo_record->vibration_de_frame_value = rand(45, 112) / 100;
        $emo_record->vibration_de_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
        $emo_record->vibration_nde_vertical_value = rand(45, 112) / 100;
        $emo_record->vibration_nde_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
        $emo_record->vibration_nde_horizontal_value = rand(45, 112) / 100;
        $emo_record->vibration_nde_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
        $emo_record->vibration_nde_frame_value = rand(45, 112) / 100;
        $emo_record->vibration_nde_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
        $emo_record->created_at = Carbon::now()->toDateTimeString();
        $emo_record->nik = User::query()->find("55000154")->nik;
        $result = $emo_record->save();

        self::assertTrue($result);
        self::assertNotNull($emo_record);
        self::assertNotNull($emo_record->vibration_de_vertical_value);
        self::assertEquals("Good", $emo_record->vibration_de_vertical_desc);
        self::assertEquals("SP3.P.70/M", $emo_record->sort_field);
    }

    public function testPostEmoRecordAllFieldFilled()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])->post("/checking-form/Fajar-MotorList1804", [
            "funcloc" => "FP-01-SP3-RJS-T092-P092",
            "emo" => "EMO000426",
            "sort_field" => "SP3.P.70/M",
            "equipment_id" => "Fajar-MotorList1804",
            "motor_status" => "Running",
            "clean_status" => "Clean",
            "nipple_grease" => "Available",
            "number_of_greasing" => "80",
            'temperature_de' => 78,
            'temperature_body' => 66,
            'temperature_nde' => 56,
            'vibration_de_vertical_value' => 1.12,
            'vibration_de_horizontal_value' => 1.12,
            'vibration_de_axial_value' => 1.12,
            'vibration_de_frame_value' => 1.12,
            'noise_de' => "Normal",
            'vibration_nde_vertical_value' => 1.12,
            'vibration_nde_horizontal_value' => 1.12,
            'vibration_nde_frame_value' => 1.12,
            'vibration_de_vertical_desc' => "Good",
            'vibration_de_horizontal_desc' => "Good",
            'vibration_de_axial_desc' => "Good",
            'vibration_de_frame_desc' => "Good",
            'noise_nde' => "Normal",
            'vibration_nde_vertical_desc' => "Good",
            'vibration_nde_horizontal_desc' => "Good",
            'vibration_nde_frame_desc' => "Good",
            "created_at" => Carbon::now()->toDateTimeString(),
            "checked_by" => "Doni Darmawan",
        ])
            ->assertJson([
                "message" => "Saved successfully! ✅"
            ]);
    }

    public function testPostEmoRecordImportantFieldFilled()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])->post("/checking-form/Fajar-MotorList1804", [
            "funcloc" => "FP-01-SP3-RJS-T092-P092",
            "emo" => "EMO000426",
            "sort_field" => "SP3.P.70/M",
            "equipment_id" => "Fajar-MotorList1804",
            "motor_status" => "Running",
            "clean_status" => "Clean",
            "nipple_grease" => "Available",
            "number_of_greasing" => null,
            'temperature_de' => null,
            'temperature_body' => null,
            'temperature_nde' => null,
            'vibration_de_vertical_value' => null,
            'vibration_de_horizontal_value' => null,
            'vibration_de_axial_value' => null,
            'vibration_de_frame_value' => null,
            'noise_de' => "Normal",
            'vibration_nde_vertical_value' => null,
            'vibration_nde_horizontal_value' => null,
            'vibration_nde_frame_value' => null,
            'vibration_de_vertical_desc' => null,
            'vibration_de_horizontal_desc' => null,
            'vibration_de_axial_desc' => null,
            'vibration_de_frame_desc' => null,
            'noise_nde' => "Normal",
            'vibration_nde_vertical_desc' => null,
            'vibration_nde_horizontal_desc' => null,
            'vibration_nde_frame_desc' => null,
            "created_at" => Carbon::now()->toDateTimeString(),
            "checked_by" => "55000154",
        ])
            ->assertJson([
                "message" => "Saved successfully! ✅"
            ]);
    }

    public function testPostEmoRecordDatetimeEmpty()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])->post("/checking-form/Fajar-MotorList1804", [
            "funcloc" => "FP-01-SP3-RJS-T092-P092",
            "emo" => "EMO000426",
            "sort_field" => "SP3.P.70/M",
            "equipment_id" => "Fajar-MotorList1804",
            "motor_status" => "Running",
            "clean_status" => "Clean",
            "nipple_grease" => "Available",
            "number_of_greasing" => null,
            'temperature_de' => null,
            'temperature_body' => null,
            'temperature_nde' => null,
            'vibration_de_vertical_value' => null,
            'vibration_de_horizontal_value' => null,
            'vibration_de_axial_value' => null,
            'vibration_de_frame_value' => null,
            'vibration_nde_vertical_value' => null,
            'vibration_nde_horizontal_value' => null,
            'vibration_nde_frame_value' => null,
            'vibration_de_vertical_desc' => null,
            'vibration_de_horizontal_desc' => null,
            'vibration_de_axial_desc' => null,
            'vibration_de_frame_desc' => null,
            'vibration_nde_vertical_desc' => null,
            'vibration_nde_horizontal_desc' => null,
            'vibration_nde_frame_desc' => null,
            "created_at" => null,
            "checked_by" => "55000154",
        ])
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has("error")
            );
    }

    public function testPostEmoRecordFunclocFieldEmpty()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])->post("/checking-form/Fajar-MotorList1804", [
            "funcloc" => null,
            "emo" => "EMO000426",
            "sort_field" => "SP3.P.70/M",
            "equipment_id" => "Fajar-MotorList1804",
            "motor_status" => "Running",
            "clean_status" => "Clean",
            "nipple_grease" => "Available",
            "number_of_greasing" => "80",
            'temperature_de' => 78,
            'temperature_body' => 66,
            'temperature_nde' => 56,
            'vibration_de_vertical_value' => 1.12,
            'vibration_de_horizontal_value' => 1.12,
            'vibration_de_axial_value' => 1.12,
            'vibration_de_frame_value' => 1.12,
            'vibration_nde_vertical_value' => 1.12,
            'vibration_nde_horizontal_value' => 1.12,
            'vibration_nde_frame_value' => 1.12,
            'vibration_de_vertical_desc' => "Good",
            'vibration_de_horizontal_desc' => "Good",
            'vibration_de_axial_desc' => "Good",
            'vibration_de_frame_desc' => "Good",
            'vibration_nde_vertical_desc' => "Good",
            'vibration_nde_horizontal_desc' => "Good",
            'vibration_nde_frame_desc' => "Good",
            "created_at" => Carbon::now()->toDateTimeString(),
            "checked_by" => "55000154",
        ])
            ->assertJson([
                "error" => "All field is required! ⚠️"
            ]);
    }

    public function testPostEmoRecordEmoFieldEmpty()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])->post("/checking-form/Fajar-MotorList1804", [
            "funcloc" => "FP-01-SP3-RJS-T092-P092",
            "emo" => null,
            "sort_field" => "SP3.P.70/M",
            "equipment_id" => "Fajar-MotorList1804",
            "motor_status" => "Running",
            "clean_status" => "Clean",
            "nipple_grease" => "Available",
            "number_of_greasing" => "80",
            'temperature_de' => 78,
            'temperature_body' => 66,
            'temperature_nde' => 56,
            'vibration_de_vertical_value' => 1.12,
            'vibration_de_horizontal_value' => 1.12,
            'vibration_de_axial_value' => 1.12,
            'vibration_de_frame_value' => 1.12,
            'vibration_nde_vertical_value' => 1.12,
            'vibration_nde_horizontal_value' => 1.12,
            'vibration_nde_frame_value' => 1.12,
            'vibration_de_vertical_desc' => "Good",
            'vibration_de_horizontal_desc' => "Good",
            'vibration_de_axial_desc' => "Good",
            'vibration_de_frame_desc' => "Good",
            'vibration_nde_vertical_desc' => "Good",
            'vibration_nde_horizontal_desc' => "Good",
            'vibration_nde_frame_desc' => "Good",
            "created_at" => Carbon::now()->toDateTimeString(),
            "checked_by" => "55000154",
        ])
            ->assertJson([
                "error" => "All field is required! ⚠️"
            ]);
    }

    public function testPostEmoRecordSortFieldEmpty()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])->post("/checking-form/Fajar-MotorList1804", [
            "funcloc" => "FP-01-SP3-RJS-T092-P092",
            "emo" => "EMO000426",
            "sort_field" => null,
            "equipment_id" => "Fajar-MotorList1804",
            "motor_status" => "Running",
            "clean_status" => "Clean",
            "nipple_grease" => "Available",
            "number_of_greasing" => "80",
            'temperature_de' => 78,
            'temperature_body' => 66,
            'temperature_nde' => 56,
            'vibration_de_vertical_value' => 1.12,
            'vibration_de_horizontal_value' => 1.12,
            'vibration_de_axial_value' => 1.12,
            'vibration_de_frame_value' => 1.12,
            'vibration_nde_vertical_value' => 1.12,
            'vibration_nde_horizontal_value' => 1.12,
            'vibration_nde_frame_value' => 1.12,
            'vibration_de_vertical_desc' => "Good",
            'vibration_de_horizontal_desc' => "Good",
            'vibration_de_axial_desc' => "Good",
            'vibration_de_frame_desc' => "Good",
            'vibration_nde_vertical_desc' => "Good",
            'vibration_nde_horizontal_desc' => "Good",
            'vibration_nde_frame_desc' => "Good",
            "created_at" => Carbon::now()->toDateTimeString(),
            "checked_by" => "55000154",
        ])
            ->assertJson([
                "error" => "All field is required! ⚠️"
            ]);
    }

    public function testPostEmoRecordMotorStatusFieldEmpty()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])->post("/checking-form/Fajar-MotorList1804", [
            "funcloc" => "FP-01-SP3-RJS-T092-P092",
            "emo" => "EMO000426",
            "sort_field" => "SP3.P.70/M",
            "equipment_id" => "Fajar-MotorList1804",
            "motor_status" => null,
            "clean_status" => "Clean",
            "nipple_grease" => "Available",
            "number_of_greasing" => "80",
            'temperature_de' => 78,
            'temperature_body' => 66,
            'temperature_nde' => 56,
            'vibration_de_vertical_value' => 1.12,
            'vibration_de_horizontal_value' => 1.12,
            'vibration_de_axial_value' => 1.12,
            'vibration_de_frame_value' => 1.12,
            'vibration_nde_vertical_value' => 1.12,
            'vibration_nde_horizontal_value' => 1.12,
            'vibration_nde_frame_value' => 1.12,
            'vibration_de_vertical_desc' => "Good",
            'vibration_de_horizontal_desc' => "Good",
            'vibration_de_axial_desc' => "Good",
            'vibration_de_frame_desc' => "Good",
            'vibration_nde_vertical_desc' => "Good",
            'vibration_nde_horizontal_desc' => "Good",
            'vibration_nde_frame_desc' => "Good",
            "created_at" => Carbon::now()->toDateTimeString(),
            "checked_by" => "55000154",
        ])
            ->assertJson([
                "error" => "All field is required! ⚠️"
            ]);
    }

    public function testPostEmoRecordCleanStatusFieldEmpty()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])->post("/checking-form/Fajar-MotorList1804", [
            "funcloc" => "FP-01-SP3-RJS-T092-P092",
            "emo" => "EMO000426",
            "sort_field" => "SP3.P.70/M",
            "equipment_id" => "Fajar-MotorList1804",
            "motor_status" => "Running",
            "clean_status" => null,
            "nipple_grease" => "Available",
            "number_of_greasing" => "80",
            'temperature_de' => 78,
            'temperature_body' => 66,
            'temperature_nde' => 56,
            'vibration_de_vertical_value' => 1.12,
            'vibration_de_horizontal_value' => 1.12,
            'vibration_de_axial_value' => 1.12,
            'vibration_de_frame_value' => 1.12,
            'vibration_nde_vertical_value' => 1.12,
            'vibration_nde_horizontal_value' => 1.12,
            'vibration_nde_frame_value' => 1.12,
            'vibration_de_vertical_desc' => "Good",
            'vibration_de_horizontal_desc' => "Good",
            'vibration_de_axial_desc' => "Good",
            'vibration_de_frame_desc' => "Good",
            'vibration_nde_vertical_desc' => "Good",
            'vibration_nde_horizontal_desc' => "Good",
            'vibration_nde_frame_desc' => "Good",
            "created_at" => Carbon::now()->toDateTimeString(),
            "checked_by" => "55000154",
        ])
            ->assertJson([
                "error" => "All field is required! ⚠️"
            ]);
    }

    public function testPostEmoRecordNippleGreaseInputFieldEmpty()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])->post("/checking-form/Fajar-MotorList1804", [
            "funcloc" => "FP-01-SP3-RJS-T092-P092",
            "emo" => "EMO000426",
            "sort_field" => "SP3.P.70/M",
            "equipment_id" => "Fajar-MotorList1804",
            "motor_status" => "Running",
            "clean_status" => "Clean",
            "nipple_grease" => null,
            "number_of_greasing" => "80",
            'temperature_de' => 78,
            'temperature_body' => 66,
            'temperature_nde' => 56,
            'vibration_de_vertical_value' => 1.12,
            'vibration_de_horizontal_value' => 1.12,
            'vibration_de_axial_value' => 1.12,
            'vibration_de_frame_value' => 1.12,
            'vibration_nde_vertical_value' => 1.12,
            'vibration_nde_horizontal_value' => 1.12,
            'vibration_nde_frame_value' => 1.12,
            'vibration_de_vertical_desc' => "Good",
            'vibration_de_horizontal_desc' => "Good",
            'vibration_de_axial_desc' => "Good",
            'vibration_de_frame_desc' => "Good",
            'vibration_nde_vertical_desc' => "Good",
            'vibration_nde_horizontal_desc' => "Good",
            'vibration_nde_frame_desc' => "Good",
            "created_at" => Carbon::now()->toDateTimeString(),
            "checked_by" => "55000154",
        ])
            ->assertJson([
                "error" => "All field is required! ⚠️"
            ]);
    }

    public function testPostEmoRecordAllFieldEmpty()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])->post("/checking-form/Fajar-MotorList1804", [
            "equipment_id" => "Fajar-MotorList1804",
        ])
            ->assertJson([
                "error" => "All field is required! ⚠️"
            ]);
    }

    public function testPostEmoRecordSqlError()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan",
        ])->post("/checking-form/Fajar-MotorList1804", [
            "funcloc" => "FP-01-SP3-RJS-T092-P092",
            "emo" => "EMO000426",
            "sort_field" => "SP3.P.70/M",
            "equipment_id" => "Fajar-MotorList1804",
            "motor_status" => "Running",
            "clean_status" => "Clean",
            "nipple_grease" => "Invalid Value",
            "number_of_greasing" => "80",
            'temperature_de' => 78,
            'temperature_body' => 66,
            'temperature_nde' => 56,
            'vibration_de_vertical_value' => 1.12,
            'vibration_de_horizontal_value' => 1.12,
            'vibration_de_axial_value' => 1.12,
            'vibration_de_frame_value' => 1.12,
            'vibration_nde_vertical_value' => 1.12,
            'vibration_nde_horizontal_value' => 1.12,
            'vibration_nde_frame_value' => 1.12,
            'noise_de' => "Normal",
            'vibration_de_vertical_desc' => "Good",
            'vibration_de_horizontal_desc' => "Good",
            'vibration_de_axial_desc' => "Good",
            'vibration_de_frame_desc' => "Good",
            'noise_nde' => "Normal",
            'vibration_nde_vertical_desc' => "Good",
            'vibration_nde_horizontal_desc' => "Good",
            'vibration_nde_frame_desc' => "Good",
            "comment" => "",
            "created_at" => Carbon::now()->toDateTimeString(),
            "checked_by" => "55000154",
        ])
            ->assertJson([
                "error" => [
                    "errorInfo" => [
                        "01000",
                        "1265",
                        "Data truncated for column 'nipple_grease' at row 1"
                    ],
                    "connectionName" => "mysql"
                ]
            ]);
    }

    public function testGetEmoRecord()
    {
        $this->seed([DatabaseSeeder::class]);

        $emo_record = EmoRecord::query()->where("emo", "EMO000426")->get();
        self::assertNotNull($emo_record);
        self::assertCount(36, $emo_record);
    }

    public function testWhereBetweenSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        $endDate = Carbon::now()->addDays(1)->toDateString();
        $startDate = Carbon::now()->addYears(-1)->addDays(-1)->toDateString();

        $data_records = EmoRecord::query()->whereBetween("created_at", [$startDate, $endDate])->where("emo", "=", "EMO000426")->get();
        self::assertNotNull($data_records);
        self::assertCount(12, $data_records);
    }

    public function testWhereBetweenNotFound()
    {
        $this->seed(DatabaseSeeder::class);

        $endDate = Carbon::now()->addDays(3)->toDateString();
        $startDate = Carbon::now()->addDays(1)->toDateString();

        $data_records = EmoRecord::query()->whereBetween("created_at", [$startDate, $endDate])->where("emo", "=", "EMO000246")->get();
        self::assertCount(0, $data_records);
    }

    public function testGetEmoDatalistRecord()
    {
        $this->seed(DatabaseSeeder::class);

        $emo = EmoRecord::query()->select("emo")->distinct()->get();
        self::assertNotNull($emo);
    }

    // GET TOP FIVE
    public function testGetTopFiveTempDe()
    {
        $this->seed(DatabaseSeeder::class);

        $temperature_de = EmoRecord::query()
            ->select(["funcloc", "emo", "temperature_de", "created_at"])
            ->orderByDesc("temperature_de")
            ->where("funcloc", "LIKE", "%PM3%")
            ->orWhere("funcloc", "LIKE", "%SP3%")
            ->orWhere("funcloc", "LIKE", "%CH3%")
            ->limit(5)
            ->get();

        self::assertCount(5, $temperature_de);
    }

    public function testGetTopFiveTempNde()
    {
        $this->seed(DatabaseSeeder::class);

        $temperature_nde = EmoRecord::query()
            ->select(["funcloc", "emo", "temperature_nde", "created_at"])
            ->orderByDesc("temperature_nde")
            ->where("funcloc", "LIKE", "%PM3%")
            ->orWhere("funcloc", "LIKE", "%SP3%")
            ->orWhere("funcloc", "LIKE", "%CH3%")
            ->limit(5)
            ->get();

        self::assertCount(5, $temperature_nde);
    }


    public function testGetTopFiveVibrationDeVertical()
    {
        $this->seed(DatabaseSeeder::class);

        $vibration_de_vertical_value = EmoRecord::query()
            ->select(["funcloc", "emo", "vibration_de_vertical_value", "created_at"])
            ->orderByDesc("vibration_de_vertical_value")
            ->where("funcloc", "LIKE", "%PM3%")
            ->orWhere("funcloc", "LIKE", "%SP3%")
            ->orWhere("funcloc", "LIKE", "%CH3%")
            ->limit(5)
            ->get();

        self::assertCount(5, $vibration_de_vertical_value);
    }

    public function testGetTopFiveVibrationVerticalNde()
    {
        $this->seed(DatabaseSeeder::class);

        $vibration_nde_vertical_value = EmoRecord::query()
            ->select(["funcloc", "emo", "vibration_nde_vertical_value", "created_at"])
            ->orderByDesc("vibration_nde_vertical_value")
            ->where("funcloc", "LIKE", "%PM3%")
            ->orWhere("funcloc", "LIKE", "%SP3%")
            ->orWhere("funcloc", "LIKE", "%CH3%")
            ->limit(5)
            ->get();

        self::assertCount(5, $vibration_nde_vertical_value);
    }

    public function testComment()
    {
        $this->seed(DatabaseSeeder::class);

        $comments = EmoRecord::query()
            ->select(["comment", "nik", "created_at"])->where("comment", "!=", null)
            ->where("emo", "=", "EMO000426")
            ->orderBy("created_at", "DESC")
            ->get();

        self::assertNotNull($comments);
        self::assertCount(3, $comments);
    }

    public function testCommentTrend()
    {
        $this->seed(DatabaseSeeder::class);

        $end_date = Carbon::now()->addDays(1);
        $start_date = Carbon::now()->addYears(-1)->addDays(-1);

        $comments = EmoRecord::query()
            ->with(['user' => function ($query) {
                $query->select('nik', 'fullname');
            }])
            ->select(["comment", "emo", "created_at", "nik"])
            ->where("emo", "=", "EMO000426")
            ->where("comment", "!=", null)
            ->whereBetween("created_at", [$start_date, $end_date])
            ->orderBy("created_at", "DESC")
            ->get();

        self::assertNotNull($comments);
        Log::info(json_encode($comments, JSON_PRETTY_PRINT));
    }

    public function testCommentUser()
    {
        $this->seed(DatabaseSeeder::class);

        $comments = EmoRecord::query()
            ->select(["comment", "emo", "created_at", "nik"])
            ->where("emo", "=", "EMO000426")
            ->where("comment", "!=", null)
            ->orderBy("created_at", "DESC")
            ->with(['user' => function ($query) {
                $query->select('nik', 'fullname');
            }])
            ->first();

        self::assertNotNull($comments);
        self::assertEquals("Pipa buburan bocor mengenai motor", $comments->comment);
        self::assertEquals("55000092", $comments->user->nik);
        self::assertEquals("R. Much Arief S", $comments->user->fullname);
        Log::info(json_encode($comments, JSON_PRETTY_PRINT));
    }
}
