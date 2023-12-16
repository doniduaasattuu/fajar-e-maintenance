<?php

namespace Tests\Feature;

use App\Models\EmoDetail;
use App\Models\FunctionLocation;
use Database\Seeders\EmoDetailSeeder;
use Database\Seeders\EmoSeeder;
use Database\Seeders\FunctionLocationSeeder;
use Database\Seeders\TransformersSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class FuncLocTest extends TestCase
{
    public function testCreateFuncloc()
    {
        $funcloc = new FunctionLocation();
        $funcloc->id = "FP-01-SP3-RJS-T092-P092";
        $funcloc->tag_name = "SP3.P.70/M";
        $funcloc->created_at = Carbon::now()->toDateTimeString();
        $funcloc->updated_at = Carbon::now()->toDateTimeString();
        $result = $funcloc->save();

        self::assertTrue($result);
        self::assertNotNull($funcloc);
        self::assertEquals("SP3.P.70/M", $funcloc->tag_name);
    }

    public function testFunclocToEmoRelations()
    {
        $this->seed([FunctionLocationSeeder::class, EmoSeeder::class]);

        $funcloc = FunctionLocation::query()->find("FP-01-SP3-RJS-T092-P092");
        $emos = $funcloc->emos;

        self::assertNotNull($emos);
        self::assertCount(1, $emos);
    }

    public function testFunclocToEmoDetailRelations()
    {
        $this->seed([FunctionLocationSeeder::class, EmoSeeder::class, EmoDetailSeeder::class]);

        $funcloc = FunctionLocation::query()->with("emos")->find("FP-01-SP3-RJS-T092-P092");
        $emoDetail = $funcloc->emoDetail;

        self::assertNotNull($emoDetail);
        self::assertEquals("Horizontal", $emoDetail->mounting);
    }

    public function testFunclocToTransformersRelations()
    {
        $this->seed([FunctionLocationSeeder::class, TransformersSeeder::class]);

        $funcloc = FunctionLocation::query()->find("FP-01-IN1");
        $transformers = $funcloc->transformers;

        self::assertNotNull($transformers);
        self::assertCount(1, $transformers);
    }
}
