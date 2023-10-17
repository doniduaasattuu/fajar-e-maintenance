<?php

namespace Tests\Feature;

use App\Models\Emo;
use App\Models\EmoDetail;
use Carbon\Carbon;
use Database\Seeders\EmoDetailSeeder;
use Database\Seeders\EmoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmoTest extends TestCase
{
    public function testCreateEmo()
    {
        $emo = new Emo();
        $emo->id = "EMO000426";
        $emo->material_number = "10010668";
        $emo->status = "Installed";
        $emo->sort_field = "SP3.P.70/M";
        $emo->unique_id = "1804";
        $emo->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList1804";
        $emo->created_at = Carbon::now();
        $emo->updated_at = Carbon::now();
        $emo->save();

        self::assertNotNull($emo);
    }

    public function testEmoDetailRelations()
    {
        $this->seed([EmoSeeder::class, EmoDetailSeeder::class]);

        $emo = Emo::query()->find("EMO000426");
        $emo_detail = $emo->emoDetail;

        self::assertNotNull($emo_detail);
        self::assertNotNull($emo_detail->power_rate, '75');
        self::assertNotNull($emo_detail->ip_rating, '55');
        self::assertNotNull($emo_detail->cooling_fan, 'Internal');
    }
}
