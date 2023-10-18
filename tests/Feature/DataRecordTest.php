<?php

namespace Tests\Feature;

use App\Models\DataRecord;
use App\Models\User;
use Database\Seeders\EmoDetailSeeder;
use Database\Seeders\EmoSeeder;
use Database\Seeders\FunctionLocationSeeder;
use Database\Seeders\UserSeeder;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class DataRecordTest extends TestCase
{
    public function testCreateDataRecord()
    {
        $this->seed([UserSeeder::class, EmoSeeder::class, EmoDetailSeeder::class, FunctionLocationSeeder::class]);

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
}
