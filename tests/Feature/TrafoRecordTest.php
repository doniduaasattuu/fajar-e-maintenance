<?php

namespace Tests\Feature;

use App\Models\TrafoRecord;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\TrafoRecordSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class TrafoRecordTest extends TestCase
{
    public function testTrafoRecord()
    {
        $records = TrafoRecord::query()->get();
        Log::info(json_encode($records, JSON_PRETTY_PRINT));
        self::assertTrue(true);
    }
}
