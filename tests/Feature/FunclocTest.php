<?php

namespace Tests\Feature;

use App\Models\Funcloc;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class FunclocTest extends TestCase
{
    public function testFunclocRelationToMotors()
    {
        $this->seed(DatabaseSeeder::class);

        $funcloc = Funcloc::query()->find('FP-01-SP3-RJS-T092-P092');
        self::assertNotNull($funcloc);

        $motors = $funcloc->Motors;
        self::assertNotNull($motors);
        self::assertCount(1, $motors);
        self::assertEquals('EMO000426', $motors->first()->id);
    }

    public function testFunclocRelationToMotorsNull()
    {
        $this->seed(DatabaseSeeder::class);

        $funcloc = Funcloc::query()->find('FP-01-BO3-CAS-COM2');
        self::assertNotNull($funcloc);

        $motors = $funcloc->Motors;
        self::assertNotNull($motors);
        self::assertCount(0, $motors);
    }
}
