<?php

namespace Tests\Feature;

use App\Models\Trafo;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\TrafoDetailsSeeder;
use Database\Seeders\TrafoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TrafoTest extends TestCase
{
    public function testTrafoRelationToFuncloc()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class]);

        $trafo = Trafo::query()->find('ETF000085');
        self::assertNotNull($trafo);

        $funcloc = $trafo->Funcloc;
        self::assertNotNull($funcloc);
        self::assertEquals($funcloc->id, 'FP-01-IN1');
    }

    public function testTrafoRelationToFunclocNull()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class]);

        $trafo = Trafo::query()->find('ETF001234');
        self::assertNotNull($trafo);

        $funcloc = $trafo->Funcloc;
        self::assertNull($funcloc);
    }

    public function testTrafoRelationToMotorDetail()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class]);

        $trafo = Trafo::query()->find('ETF000026');
        $trafoDetail = $trafo->TrafoDetail;
        self::assertNotNull($trafoDetail);
        self::assertEquals('Pauwels Trafo', $trafoDetail->manufacturer);
        self::assertEquals('510', $trafoDetail->weight_of_oil);
    }

    public function testTrafoQueryWithMotorDetail()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class]);

        $trafo = Trafo::query()->with(['TrafoDetail'])->find('ETF000026');
        $trafoDetail = $trafo->TrafoDetail;
        self::assertNotNull($trafoDetail);
        self::assertEquals('Pauwels Trafo', $trafoDetail->manufacturer);
        self::assertEquals('510', $trafoDetail->weight_of_oil);
    }
}
