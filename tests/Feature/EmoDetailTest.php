<?php

namespace Tests\Feature;

use App\Models\Emo;
use App\Models\EmoDetail;
use App\Models\FunctionLocation;
use Database\Seeders\EmoDetailSeeder;
use Database\Seeders\EmoSeeder;
use Database\Seeders\FunctionLocationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class EmoDetailTest extends TestCase
{
    public function testCreateEmoDetails()
    {
        $this->seed([FunctionLocationSeeder::class, EmoSeeder::class]);

        $emo = Emo::query()->find("EMO000426");
        Log::info(json_encode($emo, JSON_PRETTY_PRINT));

        $emo_details = new EmoDetail();
        $emo_details->emo_detail = "EMO000426";
        $emo_details->manufacture = "TECO";
        $emo_details->serial_number = "P9543291";
        $emo_details->type = "AEEBPA040100YW05T";
        $emo_details->power_rate = "75";
        $emo_details->power_unit = "kW";
        $emo_details->voltage = "380";
        $emo_details->current_nominal = "140";
        $emo_details->frequency = "50";
        $emo_details->pole = "4";
        $emo_details->rpm = "1475";
        $emo_details->bearing_de = "NU216";
        $emo_details->bearing_nde = "6213";
        $emo_details->frame_type = "250 M";
        $emo_details->shaft_diameter = 75;
        $emo_details->phase_supply = "3";
        $emo_details->cos_phi = "0.84";
        $emo_details->efficiency = null;
        $emo_details->ip_rating = "55";
        $emo_details->insulation_class = "F";
        $emo_details->duty = "S1";
        $emo_details->connection_type = "Star-Delta";
        $emo_details->nipple_grease = "Available";
        $emo_details->greasing_type = null;
        $emo_details->greasing_qty_de = null;
        $emo_details->greasing_qty_nde = null;
        $emo_details->length = null;
        $emo_details->width = null;
        $emo_details->height = 250;
        $emo_details->weight = null;
        $emo_details->cooling_fan = "Internal";
        $emo_details->mounting = "Horizontal";
        $result = $emo_details->save();

        self::assertTrue($result);
        self::assertNotNull($emo_details);
        self::assertEquals($emo_details->emo_detail, $emo->id);
        Log::info(json_encode($emo_details, JSON_PRETTY_PRINT));
    }

    public function testEmoDetailsEmoRelations()
    {
        $this->seed([FunctionLocationSeeder::class, EmoSeeder::class, EmoDetailSeeder::class]);

        $emo_details = EmoDetail::query()->where("emo_detail", "=", "EMO000426")->first();
        self::assertNotNull($emo_details);
        Log::info(json_encode($emo_details, JSON_PRETTY_PRINT));

        $emo = $emo_details->emo;
        self::assertEquals($emo->status, "Installed");
        self::assertEquals($emo->id, $emo_details->emo_detail);
    }

    public function testEmoDetailsFunclocRelations()
    {
        $this->seed([FunctionLocationSeeder::class, EmoSeeder::class, EmoDetailSeeder::class]);

        $emo_details = EmoDetail::query()->with("funcloc", "emo")->where("emo_detail", "=", "EMO000426")->first();
        self::assertNotNull($emo_details);
        Log::info(json_encode($emo_details, JSON_PRETTY_PRINT));

        $funcloc = $emo_details->funcloc;
        self::assertEquals("Pompa P-70", $funcloc->tag_name);
        Log::info(json_encode($funcloc, JSON_PRETTY_PRINT));
    }

    public function testEmoDetailQueryWith()
    {
        $this->seed([FunctionLocationSeeder::class, EmoSeeder::class, EmoDetailSeeder::class]);

        $emo_details = EmoDetail::query()->with("funcloc", "emo")->where("emo_detail", "=", "EMO000426")->first();
        self::assertNotNull($emo_details);
        Log::info(json_encode($emo_details, JSON_PRETTY_PRINT));
    }
}
