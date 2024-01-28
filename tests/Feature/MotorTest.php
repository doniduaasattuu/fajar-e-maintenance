<?php

namespace Tests\Feature;

use App\Models\Motor;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\MotorDetailsSeeder;
use Database\Seeders\MotorSeeder;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class MotorTest extends TestCase
{
    public function testMotorRelationToFuncloc()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class]);

        $motor = Motor::query()->find('EMO000426');
        self::assertNotNull($motor);

        $funcloc = $motor->Funcloc;
        self::assertNotNull($funcloc);
    }

    public function testMotorRelationToFunclocNull()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class]);

        $motor = Motor::query()->find('EMO000008');
        self::assertNotNull($motor);

        $funcloc = $motor->Funcloc;
        self::assertNull($funcloc);
    }

    public function testMotorRelationToMotorDetail()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        $motor = Motor::query()->find('MGM000481');
        $motorDetail = $motor->MotorDetail;
        self::assertNotNull($motorDetail);
        self::assertEquals('Vertical', $motorDetail->mounting);
        self::assertEquals('IC-F/FB-B8', $motorDetail->type);
        Log::info(json_encode($motor, JSON_PRETTY_PRINT));
    }

    public function testMotorQueryWithMotorDetail()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        $motor = Motor::query()->with(['MotorDetail'])->find('EMO000426');
        $motorDetail = $motor->MotorDetail;
        self::assertNotNull($motorDetail);
        self::assertEquals('AEEBPA040100YW05T', $motorDetail->type);
        Log::info(json_encode($motor, JSON_PRETTY_PRINT));
    }
}
