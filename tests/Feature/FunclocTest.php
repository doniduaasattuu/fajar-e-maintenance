<?php

namespace Tests\Feature;

use App\Models\Funcloc;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\MotorDetailsSeeder;
use Database\Seeders\MotorSeeder;
use Database\Seeders\TrafoDetailsSeeder;
use Database\Seeders\TrafoSeeder;
use Illuminate\Support\Facades\Log;
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

    public function testFunclocRelationToTrafos()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class]);

        $funcloc = Funcloc::query()->find('FP-01-GT1-TRF-PWP1');
        self::assertNotNull($funcloc);

        $trafos = $funcloc->Trafos;
        self::assertNotNull($trafos);
        self::assertCount(1, $trafos);
        self::assertEquals('ETF000060', $trafos->first()->id);
    }

    public function testFunclocRelationToTrafosMany()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class]);

        $funcloc = Funcloc::query()->find('FP-01-IN1');
        self::assertNotNull($funcloc);

        $trafos = $funcloc->Trafos;
        self::assertNotNull($trafos);
        self::assertCount(4, $trafos);
    }

    public function testFunclocRelationToTrafosNull()
    {
        $this->seed(FunclocSeeder::class);

        $funcloc = Funcloc::query()->find('FP-01-SP1-UKP-RF07');
        self::assertNotNull($funcloc);

        $trafos = $funcloc->Trafos;
        self::assertNotNull($trafos);
        self::assertCount(0, $trafos);
    }

    public function testFunclocRelationToTrafoDetail()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class]);

        $funcloc = Funcloc::query()->with(['TrafoDetail'])->find('FP-01-GT1-TRF-PWP1');
        $trafoDetail = $funcloc->TrafoDetail;
        self::assertNotNull($trafoDetail);
        Log::info(json_encode($trafoDetail, JSON_PRETTY_PRINT));
        self::assertEquals('8470', $trafoDetail->weight_of_oil);
    }

    public function testFunclocRelationToTrafoDetailMany()
    {
        $this->seed([FunclocSeeder::class, TrafoSeeder::class, TrafoDetailsSeeder::class]);

        $funcloc = Funcloc::query()->with(['TrafoDetail'])->find('FP-01-IN1');
        $firstTrafoDetail = $funcloc->TrafoDetail;
        self::assertNotNull($firstTrafoDetail);
        self::assertEquals('ETF000085', $firstTrafoDetail->trafo_detail);
        self::assertEquals('P050LEC692', $firstTrafoDetail->serial_number);
    }

    public function testFunclocRelationToTrafoDetailNull()
    {
        $this->seed(FunclocSeeder::class);

        $funcloc = Funcloc::query()->find('FP-01-BO3-CAS-COM2');
        $trafoDetail = $funcloc->trafoDetail;
        self::assertNull($trafoDetail);
    }

    public function testAreas()
    {
        $this->seed(FunclocSeeder::class);

        $funcloc = Funcloc::query()->pluck('id');
        $areas = $funcloc->map(function ($value, $key) {
            return explode('-', $value)[2];
        });
        self::assertNotNull($areas);
        Log::info(json_encode(array_unique($areas->toArray()), JSON_PRETTY_PRINT));
    }
}
