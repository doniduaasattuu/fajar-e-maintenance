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
        $emo_record->temperature_a = 69;
        $emo_record->temperature_b = 71;
        $emo_record->temperature_c = 85;
        $emo_record->temperature_d = 65;
        $emo_record->vibration_value_de = 0.68;
        $emo_record->vibration_de = "Good";
        $emo_record->vibration_value_nde = 0.58;
        $emo_record->vibration_nde = "Good";
        $emo_record->created_at = Carbon::now()->toDateTimeString();
        $emo_record->nik = User::query()->find("55000154")->nik;
        $result = $emo_record->save();

        self::assertTrue($result);
        self::assertNotNull($emo_record);
        self::assertNotNull($emo_record->vibration_de);
        self::assertEquals("Good", $emo_record->vibration_de);
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
            "motor_status" => "Running",
            "clean_status" => "Clean",
            "nipple_grease_input" => "Available",
            "number_of_greasing_input" => "80",
            "temperature_a" => "150",
            "temperature_b" => "90",
            "temperature_c" => "50",
            "temperature_d" => "10",
            "vibration_value_de" => "0.83",
            "vibration_de" => "Good",
            "vibration_value_nde" => "0.35",
            "vibration_nde" => "Good",
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
            "motor_status" => "Running",
            "clean_status" => "Clean",
            "nipple_grease_input" => "Available",
            "number_of_greasing_input" => null,
            "temperature_a" => null,
            "temperature_b" => null,
            "temperature_c" => null,
            "temperature_d" => null,
            "vibration_value_de" => null,
            "vibration_de" => null,
            "vibration_value_nde" => null,
            "vibration_nde" => null,
            "created_at" => Carbon::now()->toDateTimeString(),
            "checked_by" => "55000154",
        ])
            ->assertJson([
                "message" => "Saved successfully! ✅"
            ]);
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
            "motor_status" => "Running",
            "clean_status" => "Clean",
            "nipple_grease_input" => "Available",
            "number_of_greasing_input" => "80",
            "temperature_a" => "150",
            "temperature_b" => "90",
            "temperature_c" => "50",
            "temperature_d" => "10",
            "vibration_value_de" => "0.83",
            "vibration_de" => "Good",
            "vibration_value_nde" => "0.35",
            "vibration_nde" => "Good",
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
            "motor_status" => "Running",
            "clean_status" => "Clean",
            "nipple_grease_input" => "Available",
            "number_of_greasing_input" => "80",
            "temperature_a" => "150",
            "temperature_b" => "90",
            "temperature_c" => "50",
            "temperature_d" => "10",
            "vibration_value_de" => "0.83",
            "vibration_de" => "Good",
            "vibration_value_nde" => "0.35",
            "vibration_nde" => "Good",
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
            "motor_status" => "Running",
            "clean_status" => "Clean",
            "nipple_grease_input" => "Available",
            "number_of_greasing_input" => "80",
            "temperature_a" => "150",
            "temperature_b" => "90",
            "temperature_c" => "50",
            "temperature_d" => "10",
            "vibration_value_de" => "0.83",
            "vibration_de" => "Good",
            "vibration_value_nde" => "0.35",
            "vibration_nde" => "Good",
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
            "motor_status" => null,
            "clean_status" => "Clean",
            "nipple_grease_input" => "Available",
            "number_of_greasing_input" => "80",
            "temperature_a" => "150",
            "temperature_b" => "90",
            "temperature_c" => "50",
            "temperature_d" => "10",
            "vibration_value_de" => "0.83",
            "vibration_de" => "Good",
            "vibration_value_nde" => "0.35",
            "vibration_nde" => "Good",
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
            "motor_status" => "Running",
            "clean_status" => null,
            "nipple_grease_input" => "Available",
            "number_of_greasing_input" => "80",
            "temperature_a" => "150",
            "temperature_b" => "90",
            "temperature_c" => "50",
            "temperature_d" => "10",
            "vibration_value_de" => "0.83",
            "vibration_de" => "Good",
            "vibration_value_nde" => "0.35",
            "vibration_nde" => "Good",
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
            "motor_status" => "Running",
            "clean_status" => "Clean",
            "nipple_grease_input" => null,
            "number_of_greasing_input" => "80",
            "temperature_a" => "150",
            "temperature_b" => "90",
            "temperature_c" => "50",
            "temperature_d" => "10",
            "vibration_value_de" => "0.83",
            "vibration_de" => "Good",
            "vibration_value_nde" => "0.35",
            "vibration_nde" => "Good",
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
        ])->post("/checking-form/Fajar-MotorList1804", [])
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
            "motor_status" => "Running",
            "clean_status" => "Clean",
            "nipple_grease_input" => "Invalid", // should Available or Not Available
            "number_of_greasing_input" => "90",
            "temperature_a" => "90",
            "temperature_b" => "90",
            "temperature_c" => "90",
            "temperature_d" => "90",
            "vibration_value_de" => "1",
            "vibration_de" => "Good",
            "vibration_value_nde" => "1",
            "vibration_nde" => "Good",
            "comment" => "",
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
        self::assertCount(8, $emo);
        Log::info(json_encode($emo, JSON_PRETTY_PRINT));
    }

    // GET TOP FIVE
    public function testGetTopFiveTempDe()
    {
        $this->seed(DatabaseSeeder::class);

        $temperature_a = EmoRecord::query()
            ->select(["funcloc", "emo", "temperature_a", "created_at"])
            ->orderByDesc("temperature_a")
            ->where("funcloc", "LIKE", "%PM3%")
            ->orWhere("funcloc", "LIKE", "%SP3%")
            ->orWhere("funcloc", "LIKE", "%CH3%")
            ->limit(5)
            ->get();

        self::assertCount(5, $temperature_a);
    }

    public function testGetTopFiveTempNde()
    {
        $this->seed(DatabaseSeeder::class);

        $temperature_d = EmoRecord::query()
            ->select(["funcloc", "emo", "temperature_d", "created_at"])
            ->orderByDesc("temperature_d")
            ->where("funcloc", "LIKE", "%PM3%")
            ->orWhere("funcloc", "LIKE", "%SP3%")
            ->orWhere("funcloc", "LIKE", "%CH3%")
            ->limit(5)
            ->get();

        self::assertCount(5, $temperature_d);
    }


    public function testGetTopFiveVibrationDe()
    {
        $this->seed(DatabaseSeeder::class);

        $vibration_value_de = EmoRecord::query()
            ->select(["funcloc", "emo", "vibration_value_de", "created_at"])
            ->orderByDesc("vibration_value_de")
            ->where("funcloc", "LIKE", "%PM3%")
            ->orWhere("funcloc", "LIKE", "%SP3%")
            ->orWhere("funcloc", "LIKE", "%CH3%")
            ->limit(5)
            ->get();

        self::assertCount(5, $vibration_value_de);
    }

    public function testGetTopFiveVibrationNde()
    {
        $this->seed(DatabaseSeeder::class);

        $vibration_value_nde = EmoRecord::query()
            ->select(["funcloc", "emo", "vibration_value_nde", "created_at"])
            ->orderByDesc("vibration_value_nde")
            ->where("funcloc", "LIKE", "%PM3%")
            ->orWhere("funcloc", "LIKE", "%SP3%")
            ->orWhere("funcloc", "LIKE", "%CH3%")
            ->limit(5)
            ->get();

        self::assertCount(5, $vibration_value_nde);
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
