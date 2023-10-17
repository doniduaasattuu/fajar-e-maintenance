<?php

namespace Tests\Feature;

use App\Models\Emo;
use App\Models\EmoDetail;
use Database\Seeders\EmoDetailSeeder;
use Database\Seeders\EmoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class EmoDetailTest extends TestCase
{
    public function testCreateEmoDetails()
    {
        $this->seed([EmoSeeder::class]);

        $emo = Emo::query()->find("EMO000426");

        $emo_detail = new EmoDetail();
        $emo_detail->emo = $emo->id;
        $emo_detail->manufacture = "TECO";
        $emo_detail->serial_number = "P9543291";
        $emo_detail->type = "AEEBPA040100YW05T";
        $emo_detail->power_rate = "75";
        $emo_detail->power_unit = "kW";
        $emo_detail->voltage = "380";
        $emo_detail->current_nominal = "140";
        $emo_detail->frequency = "50";
        $emo_detail->pole = "4";
        $emo_detail->rpm = "1475";
        $emo_detail->bearing_de = "NU216";
        $emo_detail->bearing_nde = "6213";
        $emo_detail->frame_type = "250 M";
        $emo_detail->shaft_diameter = 75;
        $emo_detail->phase_supply = "3";
        $emo_detail->cos_phi = "0.84";
        $emo_detail->efficiency = null;
        $emo_detail->ip_rating = "55";
        $emo_detail->insulation_class = "F";
        $emo_detail->duty = "S1";
        $emo_detail->connection_type = "Star-Delta";
        $emo_detail->nipple_grease = "Available";
        $emo_detail->greasing_type = null;
        $emo_detail->greasing_qty_de = null;
        $emo_detail->greasing_qty_nde = null;
        $emo_detail->length = null;
        $emo_detail->width = null;
        $emo_detail->height = 250;
        $emo_detail->weight = null;
        $emo_detail->cooling_fan = "Internal";
        $emo_detail->mounting = "Horizontal";
        $emo_detail->save();

        self::assertNotNull($emo_detail);
        self::assertEquals($emo->id, $emo_detail->emo);
    }

    public function testEmoRelations()
    {
        $this->seed([EmoSeeder::class, EmoDetailSeeder::class]);

        $emo_detail = EmoDetail::query()->where("emo", "=", "EMO000426")->first();
        self::assertNotNull($emo_detail);

        $emo = $emo_detail->emoParent;
        self::assertNotNull($emo);
        self::assertEquals($emo->status, "Installed");
        self::assertEquals($emo->id, $emo_detail->emo);
    }
}
