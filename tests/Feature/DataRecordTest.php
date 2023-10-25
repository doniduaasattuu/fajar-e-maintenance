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
        $data_record->vibration_de = "Normal";
        $data_record->vibration_value_nde = 0.58;
        $data_record->vibration_nde = "Normal";
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
        $startDate = Carbon::now()->addYears(-1);

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
                "error" => "All data is required! ⚠️"
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
            "vibration_de" => "Normal",
            "vibration_value_nde" => "0.35",
            "vibration_nde" => "Normal",
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
            ->assertDontSeeText("All data is required! ⚠️")
            ->assertDontSeeText("Saved successfully! ✅");
    }

    public function testGetEmoDatalistRecord()
    {

        $this->seed(DatabaseSeeder::class);

        $emo = DataRecord::query()->select("emo")->distinct()->get();
        self::assertNotNull($emo);
        Log::info(json_encode($emo, JSON_PRETTY_PRINT));
    }

    public function testGetTopFiveTemp()
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
}
