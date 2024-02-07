<?php

namespace Tests\Feature;

use App\Models\Finding;
use Database\Seeders\FindingSeeder;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\MotorSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\TrafoSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class FindingTest extends TestCase
{
    public function testGetFirstFinding()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, FindingSeeder::class, UserSeeder::class, RoleSeeder::class]);

        $finding = Finding::query()->first();
        self::assertNotNull($finding);
        self::assertEquals(13, strlen($finding->id));
    }
}
