<?php

namespace Tests\Feature;

use App\Models\EmoDetail;
use App\Models\FunctionLocation;
use Database\Seeders\EmoDetailSeeder;
use Database\Seeders\EmoSeeder;
use Database\Seeders\FunctionLocationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class FuncLocTest extends TestCase
{
    public function testCreateFuncloc()
    {
        $funcloc = new FunctionLocation();
        $funcloc->id = "FP-01-SP3-RJS-T092-P092";
        $funcloc->tag_name = "Pompa P-70";
        $funcloc->created_at = Carbon::now()->toDateTimeString();
        $funcloc->updated_at = Carbon::now()->toDateTimeString();
        $result = $funcloc->save();

        self::assertTrue($result);
        self::assertNotNull($funcloc);
        Log::info(json_encode($funcloc, JSON_PRETTY_PRINT));
    }

    public function testFunclocEmoRelations()
    {
        $this->seed([FunctionLocationSeeder::class, EmoSeeder::class]);
        $funcloc = FunctionLocation::query()->find("FP-01-SP3-RJS-T092-P092");
        $emos = $funcloc->emos;

        self::assertNotNull($emos);
        Log::info(json_encode($funcloc, JSON_PRETTY_PRINT));
    }

    public function testFunclocEmoDetailRelations()
    {
        $this->seed([FunctionLocationSeeder::class, EmoSeeder::class, EmoDetailSeeder::class]);

        $funcloc = FunctionLocation::query()->with("emos")->find("FP-01-SP3-RJS-T092-P092");
        $emoDetail = $funcloc->emoDetail;

        self::assertNotNull($emoDetail);
        Log::info(json_encode($funcloc, JSON_PRETTY_PRINT));
    }
}
