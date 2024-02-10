<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Database\Seeders\FindingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class FindingServiceTest extends TestCase
{

    public function testGetEquipments()
    {
        $this->seed(FindingSeeder::class);

        $equipments = DB::table('findings')->distinct()->get(['equipment']);
        $equipments = $equipments->map(function ($value, $key) {
            return $value->equipment;
        });
        Log::info(json_encode($equipments->whereNotNull()->all(), JSON_PRETTY_PRINT));
        self::assertTrue(true);
    }
}
