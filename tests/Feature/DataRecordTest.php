<?php

namespace Tests\Feature;

use App\Models\DataRecord;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\DataRecordSeeder;
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

class DataRecordTest extends TestCase
{
    public function testCreateDataRecord()
    {
        $this->seed(DatabaseSeeder::class);

        $data_record = new DataRecord();
        $data_record->funcloc = "FP-01-SP3-RJS-T092-P092";
        $data_record->emo = "EMO000426";
        $data_record->motor_status = "Running";
        $data_record->clean_status = "Clean";
        $data_record->nipple_grease = "Available";
        $data_record->number_of_greasing = 80;
        $data_record->temperature_a = 69;
        $data_record->temperature_b = 71;
        $data_record->temperature_c = 85;
        $data_record->temperature_d = 65;
        $data_record->vibration_value_de = 0.68;
        $data_record->vibration_de = "Good";
        $data_record->vibration_value_nde = 0.58;
        $data_record->vibration_nde = "Good";
        $data_record->created_at = Carbon::now()->toDateTimeString();
        $data_record->checked_by = User::query()->find("55000154")->fullname;
        $data_record->save();

        self::assertNotNull($data_record);
        Log::info(json_encode($data_record, JSON_PRETTY_PRINT));
    }

    public function testRandom()
    {
        for ($i = 0; $i < 20; $i++) {
            $random = rand(1, 112) / 100;
            self::assertNotNull($random);
        }
    }

    public function testGetDataRecord()
    {
        $this->seed([DatabaseSeeder::class]);

        $data_record = DataRecord::query()->get();
        self::assertNotNull($data_record, JSON_PRETTY_PRINT);

        $date_category = [];
        $temperature_a = [];
        $temperature_b = [];
        $temperature_c = [];
        $temperature_d = [];
        foreach ($data_record as $data) {
            $month = substr($data->created_at, 5, 2);
            $date = substr($data->created_at, 8, 2);
            array_push($date_category, $date . "/" . $month);

            array_push($temperature_a, $data->temperature_a);
            array_push($temperature_b, $data->temperature_b);
            array_push($temperature_c, $data->temperature_c);
            array_push($temperature_d, $data->temperature_d);
        }
    }

    public function testWhereBetweenSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        $endDate = Carbon::now();
        $startDate = Carbon::now()->addYears(-1)->addDays(-1);

