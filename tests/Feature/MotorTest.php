<?php

namespace Tests\Feature;

use App\Models\Motor;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class MotorTest extends TestCase
{
    public function testMotorRelationToFuncloc()
    {
        $this->seed(DatabaseSeeder::class);

        $motor = Motor::query()->find('EMO000426');
        self::assertNotNull($motor);

        $funcloc = $motor->Funcloc;
        self::assertNotNull($funcloc);
    }

    public function testMotorRelationToFunclocNull()
    {
        $this->seed(DatabaseSeeder::class);

        $motor = Motor::query()->find('EMO000008');
        self::assertNotNull($motor);

        $funcloc = $motor->Funcloc;
        self::assertNull($funcloc);
    }

    public function testMotorRelationToMotorDetail()
    {
        $this->seed(DatabaseSeeder::class);

        $motor = Motor::query()->find('EMO000426');
        $motorDetail = $motor->MotorDetail;
        self::assertNotNull($motorDetail);
        self::assertEquals('AEEBPA040100YW05T', $motorDetail->type);
    }

    public function testMotorQueryWithMotorDetail()
    {
        $this->seed(DatabaseSeeder::class);

        $motor = Motor::query()->with(['MotorDetail'])->find('EMO000426');
        $motorDetail = $motor->MotorDetail;
        self::assertNotNull($motorDetail);
        self::assertEquals('AEEBPA040100YW05T', $motorDetail->type);
        Log::info(json_encode($motor, JSON_PRETTY_PRINT));
    }
}