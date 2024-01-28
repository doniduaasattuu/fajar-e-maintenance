<?php

namespace Tests\Feature;

use App\Models\Funcloc;
use App\Models\MotorDetails;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\MotorDetailsSeeder;
use Database\Seeders\MotorSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Tests\TestCase;

class FunclocTest extends TestCase
{
    public function testFunclocRelationToMotors()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        $funcloc = Funcloc::query()->find('FP-01-SP3-RJS-T092-P092');
        self::assertNotNull($funcloc);

        $motors = $funcloc->Motors;
        self::assertNotNull($motors);
        self::assertCount(1, $motors);
        self::assertEquals('EMO000426', $motors->first()->id);
    }

    public function testFunclocRelationToMotorsNull()
    {
        $this->seed(FunclocSeeder::class);

        $funcloc = Funcloc::query()->find('FP-01-BO3-CAS-COM2');
        self::assertNotNull($funcloc);

        $motors = $funcloc->Motors;
        self::assertNotNull($motors);
        self::assertCount(0, $motors);
    }

    public function testFunclocRelationToMotorDetail()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, MotorDetailsSeeder::class]);

        $funcloc = Funcloc::query()->with(['MotorDetail'])->find('FP-01-SP3-RJS-T092-P092');
        $motorDetail = $funcloc->MotorDetail;
        self::assertNotNull($motorDetail);
        self::assertEquals('AEEBPA040100YW05T', $motorDetail->type);
    }

    public function testFunclocRelationToMotorDetailNull()
    {
        $this->seed(FunclocSeeder::class);

        $funcloc = Funcloc::query()->find('FP-01-BO3-CAS-COM2');
        $motorDetail = $funcloc->MotorDetail;
        self::assertNull($motorDetail);
    }

    public function testGetAreaFromFuncloc()
    {
        $this->seed(FunclocSeeder::class);

        $funcloc = Funcloc::query()->find('FP-01-BO3-CAS-COM2');
        $area = $funcloc->area;
        self::assertEquals('BO3', $area);
    }
}
