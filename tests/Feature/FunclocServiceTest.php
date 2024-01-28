<?php

namespace Tests\Feature;

use App\Models\Funcloc;
use App\Services\FunclocService;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\MotorSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
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
        self::assertCount(13, $funclocs);
    }

    public function testUpdateFuncloc()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class]);

        $funcloc = Funcloc::query()->find('FP-01-SP3-RJS-T092-P092');
        self::assertNotNull($funcloc);
        self::assertEquals('PM3.SUM.P70', $funcloc->description);

        $validated = [
            'id' => $funcloc->id,
            'description' => 'PM3.SUM.P-70',
        ];

        $funclocService = $this->app->make(FunclocService::class);
        self::assertTrue($funclocService->updateFuncloc($validated));

        $funcloc = Funcloc::query()->find('FP-01-SP3-RJS-T092-P092');
        self::assertNotEquals('PM3.SUM.P70', $funcloc->description);
        self::assertEquals('PM3.SUM.P-70', $funcloc->description);
    }
}
