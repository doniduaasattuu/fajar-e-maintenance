<?php

namespace Tests\Feature;

use App\Models\EmoDetail;
use App\Models\FunctionLocation;
use Database\Seeders\EmoDetailSeeder;
use Database\Seeders\EmoSeeder;
use Database\Seeders\FunctionLocationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class FuncLocTest extends TestCase
{
    public function testCreateFuncloc()
    {
        $this->seed([EmoSeeder::class, EmoDetailSeeder::class]);

        $funloc = new FunctionLocation();
        $funloc->id = "FP-01-SP3-RJS-T092-P092";
        $funloc->emo = "EMO000426";
        $funloc->tag_name = "Pompa P-70";
        $funloc->save();

        self::assertNotNull($funloc);
    }

    public function testFunclocEmoRelations()
    {
        $this->seed([EmoSeeder::class, EmoDetailSeeder::class, FunctionLocationSeeder::class]);

        $funcloc = FunctionLocation::query()->find("FP-01-SP3-RJS-T092-P092");
        $emo = $funcloc->emoChild;

        self::assertNotNull($emo);
        Log::info(json_encode($emo, JSON_PRETTY_PRINT));
    }

    public function testFunclocEmoDetailRelations()
    {
        $this->seed([EmoSeeder::class, EmoDetailSeeder::class, FunctionLocationSeeder::class]);

        $funcloc = FunctionLocation::query()->find("FP-01-SP3-RJS-T092-P092");
        $emoDetail = $funcloc->emoDetail;

        self::assertNotNull($emoDetail);
        Log::info(json_encode($emoDetail, JSON_PRETTY_PRINT));
    }

    public function testFunclocQueryWith()
    {
        $this->seed([EmoSeeder::class, EmoDetailSeeder::class, FunctionLocationSeeder::class]);

        $funcloc = FunctionLocation::query()->with(["emoChild", "emoDetail"])->find("FP-01-SP3-RJS-T092-P092");
        self::assertNotNull($funcloc);
        Log::info(json_encode($funcloc, JSON_PRETTY_PRINT));
    }
}
