<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class DatabaseTest extends TestCase
{
    public function testRawQuery()
    {
        // $this->seed(UserSeeder::class);
        $departments = DB::unprepared("SHOW COLUMNS FROM users");
        Log::info(json_encode($departments, JSON_PRETTY_PRINT));
        self::assertNotNull($departments);
    }
}
