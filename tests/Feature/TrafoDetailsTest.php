<?php

namespace Tests\Feature;

use App\Models\TrafoDetails;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\TrafoDetailsSeeder;
use Database\Seeders\TrafoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TrafoDetailsTest extends TestCase
{
    public function testTrafoDetailsRelationToTrafo()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class]);

        $trafoDetail = TrafoDetails::query()->with(['Trafo'])->where('trafo_detail', 'ETF000060')->first();
        self::assertNotNull($trafoDetail);
        $trafo = $trafoDetail->Trafo;
        self::assertNotNull($trafo);
        self::assertEquals('ETF000060', $trafo->id);
        self::assertEquals('id=Fajar-TrafoList3', $trafo->qr_code_link);
    }

    public function testTrafoDetailsRelationToTrafoNull()
    {
        $this->seed([FunclocSeeder::class, trafoSeeder::class, trafoDetailsSeeder::class]);

        $trafoDetail = TrafoDetails::query()->with(['Trafo'])->where('trafo_detail', 'ETF000000')->first();
        self::assertNull($trafoDetail);
    }

    public function testTrafoDetailsRelationToFuncloc()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class]);

        $trafoDetail = TrafoDetails::query()->with(['Trafo', 'Funcloc'])->where('trafo_detail', 'ETF000027')->first();
        self::assertNotNull($trafoDetail);
        $funcloc = $trafoDetail->Funcloc;
        self::assertNotNull($funcloc);
        self::assertEquals('Trafo PLN1', $funcloc->description);
    }

    public function testTrafoDetailsRelationToFunclocNull()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class]);

        $trafoDetail = TrafoDetails::query()->with(['Trafo', 'Funcloc'])->where('trafo_detail', 'ETF001234')->first();
        self::assertNull($trafoDetail);
    }
}
