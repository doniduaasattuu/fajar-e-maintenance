<?php

namespace Tests\Feature;

use App\Models\Trafo;
use App\Services\TrafoService;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\TrafoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TrafoServiceTest extends TestCase
{
    public function testTrafoService()
    {
        $trafoService = $this->app->make(TrafoService::class);
        self::assertNotNull($trafoService);
    }

    public function testTrafoServiceGetAll()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class]);

        $trafoService = $this->app->make(TrafoService::class);
        $trafos = $trafoService->getAll();
        self::assertNotNull($trafos);
        self::assertNotEmpty($trafos);
    }

    public function testTrafoServiceGetColumns()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class]);

        $trafoService = $this->app->make(TrafoService::class);
        $columns = $trafoService->getColumns('trafos');
        self::assertNotNull($columns);
        self::assertCount(10, $columns);
    }

    public function testTrafoServiceGetRegisteredTrafos()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class]);

        $trafoService = $this->app->make(TrafoService::class);
        $trafos = $trafoService->registeredTrafos();
        self::assertNotEmpty($trafos);
        self::assertCount(12, $trafos);
    }

    public function testUpdateTrafoSuccess()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class]);

        $trafo = Trafo::query()->find('ETF000085');
        self::assertNotNull($trafo);
        self::assertEquals('TRAFO PLN', $trafo->sort_field);

        $validated = [
            'id' => $trafo->id,
            'sort_field' => 'TRAFO PLN 1'
        ];

        $trafoService = $this->app->make(TrafoService::class);
        self::assertTrue($trafoService->updateTrafo($validated));

        $trafo = Trafo::query()->find('ETF000085');
        self::assertNotNull($trafo);
        self::assertEquals('TRAFO PLN 1', $trafo->sort_field);
        self::assertNotEquals('TRAFO PLN', $trafo->sort_field);
    }

    public function testTrafoRegisteredUniqueIds()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class]);
        $trafoService = $this->app->make(TrafoService::class);
        $uniqueIds = $trafoService->registeredUniqueIds();
        self::assertNotNull($uniqueIds);
        self::assertNotEmpty($uniqueIds);
        self::assertCount(12, $uniqueIds);
        self::assertTrue(in_array('1', $uniqueIds));
        self::assertTrue(in_array('8', $uniqueIds));
        self::assertTrue(in_array('12', $uniqueIds));
    }

    public function testTrafoRegisteredQrCodeLinks()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class]);

        $trafoService = $this->app->make(TrafoService::class);
        $qrCodeLinks = $trafoService->registeredQrCodeLinks();
        self::assertNotNull($qrCodeLinks);
        self::assertNotEmpty($qrCodeLinks);
        self::assertCount(12, $qrCodeLinks);
        self::assertTrue(in_array('id=Fajar-TrafoList1', $qrCodeLinks));
        self::assertTrue(in_array('id=Fajar-TrafoList4', $qrCodeLinks));
        self::assertTrue(in_array('id=Fajar-TrafoList12', $qrCodeLinks));
    }

    public function testTrafoCodes()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class]);

        $allCodes = DB::table('trafos')->select(DB::raw('DISTINCT LEFT (id, 3) as codes'))->get();
        $trafoCodes = array();
        foreach ($allCodes as $value) {
            array_push($trafoCodes, $value->codes);
        }
        self::assertNotEmpty($trafoCodes);
        self::assertEquals(['ETF'], $trafoCodes);
    }
}
