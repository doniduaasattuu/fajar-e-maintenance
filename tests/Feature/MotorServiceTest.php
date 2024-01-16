<?php

namespace Tests\Feature;

use App\Models\Motor;
use App\Services\MotorService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
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

    public function testUpdateMotor()
    {
        $this->seed(DatabaseSeeder::class);

        $motor = Motor::query()->find('EMO000105');
        self::assertNotNull($motor);
        self::assertEquals('AC MOTOR;380V,50Hz,7.5kW,4P,132M,B3', $motor->description);

        $validated = [
            'id' => $motor->id,
            'description' => 'AC MOTOR;380V,50Hz,75kW,4P,132M,B3',
        ];

        $motorService = $this->app->make(motorService::class);
        self::assertTrue($motorService->updateMotor($validated));

        $motor = motor::query()->find('EMO000105');
        self::assertNotEquals('AC MOTOR;380V,50Hz,7.5kW,4P,132M,B3', $motor->description);
        self::assertEquals('AC MOTOR;380V,50Hz,75kW,4P,132M,B3', $motor->description);
    }

    public function testRegisteredUniqueIds()
    {
        $this->seed(DatabaseSeeder::class);

        $motorService = $this->app->make(MotorService::class);
        $uniqueIds = $motorService->registeredUniqueIds();
        self::assertNotNull($uniqueIds);
        self::assertCount(22, $uniqueIds);
        self::assertTrue(in_array('2100', $uniqueIds));
        self::assertTrue(in_array('9999', $uniqueIds));
        self::assertFalse(in_array('1010', $uniqueIds));
    }

    public function testRegisteredQrCodeLinks()
    {
        $this->seed(DatabaseSeeder::class);

        $motorService = $this->app->make(MotorService::class);
        $qrCodeLinks = $motorService->registeredQrCodeLinks();
        self::assertNotNull($qrCodeLinks);
        self::assertCount(22, $qrCodeLinks);
        self::assertTrue(in_array('https://www.safesave.info/MIC.php?id=Fajar-MotorList4592', $qrCodeLinks));
        self::assertTrue(in_array('https://www.safesave.info/MIC.php?id=Fajar-MotorList155', $qrCodeLinks));
        self::assertFalse(in_array('https://www.safesave.info/MIC.php?id=Fajar-MotorList111', $qrCodeLinks));
    }
}
