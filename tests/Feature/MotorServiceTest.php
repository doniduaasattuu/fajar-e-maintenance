<?php

namespace Tests\Feature;

use App\Services\MotorService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MotorServiceTest extends TestCase
{
    public function testMotorService()
    {
        $motorService = $this->app->make(MotorService::class);
        self::assertNotNull($motorService);
    }
    public function testMotorServiceGetAll()
    {
        $motorService = $this->app->make(MotorService::class);
        $motors = $motorService->getAll();
        self::assertNotNull($motors);
    }

    public function testMotorServiceGetTableColumns()
    {
        $motorService = $this->app->make(MotorService::class);
        $columns = $motorService->getTableColumns();
        self::assertNotNull($columns);
        self::assertCount(10, $columns);
    }

    public function testMotorServiceRegisteredMotors()
    {
        $this->seed(DatabaseSeeder::class);

        $motorService = $this->app->make(MotorService::class);
        $motors = $motorService->registeredMotors();
        self::assertNotNull($motors);
        self::assertCount(22, $motors);
    }
}
