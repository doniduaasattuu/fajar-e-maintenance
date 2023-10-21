<?php

namespace Tests\Feature;

use App\Models\Emo;
use App\Models\EmoDetail;
use App\Models\FunctionLocation;
use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\EmoDetailSeeder;
use Database\Seeders\EmoSeeder;
use Database\Seeders\FunctionLocationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class EmoTest extends TestCase
{
    public function testCreateEmo()
    {
        $this->seed(FunctionLocationSeeder::class);

        $emo = new Emo();
        $emo->id = "EMO000426";
        $emo->funcloc = "FP-01-SP3-RJS-T092-P092";
        $emo->material_number = "10010668";
        $emo->equipment_description = "AC MOTOR;380V,50Hz,75kW,4P,250M,B3";
        $emo->status = "Installed";
        $emo->sort_field = "SP3.P.70/M";
        $emo->unique_id = "1804";
        $emo->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList1804";
        $emo->created_at = Carbon::now()->toDateTimeString();
        $emo->updated_at = Carbon::now()->toDateTimeString();
        $result = $emo->save();

        self::assertTrue($result);
        self::assertNotNull($emo);
    }

    public function testEmoDetailRelations()
    {
        $this->seed([FunctionLocationSeeder::class, EmoSeeder::class, EmoDetailSeeder::class]);

        $emo = Emo::query()->find("EMO000426");
        $emo_detail = $emo->emoDetails;

        self::assertNotNull($emo_detail);
        self::assertNotNull($emo_detail->power_rate, '75');
        self::assertNotNull($emo_detail->ip_rating, '55');
        self::assertNotNull($emo_detail->cooling_fan, 'Internal');
        Log::info(json_encode($emo, JSON_PRETTY_PRINT));
    }

    public function testEmoFunclocRelations()
    {
        $this->seed([FunctionLocationSeeder::class, EmoSeeder::class, EmoDetailSeeder::class]);

        $emo = Emo::query()->find("EMO000426");
        self::assertNotNull($emo);
        $funcLoc = $emo->funcLoc;

        self::assertNotNull($funcLoc);
        Log::info(json_encode($emo, JSON_PRETTY_PRINT));
    }

    public function testEmoQueryWith()
    {
        $this->seed(DatabaseSeeder::class);

        $emo = Emo::query()->with("funcloc", "emoDetails")->find("EMO000426");
        self::assertNotNull($emo);
        Log::info(json_encode($emo, JSON_PRETTY_PRINT));
    }
}
