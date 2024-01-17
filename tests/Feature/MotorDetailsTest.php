<?php

namespace Tests\Feature;

use App\Models\MotorDetails;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class MotorDetailsTest extends TestCase
{
    public function testMotorDetailsRelationToMotor()
    {
        $this->seed(DatabaseSeeder::class);

        $motorDetail = MotorDetails::query()->with(['Motor'])->where('motor_detail', 'EMO000426')->first();
        self::assertNotNull($motorDetail);
        $motor = $motorDetail->Motor;
        self::assertNotNull($motor);
        self::assertEquals('EMO000426', $motor->id);
        self::assertEquals('1804', $motor->unique_id);
    }

    public function testMotorDetailsRelationToMotorNull()
    {
        $this->seed(DatabaseSeeder::class);

        $motorDetail = MotorDetails::query()->with(['Motor'])->where('motor_detail', 'EMO000008')->first();
        self::assertNull($motorDetail);
    }

    public function testMotorDetailsRelationToFuncloc()
    {
        $this->seed(DatabaseSeeder::class);

        $motorDetail = MotorDetails::query()->with(['Motor', 'Funcloc'])->where('motor_detail', 'EMO000426')->first();
        self::assertNotNull($motorDetail);
        $funcloc = $motorDetail->Funcloc;
        self::assertNotNull($funcloc);
        self::assertEquals('PM3.SUM.P70', $funcloc->description);
    }

    public function testMotorDetailsRelationToFunclocNull()
    {
        $this->seed(DatabaseSeeder::class);

        $motorDetail = MotorDetails::query()->with(['Motor', 'Funcloc'])->where('motor_detail', 'EMO000023')->first();
        self::assertNull($motorDetail);
    }
}
