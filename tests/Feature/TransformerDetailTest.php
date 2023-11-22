<?php

namespace Tests\Feature;

use App\Models\TransformerDetail;
use App\Models\Transformers;
use Database\Seeders\FunctionLocationSeeder;
use Database\Seeders\TransformerDetailSeeder;
use Database\Seeders\TransformersSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransformerDetailTest extends TestCase
{
    public function testCreateTransformerDetails()
    {
        $this->seed([FunctionLocationSeeder::class, TransformersSeeder::class]);

        $transformer = Transformers::query()->find("ETF000085");

        $trafo_details = new TransformerDetail();
        $trafo_details->transformer_detail = "ETF000085";
        $trafo_details->power_rate = "50000";
        $trafo_details->power_unit = "kVA";
        $trafo_details->primary_voltage = "150000";
        $trafo_details->secondary_voltage = "20000";
        $trafo_details->primary_current = "192";
        $trafo_details->secondary_current = "1443";
        $trafo_details->primary_connection_type = "Delta";
        $trafo_details->secondary_connection_type = "Star";
        $trafo_details->type = "Step Down";
        $trafo_details->manufacturer = "Unindo";
        $trafo_details->year_of_manufacture = "2012";
        $trafo_details->serial_number = "P050LEC692";
        $trafo_details->vector_group = "Ynyn 0 + d";
        $trafo_details->frequency = "50";
        $trafo_details->insulation_class = null;
        $trafo_details->type_of_cooling = "ONAN/ONAF";
        $trafo_details->temp_rise_oil_winding = null;
        $trafo_details->weight = null;
        $trafo_details->weight_of_oil = null;
        $trafo_details->oil_type = null;
        $trafo_details->ip_rating = null;
        $result = $trafo_details->save();

        self::assertTrue($result);
        self::assertNotNull($trafo_details);
        self::assertEquals($trafo_details->transformer_detail, $transformer->id);
        self::assertEquals($transformer->funcLoc->id, $trafo_details->funcLoc->id);
    }

    public function testTransformerDetailsToTransformersRelations()
    {
        $this->seed([FunctionLocationSeeder::class, TransformersSeeder::class, TransformerDetailSeeder::class]);

        $trafo_details = TransformerDetail::query()->where("transformer_detail", "=", "ETF000085")->first();
        self::assertNotNull($trafo_details);

        $transformer = $trafo_details->transformer;
        self::assertNotNull($transformer);
        self::assertEquals($transformer->status, "Installed");
        self::assertEquals($transformer->id, $trafo_details->transformer_detail);
    }

    public function testTransformersDetailsToFunclocRelations()
    {
        $this->seed([FunctionLocationSeeder::class, TransformersSeeder::class, TransformerDetailSeeder::class]);

        $transformers_details = TransformerDetail::query()->with("funcloc", "transformer")->where("transformer_detail", "=", "ETF000085")->first();
        self::assertNotNull($transformers_details);

        $funcloc = $transformers_details->funcloc;
        self::assertNotNull($funcloc);
        self::assertEquals("TRAFO ENC", $funcloc->tag_name);
        self::assertEquals("FP-01-IN1", $transformers_details->funcloc->id);
    }

    public function testTransformerDetailQueryWith()
    {
        $this->seed([FunctionLocationSeeder::class, TransformersSeeder::class, TransformerDetailSeeder::class]);

        $transformer_details = TransformerDetail::query()->with("funcloc", "transformer")->where("transformer_detail", "=", "ETF000085")->first();
        self::assertNotNull($transformer_details);
        self::assertNotNull($transformer_details->funcLoc->id);
        self::assertNotNull($transformer_details->transformer->id);
    }
}
