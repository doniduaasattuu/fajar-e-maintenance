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
}
