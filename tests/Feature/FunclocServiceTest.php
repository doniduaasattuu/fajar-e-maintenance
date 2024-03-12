<?php

namespace Tests\Feature;

use App\Models\Funcloc;
use App\Services\FunclocService;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\MotorSeeder;
use Tests\TestCase;

class FunclocServiceTest extends TestCase
{
    public function testFunclocService()
    {
        $funclocService = $this->app->make(FunclocService::class);
        self::assertNotNull($funclocService);
    }

    public function testFunclocServiceGetAll()
    {
        $funclocService = $this->app->make(FunclocService::class);
        $funclocs = $funclocService->getAll();
        self::assertNotNull($funclocs);
    }

    public function testFunclocServiceGetTableColumns()
    {
        $funclocService = $this->app->make(FunclocService::class);
        $columns = $funclocService->getTableColumns();
        self::assertNotNull($columns);
        self::assertCount(4, $columns);
    }

    public function testFunclocServiceRegisteredFunclocs()
    {
        $this->seed(FunclocSeeder::class);

        $funclocService = $this->app->make(FunclocService::class);
        $funclocs = $funclocService->registeredFunclocs();
        self::assertNotNull($funclocs);
        self::assertTrue(count($funclocs) > 85);
    }

    public function testUpdateFuncloc()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class]);

        $funcloc = Funcloc::query()->find('FP-01-SP3-RJS-T092-P092');
        self::assertNotNull($funcloc);
        self::assertEquals('PM3.SUM.P70', $funcloc->sort_field);

        $validated = [
            'id' => $funcloc->id,
            'sort_field' => 'PM3.SUM.P-70',
        ];

        $funclocService = $this->app->make(FunclocService::class);
        self::assertTrue($funclocService->updateFuncloc($validated));

        $funcloc = Funcloc::query()->find('FP-01-SP3-RJS-T092-P092');
        self::assertNotEquals('PM3.SUM.P70', $funcloc->sort_field);
        self::assertEquals('PM3.SUM.P-70', $funcloc->sort_field);
    }

    public function testGetAreaFromFuncloc()
    {
        $this->seed(FunclocSeeder::class);

        $funcloc = Funcloc::query()->find('FP-01-BO3-CAS-COM2');
        $area = $funcloc->area;
        self::assertEquals('BO3', $area);
    }
}