        $data_records = DataRecord::query()->whereBetween("created_at", [$startDate, $endDate])->where("emo", "=", "EMO000426")->get();
        self::assertNotNull($data_records);
        self::assertCount(12, $data_records);
        Log::info(json_encode($data_records, JSON_PRETTY_PRINT));
    }

    public function testWhereBetweenNotFound()
    {
        $this->seed(DatabaseSeeder::class);

        $endDate = Carbon::now();
        $startDate = Carbon::now()->addDays(-10);

        $data_records = DataRecord::query()->whereBetween("created_at", [$startDate, $endDate])->where("emo", "=", "EMO000246")->get();
        self::assertCount(0, $data_records);
        Log::info(json_encode($data_records, JSON_PRETTY_PRINT));
    }

    public function testPostFailed()
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

    public function testPostSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])->post("/checking-form/Fajar-MotorList1804", [
            "funcloc" => "FP-01-SP3-RJS-T092-P092",
            "emo" => "EMO000426",
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

    public function testPostSqlError()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan"
        ])->post("/checking-form/Fajar-MotorList1804", [
            "funcloc" => "FP-01-SP3-RJS-T092-P092",
            "emo" => "EMO000426",
            "motor_status" => "Running",
            "clean_status" => "Clean",
            "nipple_grease_input" => "Available",
            "number_of_greasing_input" => "80",
            "temperature_a" => "150",
            "temperature_b" => "90",
            "temperature_c" => "50",
            "temperature_d" => "10",
            "vibration_value_de" => "0.83",
            "vibration_de" => "Normal",
            "vibration_value_nde" => "0.35",
            "vibration_nde" => "Tidak ada",
            "created_at" => Carbon::now()->toDateTimeString(),
            "checked_by" => "Doni Darmawan",
        ])
            ->assertSeeText("errorInfo")
            ->assertDontSeeText("message")
            ->assertDontSeeText("All field is required! ⚠️")
            ->assertDontSeeText("Saved successfully! ✅");
    }

    public function testGetEmoDatalistRecord()
    {

        $this->seed(DatabaseSeeder::class);

        $emo = DataRecord::query()->select("emo")->distinct()->get();
        self::assertNotNull($emo);
        Log::info(json_encode($emo, JSON_PRETTY_PRINT));
    }

    public function testGetTopFiveTempNde()
    {
        $this->seed(DatabaseSeeder::class);

        $temperature_d = DataRecord::query()
            ->select(["funcloc", "emo", "temperature_d", "created_at"])
            ->orderByDesc("temperature_d")
            ->where("funcloc", "LIKE", "%PM3%")
            ->orWhere("funcloc", "LIKE", "%SP3%")
            ->orWhere("funcloc", "LIKE", "%CH3%")
            ->limit(5)
            ->get();

        self::assertCount(5, $temperature_d);

        Log::info(json_encode($temperature_d, JSON_PRETTY_PRINT));
    }

    public function testGetTopFiveTempDe()
    {
        $this->seed(DatabaseSeeder::class);

        $temperature_a = DataRecord::query()
            ->select(["funcloc", "emo", "temperature_a", "created_at"])
            ->orderByDesc("temperature_a")
            ->where("funcloc", "LIKE", "%PM3%")
            ->orWhere("funcloc", "LIKE", "%SP3%")
            ->orWhere("funcloc", "LIKE", "%CH3%")
            ->limit(5)
            ->get();

        self::assertCount(5, $temperature_a);

        Log::info(json_encode($temperature_a, JSON_PRETTY_PRINT));
    }

    public function testGetTopFiveVibrationDe()
    {
        $this->seed(DatabaseSeeder::class);

        $vibration_value_de = DataRecord::query()
            ->select(["funcloc", "emo", "vibration_value_de", "created_at"])
            ->orderByDesc("vibration_value_de")
            ->where("funcloc", "LIKE", "%PM3%")
            ->orWhere("funcloc", "LIKE", "%SP3%")
            ->orWhere("funcloc", "LIKE", "%CH3%")
            ->limit(5)
            ->get();

        self::assertCount(5, $vibration_value_de);

        Log::info(json_encode($vibration_value_de, JSON_PRETTY_PRINT));
    }

    public function testGetTopFiveVibrationNde()
    {
        $this->seed(DatabaseSeeder::class);

        $vibration_value_nde = DataRecord::query()
            ->select(["funcloc", "emo", "vibration_value_nde", "created_at"])
            ->orderByDesc("vibration_value_nde")
            ->where("funcloc", "LIKE", "%PM3%")
            ->orWhere("funcloc", "LIKE", "%SP3%")
            ->orWhere("funcloc", "LIKE", "%CH3%")
            ->limit(5)
            ->get();

        self::assertCount(5, $vibration_value_nde);

        Log::info(json_encode($vibration_value_nde, JSON_PRETTY_PRINT));
    }

    public function testMethodGetTopFiveTempDe()
    {
        $this->seed(DatabaseSeeder::class);

        function returnTemperatureDe(string $temp_a, string $paper_machine)
        {
            $temperature_a = DataRecord::query()
                ->select(["funcloc", "emo", $temp_a, "created_at"])
                ->orderByDesc($temp_a)
                ->where("funcloc", "LIKE", "%PM$paper_machine%")
                ->orWhere("funcloc", "LIKE", "%SP$paper_machine%")
                ->orWhere("funcloc", "LIKE", "%CH$paper_machine%")
                ->whereBetween("created_at", [Carbon::now()->addMonths(-12), Carbon::now()])
                ->limit(5)
                ->get();

            return $temperature_a;
        }

        $result = returnTemperatureDe("temperature_a", "3");
        self::assertNotNull($result);
        self::assertCount(5, $result);
        Log::info(json_encode($result, JSON_PRETTY_PRINT));
    }

    public function testComment()
    {
        $this->seed(DatabaseSeeder::class);

        $comments = DataRecord::query()
            ->select(["comment", "checked_by", "created_at"])->where("comment", "!=", null)
            ->where("emo", "=", "EMO000426")
            ->orderBy("created_at", "DESC")
            ->get();

        self::assertNotNull($comments);
        Log::info(json_encode($comments, JSON_PRETTY_PRINT));
    }


    // SAVE DATA
    public function testSaveDataFailed()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan",
        ])->post("/checking-form/Fajar-MotorList1804", [
            "funcloc" => null,
            "emo" => null,
            "motor_status" => null,
            "clean_status" => null,
            "nipple_grease_input" => null,
            "number_of_greasing_input" => null,
            "temperature_a" => null,
            "temperature_b" => null,
            "temperature_c" => null,
            "temperature_d" => null,
            "vibration_value_de" => null,
            "vibration_de" => null,
            "vibration_value_nde" => null,
            "vibration_nde" => null,
            "comment" => null,
        ])
            ->assertJson([
                "error" => "All field is required! ⚠️"
            ]);
    }

    public function testSaveDataError()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan",
        ])->post("/checking-form/Fajar-MotorList1804", [
            "funcloc" => "FP-01-SP3-RJS-T092-P092",
            "emo" => "EMO000426",
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

    public function testSaveDataSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        $this->withSession([
            "nik" => "55000154",
            "user" => "Doni Darmawan",
        ])->post("/checking-form/Fajar-MotorList1804", [
            "funcloc" => "FP-01-SP3-RJS-T092-P092",
            "emo" => "EMO000426",
            "motor_status" => "Running",
            "clean_status" => "Clean",
            "nipple_grease_input" => "Available",
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
                "message" => "Saved successfully! ✅"
            ]);
    }
}
